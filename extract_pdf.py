import os
import json
import pdfplumber

# Lokasi folder di mana PDF berada
folder_path = r"C:\Users\afdal\Downloads"
output_json_path = r"C:\xampp\htdocs\stockbarang\pdf_data.json"

# Menampilkan daftar file PDF di folder
pdf_files = [f for f in os.listdir(folder_path) if f.endswith('.pdf')]

if not pdf_files:
    print("Tidak ada file PDF di folder.")
else:
    print("Daftar file PDF yang tersedia:")
    for i, pdf_file in enumerate(pdf_files, start=1):
        print(f"{i}. {pdf_file}")

    # Meminta input dari pengguna untuk memilih file PDF
    file_choice = int(input(f"Pilih file PDF (1-{len(pdf_files)}): ")) - 1

    # Dapatkan path lengkap ke file PDF yang dipilih
    pdf_path = os.path.join(folder_path, pdf_files[file_choice])

    data = []

    # Proses file PDF yang dipilih
    with pdfplumber.open(pdf_path) as pdf:
        for page_number, page in enumerate(pdf.pages, start=1):
            # Ekstrak tabel dari halaman
            tables = page.extract_table()
            
            if tables:
                for row in tables:
                    # Sesuaikan ini dengan format tabel Anda
                    if len(row) >= 6:  # Pastikan ada cukup kolom
                        data.append({
                            "po_type": row[1],  # Misalnya, PO Type di kolom kedua
                            "material": row[2],  # Material/Service di kolom ketiga
                            "qty": row[3],  # QTY di kolom keempat
                            "mo_number": row[4],  # MO Number di kolom kelima
                            "total_price": row[5]  # Total Price di kolom keenam
                        })
            else:
                print(f"Tidak ditemukan tabel di halaman {page_number}")

    # Simpan data ke file JSON
    with open(output_json_path, 'w') as json_file:
        json.dump(data, json_file, indent=4)

    print(f"Data PDF telah disimpan di {output_json_path}")
