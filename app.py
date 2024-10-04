from flask import Flask, request, jsonify
import pdfplumber
import os
import shutil
from flask_cors import CORS
import re
import mysql.connector

app = Flask(__name__)
CORS(app)

# Folder untuk menyimpan file PDF sementara
UPLOAD_FOLDER = 'C:/xampp/htdocs/stockbarang/uploads'
# Folder tujuan untuk menyimpan file PDF
TARGET_FOLDER = 'C:/xampp/htdocs/stockbarang/PDF PO'
os.makedirs(UPLOAD_FOLDER, exist_ok=True)
os.makedirs(TARGET_FOLDER, exist_ok=True)
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

# Konfigurasi koneksi ke database
db = mysql.connector.connect(
    host="localhost",
    user="root",  # Sesuaikan dengan user MySQL Anda
    password="",  # Sesuaikan dengan password MySQL Anda
    database="stockbarang"
)

@app.route('/upload', methods=['POST'])
def upload_file():
    if 'file' not in request.files:
        return jsonify({'error': 'No file part'}), 400
    file = request.files['file']
    if file.filename == '':
        return jsonify({'error': 'No selected file'}), 400

    if file and file.filename.endswith('.pdf'):
        # Cek apakah file sudah ada di TARGET_FOLDER
        target_file_path = os.path.join(TARGET_FOLDER, file.filename)
        if os.path.exists(target_file_path):
            return jsonify({'message': 'pdf sudah ada'}), 200  # Ubah ini untuk mengembalikan pesan jika file sudah ada

        filepath = os.path.join(app.config['UPLOAD_FOLDER'], file.filename)
        file.save(filepath)

        extracted_data = extract_pdf_data(filepath)

        return jsonify({
            'message': 'File uploaded successfully',
            'file_name': file.filename,
            'extracted_data': extracted_data
        }), 200
    else:
        return jsonify({'error': 'Invalid file format'}), 400

@app.route('/submit', methods=['POST'])
def submit_file():
    data = request.json
    extracted_data = data.get('extracted_data', {})
    file_name = data.get('file_name')
    document_value = data.get('document')

    po_number = extracted_data.get('po_number')
    po_type = extracted_data.get('poType')
    material_data = extracted_data.get('data', [])

    try:
        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="stockbarang"
        )
        cursor = conn.cursor()

        for item in material_data:
            partnumberSIS = item.get('material')
            qty = item.get('qty')
            MOno = item.get('moNumber')
            price = item.get('totalPrice')

            try:
                qty = int(qty) if qty else 0
                MOno = int(MOno) if MOno else 0
                price = float(price.replace(',', '').replace(' ', '')) if price else 0.0
            except ValueError as e:
                print(f"Error converting values: {e}")
                continue

            # Ambil data dari datastock, termasuk qty saat ini
            cursor.execute("SELECT partnumber, description, location FROM datastock WHERE pnsis = %s", (partnumberSIS,))
            result = cursor.fetchone()

            if result:
                partnumber, description, location = result
            else:
                # Jika tidak ada data di datastock, atur nilai default
                partnumber, description, location = None, None, None

            # Cek apakah data dengan kombinasi partnumberSIS dan MOno sudah ada
            cursor.execute("""
                SELECT COUNT(*) FROM partdo 
                WHERE partnumberSIS = %s AND MOno = %s AND qty = %s
            """, (partnumberSIS, MOno, qty))
            exists = cursor.fetchone()[0]

            if exists > 0:
                # Jika ada, update POno, tipePO, dan price
                cursor.execute("""
                    UPDATE partdo 
                    SET POno = %s, tipePO = %s, price = %s 
                    WHERE partnumberSIS = %s AND MOno = %s AND qty = %s
                """, (po_number, po_type, price, partnumberSIS, MOno, qty))
            else:
                # Jika tidak ada, lakukan insert dan kurangi qty dari datastock
                cursor.execute("""
                    INSERT INTO partdo (POno, partnumberSIS, qty, MOno, price, document, tipePO, partnumber, description, location)
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
                """, (po_number, partnumberSIS, qty, MOno, price, document_value, po_type, partnumber, description, location))

                # Kurangi kuantitas dari datastock
                cursor.execute("""
                    UPDATE datastock 
                    SET qty = qty - %s 
                    WHERE pnsis = %s
                """, (qty, partnumberSIS))

        conn.commit()

        # Pindahkan file ke folder tujuan setelah data berhasil disimpan
        source_file_path = os.path.join(app.config['UPLOAD_FOLDER'], file_name)
        target_file_path = os.path.join(TARGET_FOLDER, file_name)
        shutil.move(source_file_path, target_file_path)

        return jsonify({
            'message': 'Data berhasil dimasukkan ke dalam database dan file dipindahkan',
        }), 200
    except Exception as e:
        return jsonify({'error': str(e)}), 500
    finally:
        cursor.close()
        conn.close()




def extract_pdf_data(pdf_path):
    data = []
    po_type = "Tidak ditemukan"
    po_number = "Tidak ditemukan"
    sub_total = "Tidak ditemukan"
    discount = "Tidak ditemukan"
    surcharge = "Tidak ditemukan"
    freight = "Tidak ditemukan"
    total_net = "Tidak ditemukan"
    vat = "Tidak ditemukan"
    total_amount = "Tidak ditemukan"

    # Regex untuk kode material yang lebih baik
    material_regex = re.compile(r'MA[A-Z0-9/.-]+(?:-\w+)?|\d{7}')   # Update sesuai dengan format yang diinginkan
    number_regex = re.compile(r'\d+(?:,\d{3})*(?:\.\d{2})?')

    with pdfplumber.open(pdf_path) as pdf:
        for page_number, page in enumerate(pdf.pages, start=1):
            text = page.extract_text()
            if text:
                lines = text.split('\n')
                combined_lines = ' '.join(lines).replace(" ", "").replace("\n", "")
                if "PURCHASEORDERNO:" in combined_lines:
                    po_number = combined_lines.split("PURCHASEORDERNO:")[-1][:10]

                for line in lines:
                    if "PO Type :" in line:
                        po_type = line.split("PO Type :")[-1].strip()
                        if ":" in po_type:
                            po_type = po_type.split(":")[-1].strip()
                    elif "POType" in line.replace(" ", ""):
                        po_type = line.split("POType")[-1].strip()

                po_type = po_type.replace(":", "").strip()

                # Cari data sub_total, discount, surcharge, dll.
                for line in lines:
                    if "Sub" in line and "Total" in line:
                        match = number_regex.search(line)
                        if match:
                            sub_total = match.group(0)
                    if "Discount" in line:
                        match = number_regex.search(line)
                        if match:
                            discount = match.group(0)
                    if "Surcharge" in line or "Fee" in line:
                        match = number_regex.search(line)
                        if match:
                            surcharge = match.group(0)
                    if "Freight" in line:
                        match = number_regex.search(line)
                        if match:
                            freight = match.group(0)
                    if "Total" in line and "Net" in line:
                        match = number_regex.search(line)
                        if match:
                            total_net = match.group(0)
                    if "VAT" in line or "Tax" in line:
                        match = number_regex.search(line)
                        if match:
                            vat = match.group(0)
                    if "Total" in line and "Amount" in line:
                        match = number_regex.search(line)
                        if match:
                            total_amount = match.group(0)

            # Cek tabel untuk menemukan material
            tables = page.extract_table()
            if tables:
                print(f"Tables on page {page_number}: {tables}")  # Debugging: Cetak isi tabel
                for row in tables:
                    # Pastikan baris memiliki panjang yang cukup dan bukan baris header
                    if len(row) > 5 and row[0] != 'QR' and row[1].isdigit() and row[2]:  # Pastikan material tidak kosong
                        # Gabungkan baris jika diperlukan
                        material_service = ' '.join(row[2:]).replace("\n", " ").strip()
                        print(f"Processing row: {material_service}")  # Debugging: Cetak baris yang diproses
                        material_match = material_regex.search(material_service)  # Cek kolom material saja

                        if material_match:
                            material = material_match.group(0)
                            # Debugging: Cetak material yang ditemukan
                            print(f"Ditemukan material: {material}")
                            if material and "P-PurchaseasRequired" not in material:
                                print(f"Found material: {material}")  # Debugging: Cetak material yang ditemukan
                                data.append({
                                    'document': '',
                                    'poType': po_type,
                                    'material': material,
                                    'qty': row[4] if len(row) > 4 else 'Tidak ditemukan',
                                    'moNumber': row[7].replace(' ', '').replace('\n', '') if len(row) > 7 else 'Tidak ditemukan',
                                    'totalPrice': row[10].replace(' ', '') if len(row) > 10 else 'Tidak ditemukan'
                                })
                                print(f"Data yang ditambahkan: {data[-1]}")  # Cetak data yang baru ditambahkan
                            else:
                                print(f"Skipped material: {material}")  # Debugging: Cetak material yang diabaikan
            else:
                print(f"No tables found on page {page_number}")  # Debugging: Tidak ada tabel yang ditemukan

    return {
        'po_number': po_number,
        'poType': po_type,  # Tambahkan ini untuk mengembalikan poType
        'data': data,
        'sub_total': sub_total,
        'discount': discount,
        'surcharge': surcharge,
        'freight': freight,
        'total_net': total_net,
        'vat': vat,
        'total_amount': total_amount
    }
@app.route('/update', methods=['POST'])
def update_po():
    print("Fungsi update_po dipanggil")
    data = request.json
    document_value = data.get('document')
    po_number = data.get('POno')
    po_type = data.get('tipePO')

    print(f"Document: {document_value}, POnumber: {po_number}, TipePO: {po_type}")  # Debugging

    try:
        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="stockbarang"
        )
        cursor = conn.cursor()

        # Memperbarui PO Number dan Tipe PO berdasarkan document
        update_query = """
            UPDATE partdo
            SET POno = %s, tipePO = %s
            WHERE document = %s
        """
        cursor.execute(update_query, (po_number, po_type, document_value))

        # Mengecek apakah ada baris yang diperbarui
        if cursor.rowcount > 0:
            conn.commit()
            return jsonify({'message': 'PO Number dan Tipe PO berhasil diperbarui'}), 200
        else:
            return jsonify({'error': 'Tidak ada data yang diperbarui, mungkin document tidak ditemukan'}), 404

    except Exception as e:
        return jsonify({'error': str(e)}), 500
    finally:
        cursor.close()
        conn.close()



if __name__ == '__main__':
    app.run(debug=True)
