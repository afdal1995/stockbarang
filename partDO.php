<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Part DO</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    /* Gaya umum untuk body dan html */
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden; /* Menghindari scrollbar */
        font-family: Arial, sans-serif;
    }

    /* Gaya untuk video latar belakang */
    .background-video {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover !important; /* Memastikan video memenuhi area */
        z-index: -1; /* Menempatkan video di belakang konten */
        pointer-events: none; /* Tambahkan ini */
    }

    /* Gaya untuk tombol toggle */
    .sidebar-toggle {
        font-size: 20px;
        cursor: pointer;
        padding: 2px;
        position: fixed;
        top: 10px;
        left: 10px;
        z-index: 20;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        border-radius: 2px;
    }

    /* Gaya untuk sidebar */
    .sidebar {
    width: 140px;
    height: 100%;
    background-color: rgba(2, 155, 250, 0.7);
    color: white;
    position: fixed;
    top: 0;
    left: -250px; /* Sidebar disembunyikan di luar layar */
    transition: 0.3s; /* Animasi transisi */
    padding: 5px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.9);
    }

    .sidebar.active {
        left: 0; /* Sidebar ditampilkan saat active */
        z-index: 5;
    }


    .sidebar h2 {
        color: #0f0e0e;
        margin: 0;
        padding: 20px 0;
        text-align: center;
        width: 100%;
        box-sizing: border-box;
        font-weight: bold;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0;
        width: 100%;
    }

    .sidebar li {
        width: 100%;
    }

    .sidebar a {
        text-decoration: none;
        font-size: 17px;
        color: #0f0e0e;
        display: block;
        padding: 10px;
        transition: color 0.3s ease, background-color 0.3s ease;
        text-align: left;
        font-weight: bold;
    }

    .sidebar a:hover {
        color: #f0ebeb;
        background-color: #575757;
    }
     /* Container untuk table dengan scroll */
     .table-container {
            padding-top: -10PX;
            height: 840px; /* Tinggi maksimal */
            overflow-y: auto;  /* Scroll secara vertikal */
            border: 0px solid #ccc;
            margin-top: 50px;
        }
    /* Gaya untuk tabel */
    table {
        width: 1685px;
        border-collapse: collapse;
        margin: 50px 2px 2px 2px;
        table-layout: fixed;
        margin-top: 0px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 5px;
        text-align: center;
    }

    th {
        background-color: rgba(0, 149, 255, 0.5);
        font-size: 14px;
        border: 1px solid #09edc7;
        line-height: 1.3rem;
        position: sticky;
        top: -1px;
        z-index: 1; /* Pastikan header tetap di atas konten */
        font-weight: bold;
    }

    td {
        font-size: 14px;
        background-color: rgba(247, 242, 242, 0.5);
        border: 1px solid #09edc7;
        line-height: 0.9rem;
        font-family: Arial, sans-serif;
    }
    #data-table td:nth-child(4),
    #data-table td:nth-child(5),
    #data-table td:nth-child(6) {
        text-align: left; /* Rata kiri untuk kolom 4, 5, dan 6 */
    }

    tr:hover {
        background-color: rgba(16, 208, 230, 0.5)
    }
    #data-table tbody tr {
    color: #0a0a0a; /* Ganti dengan warna font untuk baris tabel */
    }

    /* Gaya untuk header bar */
    .header-bar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 10px 20px;
        background-color: rgba(0, 0, 0, 0.1);
        color: #0095ff;
        z-index: 1;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-bar h1 {
        margin: 0;
        margin-left: 13px;
        font-size: 24px;
    }

    .header-bar .search-container {
        display: flex;
        align-items: center;
    }
    #search-input {
    padding-right: 30px; /* Beri ruang untuk tombol "X" */
    }

    #clear-search {
        color: #242121; /* Warna tombol "X" */
        font-size: 16px; /* Ukuran font tombol "X" */
    }


    .header-bar input[type="text"] {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 10px;
    }

    .header-bar button {
        padding: 5px 10px;
        border: none;
        background-color: #333;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        margin-right: 30px;
    }

    .header-bar button:hover {
        background-color: #555;
    }

    /* Gaya untuk modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 100;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 1% auto;
        padding: 10px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
    }

    .modal-content h2 {
        margin: 0 0 0px 0;
        padding: 0px 0;
        font-size: 23px;
        color: #333;
        text-align: center;
    }
    .modal-content h3 {
        font-size: 17px;
        color: #333;
        text-align: center;
        margin: 0 0 0px 0;
        padding: 0px 0;

    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Gaya untuk tabel di modal */
    .modal-table {
        width: 100%;
        border-collapse: collapse;
        margin: 5px 0;
    }

    .modal-table th, .modal-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .modal-table th {
        background-color: rgba(0, 0, 0, 0.1);
        font-size: 14px;
        border: 1px solid #333;
    }

    .modal-table td {
        font-size: 12px;
        background-color: rgba(247, 242, 242, 0.5);
        border: 1px solid #333;
        height: 7px;
    }

    .modal-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .modal-table tr:hover {
        background-color: #e2e2e2;
    }

    /* Gaya untuk footer modal */
    .modal-footer {
        margin-top: -50px;
        display: flex; /* Menggunakan flexbox */
        justify-content: space-between; /* Sebar elemen dengan ruang di antaranya */
        align-items: center; /* Vertikal selaras */
    }
    .table-price {
        width: 300px;
        margin-right: 105px;
        margin-bottom: 0; /* Hilangkan margin bawah */
        padding-bottom: 0; /* Hilangkan padding bawah */
        margin-top: 50px;
    }

    .table-price td {
        height: 7px;
        text-align: right;
        background-color: #fefefe;
        border: 0px solid #333;
        width: 149px;
    }
    #addRowButton {
        z-index: 1;
        position:  relative;
        top: 30px; /* Sesuaikan jarak dari atas */
        width: 150px;
        height: 30px;
        margin-top: 0;
        background-color: #333;
        color: white;
        border-radius: 4px;
    }
    #addRowButton:hover {
        background-color: #555; /* Warna saat hover */
    }

    .modal-footer button {
        padding: 10px 20px;
        border: none;
        background-color: #333;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        margin: 0 5px;
    }

    .modal-footer button:hover {
        background-color: #555;
    }
    .modal-table input {
    width: 100%; /* Agar input menyesuaikan dengan lebar kolom */
    box-sizing: border-box; /* Padding dan border termasuk dalam lebar input */
    font-size: 15px; /* Sesuaikan ukuran teks */
    padding: 0px; /* Sesuaikan padding agar terlihat lebih baik */
}
    .vertical-container {
        display: flex;
        flex-direction: column;
        gap: 5px;
        align-items: flex-end;
        margin-right: 20px;
        margin-top: 50px;
        margin-bottom: 0; /* Hilangkan margin bawah */
        padding-bottom: 0; /* Hilangkan padding bawah */
    }

    .vertical-container input[type="text"] {
        width: 127px;
        height: 23px;
        padding: 0 10px;
        font-size: 16px;
        border: 2px solid #262424;
        border-radius: 4px;
        font-weight: bold;
        margin-right: 5px;
        text-align: center;
    }

    .modal-footer .upload-button, .submit-button, .close-button {
        width: 150px;
        height: 30px;
    }
    .manual-button {
        width: 150px;
        height: 30px;
    }
    /* CSS untuk modal dengan background hitam dan teks putih */
.modal-content.modal-dark {
    background-color: black;
    color: white;
}

.modal-content.modal-dark th, .modal-content.modal-dark td {
    color: white; /* Warna teks tabel */
}

/* CSS untuk modal default */
.modal-content.modal-default {
    background-color: white;
    color: black;
}

.modal-content.modal-default th, .modal-content.modal-default td {
    color: black; /* Warna teks tabel */
}
.modal-content.modal-dark {
    background-color: #696565;
    color: white;
}
.table-price-dark td {
    background-color: #696565 !important;
    color: #696565 !important;
}
.table-price-default td {
    background-color: white
    color: black
}
.border-white {
    border: 2px solid white !important;
    background-color: #080808;
    color: #fcfafa;
}
/* Set input field agar menyesuaikan lebar kolom */
.edit-input {
    width: 100%;
    box-sizing: border-box; /* Agar padding dan border ikut dihitung dalam width */
}
.modalPass {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5); /* Latar belakang semi-transparan */
}

.modalPass-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border-radius: 8px; /* Sudut membulat */
    border: 1px solid #888;
    width: 350px; /* Lebar modal password */
    font-size: 16px; /* Ukuran font secara umum */
}

#passwordInput {
    width: 100%; /* Agar input mengambil seluruh lebar modal */
    padding: 10px; /* Spasi di dalam input */
    margin-top: 10px;
    margin-bottom: 20px;
    font-size: 16px; /* Ukuran font input */
    border: 1px solid #ccc;
    border-radius: 5px; /* Membulatkan sudut input */
    box-sizing: border-box; /* Agar padding termasuk dalam lebar total */
}

#submitPassword {
    width: 100%; /* Agar tombol mengambil seluruh lebar */
    padding: 10px;
    background-color: #4CAF50; /* Warna hijau untuk tombol */
    color: white;
    border: none;
    border-radius: 5px; /* Membulatkan sudut tombol */
    font-size: 16px; /* Ukuran font tombol */
    cursor: pointer;
}

#submitPassword:hover {
    background-color: #45a049; /* Warna tombol saat hover */
}

#closeModal {
    float: right;
    font-size: 20px; /* Ukuran font untuk tombol tutup */
    cursor: pointer;
    margin-top: -10px;
}

#passwordError {
    color: red;
    font-size: 14px; /* Ukuran font pesan error */
    display: none;
    margin-top: 10px;
}




</style>
</head>
<body>
    <!-- Header Bar -->
    <div class="header-bar">
        <h1>PART DO</h1>
        <div class="search-container" style="position: relative;">
            <input type="text" id="search-input" placeholder="Cari..." oninput="performSearch()">
            <button id="clear-search" style="display: none; position: absolute; right: 90px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">X</button>
            <button id="action-button">Transaksi</button>
        </div>
    </div>

    <!-- Video latar belakang -->
    <video class="background-video" autoplay muted loop preload="auto">
        <source src="Background/luffy.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Tombol untuk menampilkan sidebar -->
<button class="sidebar-toggle" id="toggleBtn">☰</button>


    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h2></h2>
        <ul>
            <li><a href="utama.php" title="datastock"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="index.php" title="datastock"><i class="fas fa-database"></i> Data Stock</a></li>
            <li><a href="masuk.php" title="pmasuk"><i class="fas fa-arrow-alt-circle-down"></i> Part IN</a></li>
            <li><a href="keluar.php" title="pkeluar"><i class="fas fa-arrow-alt-circle-up"></i> Part OUT</a></li>
            <li><a href="adjust.php" title="padjust"><i class="fas fa-tools"></i> Adjustment</a></li>
            <li><a href="#" title="pdeliv"><i class="fas fa-shopping-cart"></i> Part DO</a></li>
        </ul>
    </div>

    <!-- Tabel -->
    <div class="table-container">
    <table id="data-table">
        <thead>
            <tr>
                <th style="width: 2%;">ID</th>
                <th style="width: 4%;">Date</th>
                <th style="width: 5%;">Document</th>
                <th style="width: 9%;">Partnumber</th>
                <th style="width: 8%;">Part Number SIS</th>
                <th style="width: 10%;">Description</th>
                <th style="width: 4%;">Location</th>
                <th style="width: 3%;">QTY</th>
                <th style="width: 5%;">MO Number</th>
                <th style="width: 5%;">PO Number</th>
                <th style="width: 5%;">GR Number</th>
                <th style="width: 5%;">DO Number</th>
                <th style="width: 6%;">Tipe PO</th>
                <th style="width: 5%;">Remarks</th>
                <th style="width: 6%;">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Baris akan ditambahkan di sini secara otomatis -->
        </tbody>
    </table>
    </div>

    <!-- Modal input-->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <h2>PURCHASE ORDER</h2>
            <h3></h3>
            <!-- Input file untuk upload PDF -->
            <input type="file" id="fileInput" accept="application/pdf">
            <p id="message" style="color: red;"></p>
            <!-- Tabel di dalam modal -->
            <table class="modal-table">
                <thead>
                    <tr>
                        <th style="width: 14%;">PO Type</th>
                        <th style="width: 20%;">Material/Service</th>
                        <th style="width: 8%;">QTY</th>
                        <th style="width: 14%;">MO Number</th>
                        <th style="width: 14%;">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Baris akan ditambahkan di sini secara otomatis -->
                </tbody>
            </table>

              <!-- Tombol Tambah Baris -->
        <button id="addRowButton">Tambah Baris</button>

            <!-- Footer dengan tombol -->
            <div class="modal-footer">
                <table class="table-price">
                    <tr>
                        <td>Sub Total :</td>
                        <td id="subTotal"></td>
                    </tr>
                    <tr>
                        <td>Discount :</td>
                        <td id="discount"></td>
                    </tr>
                    <tr>
                        <td>Surcharge / Fee :</td>
                        <td id="surcharge"></td>
                    </tr>
                    <tr>
                        <td>Freight :</td>
                        <td id="freight"></td>
                    </tr>
                    <tr>
                        <td>Total Net :</td>
                        <td id="totalNet"></td>
                    </tr>
                    <tr>
                        <td>VAT :</td>
                        <td id="vat"></td>
                    </tr>
                    <tr>
                        <td>Total Amount Of Order :</td>
                        <td id="totalAmount"></td>
                    </tr>
                </table>
       
                <div class="vertical-container">
                    <input type="text" id="textInput" placeholder="MR NO" />
                    <button class="upload-button">Upload PO</button>
                    <button class="manual-button">Manual</button>
                    <button class="submit-button">Submit</button>
                    <button class="close-button">Close</button>
                </div>
            </div>
        </div>
    </div>

            <!-- Modal Password -->
        <div id="passwordModal" class="modalPass" style="display:none;">
            <div class="modalPass-content">
                <span id="closeModal">&times;</span>
                <h3>Masukkan Password</h3>
                <input type="password" id="passwordInput" placeholder="Password">
                <button id="submitPassword">Submit</button>
                <p id="passwordError" style="color: red; display:none;">Password salah!</p>
            </div>
        </div>

    <script>
        
            let hideTimeout;
            const table = document.getElementById('data-table');
            function hideTable() {
                if (table) {
                    table.style.display = 'none';
                }
            }
            function showTable() {
                if (table) {
                    table.style.display = '';
                }
            }
            function resetHideTimeout() {
                if (hideTimeout) {
                    clearTimeout(hideTimeout);
                }
                showTable();
                hideTimeout = setTimeout(hideTable, 90000); // 1 menit
            }
            // Menangkap event mousemove untuk mereset timer
            document.addEventListener('mousemove', resetHideTimeout);
            // Set timer awal saat halaman dimuat
            hideTimeout = setTimeout(hideTable, 90000);
     
        function performSearch() {
    const input = document.getElementById('search-input');
    const searchValue = input.value.toLowerCase();
    const rows = document.querySelectorAll('#data-table tbody tr');
    const clearButton = document.getElementById('clear-search');

    // Tampilkan atau sembunyikan tombol "X"
    clearButton.style.display = searchValue ? '' : 'none';

    rows.forEach(row => {
        const cells = row.getElementsByTagName('td');
        let rowContainsSearchTerm = false;

        for (let i = 0; i < cells.length; i++) {
            const cell = cells[i];
            if (cell.textContent.toLowerCase().includes(searchValue)) {
                rowContainsSearchTerm = true;
                break; // Jika ditemukan, tidak perlu memeriksa sel lainnya
            }
        }

        // Tampilkan atau sembunyikan baris berdasarkan hasil pencarian
        row.style.display = rowContainsSearchTerm ? '' : 'none';
    });
}

// Tambahkan event listener untuk tombol "X"
document.getElementById('clear-search').addEventListener('click', function() {
    const input = document.getElementById('search-input');
    input.value = ''; // Hapus input
    performSearch(); // Panggil fungsi pencarian untuk memperbarui tabel
});



    let modalContent = document.querySelector('.modal-content');
    let currentMode = 'upload'; // Status default

    document.addEventListener('DOMContentLoaded', function() {
        const textInput = document.getElementById('textInput');
        const addRowButton = document.getElementById('addRowButton');
        const tableBody = document.querySelector('.modal-table tbody');
        const submitButton = document.querySelector('.submit-button');
        submitButton.disabled = false; // Disable submit button by default


        // Ambil data dari tabel stockbarang saat halaman dimuat
    fetch('partDOtampil.php') // Pastikan URL ini sesuai dengan lokasi file PHP
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateDataTable(data); // Memperbarui tabel dengan data yang diterima
            } else {
                messageElement.textContent = data.error || 'Terjadi kesalahan';
                messageElement.style.color = 'red';
            }
        })
        .catch(error => {
            messageElement.textContent = 'Error saat mengambil data';
            messageElement.style.color = 'red';
        });

        // Function to check input validity
        function checkInput() {
            if (textInput.value.trim() === '' || textInput.value === 'BTA.05.') {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = false;
            }
        }

        textInput.addEventListener('click', function() {
            this.value = 'BTA.05.'; // Menambahkan teks saat input diklik
            checkInput(); // Cek input setelah mengubah nilai
        });

        // Event listener to validate input on input change
        textInput.addEventListener('input', checkInput);

        // Fungsi untuk mengubah tampilan modal ketika tombol Manual diklik
        document.querySelector('.manual-button').addEventListener('click', function() {
    currentMode = 'manual';
    document.querySelector('#myModal h2').textContent = 'PENGAMBILAN MANUAL';
    document.querySelector('#myModal h3').textContent = '';

    const tableHead = document.querySelector('.modal-table thead tr');
    tableHead.innerHTML = `
        <th style="width: 20%;">Part Number</th>
        <th style="width: 20%;">Description</th>
        <th style="width: 8%;">Location</th>
        <th style="width: 6%;">QTY</th>
    `;

    // Reset tabel saat mode manual dipilih
    const tableBody = document.querySelector('.modal-table tbody');
    tableBody.innerHTML = ''; // Reset isi tabel

        // Reset pesan
        const messageElement = document.getElementById('message');
    messageElement.textContent = ''; // Reset pesan

    // Reset nilai
    document.querySelector('#subTotal').textContent = '';
    document.querySelector('#discount').textContent = '';
    document.querySelector('#surcharge').textContent = '';
    document.querySelector('#freight').textContent = '';
    document.querySelector('#totalNet').textContent = '';
    document.querySelector('#vat').textContent = '';
    document.querySelector('#totalAmount').textContent = '';

    const fileInput = document.getElementById('fileInput');
    fileInput.value = '';

    modalContent.classList.add('modal-dark');
    modalContent.classList.remove('modal-default');
    textInput.classList.add('border-white');

    // Tampilkan tombol tambah baris
    const addRowButton = document.getElementById('addRowButton');
    if (addRowButton) {
        addRowButton.style.display = 'block'; // Tampilkan tombol
    }

    // Sembunyikan tabel harga
    const tablep = document.querySelector('.table-price');
    tablep.classList.add('table-price-dark');
});


// Event listener untuk tombol tambah baris
document.getElementById('addRowButton').addEventListener('click', function() {
    const tableBody = document.querySelector('.modal-table tbody');
    
    // Membuat baris baru dengan kolom input
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td><input type="text" name="partnumber" placeholder="Part Number" style="width: 100%; font-size: 15px; padding: 8px;"></td>
        <td><input type="text" name="description" placeholder="Description" style="width: 100%; font-size: 15px; padding: 8px;"></td>
        <td><input type="text" name="location" placeholder="Location" style="width: 100%; font-size: 15px; padding: 8px;"></td>
        <td><input type="number" name="qty" placeholder="QTY" style="width: 100%; font-size: 15px; padding: 8px;"></td>

    `;
    
    tableBody.appendChild(newRow);
});

        // Tambahkan event listener untuk tombol Close
document.querySelector('.close-button').addEventListener('click', function() {
    // Reset input text
    textInput.value = '';
    document.querySelector('#myModal h3').textContent = '';
    // Reset file input
    const fileInput = document.getElementById('fileInput');
        fileInput.value = '';

        // Reset pesan
    const messageElement = document.getElementById('message');
    messageElement.textContent = ''; // Reset pesan
    
    // Reset nilai di modal-table dan footer
    const tableBody = document.querySelector('.modal-table tbody');
    if (tableBody) {
        tableBody.innerHTML = ''; // Menghapus semua baris
    }
    
    // Reset nilai subtotal dan lainnya
    document.querySelector('#subTotal').textContent = '';
    document.querySelector('#discount').textContent = '';
    document.querySelector('#surcharge').textContent = '';
    document.querySelector('#freight').textContent = '';
    document.querySelector('#totalNet').textContent = '';
    document.querySelector('#vat').textContent = '';
    document.querySelector('#totalAmount').textContent = '';

    // Menyembunyikan modal dengan mengubah gaya CSS
    const modal = document.getElementById('myModal');
    modal.style.display = 'none'; // Sembunyikan modal
});

// Fungsi untuk menutup modal
function bersihkan() {
    textInput.value = '';
    document.querySelector('#myModal h3').textContent = '';
    // Reset file input
    const fileInput = document.getElementById('fileInput');
        fileInput.value = '';
    
    // Reset nilai di modal-table dan footer
    const tableBody = document.querySelector('.modal-table tbody');
    if (tableBody) {
        tableBody.innerHTML = ''; // Menghapus semua baris
    }
    
    // Reset nilai subtotal dan lainnya
    document.querySelector('#subTotal').textContent = '';
    document.querySelector('#discount').textContent = '';
    document.querySelector('#surcharge').textContent = '';
    document.querySelector('#freight').textContent = '';
    document.querySelector('#totalNet').textContent = '';
    document.querySelector('#vat').textContent = '';
    document.querySelector('#totalAmount').textContent = '';
}

// Submit button event
submitButton.addEventListener('click', function() {
    const messageElement = document.getElementById('message');

    if (textInput.value.trim() === '' || textInput.value === 'BTA.05.') {
        alert('MR NO belum diisi');
        return; // Mencegah pengiriman
    }

    if (currentMode === 'upload') {
        if (uploadedFileName) {
            // Tambahkan log untuk memeriksa extractedData
            console.log('Extracted Data before upload:', extractedData);

            fetch('http://localhost:5000/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ 
                    file_name: uploadedFileName,
                    extracted_data: extractedData,
                    document: textInput.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert('Data berhasil disimpan dan file dipindahkan');
                    messageElement.textContent = '';

                    // Ambil data dari tabel stockbarang setelah upload
                    fetch('partDOtampil.php')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                updateDataTable(data); // Memperbarui tabel dengan data yang diterima
                            } else {
                                messageElement.textContent = data.error || 'Terjadi kesalahan';
                                messageElement.style.color = 'red';
                            }
                        })
                        .catch(error => {
                            messageElement.textContent = 'Error saat mengambil data';
                            messageElement.style.color = 'red';
                        });

                    bersihkan(); // Bersihkan input setelah selesai
                } else if (data.error) {
                    messageElement.textContent = data.error;
                    messageElement.style.color = 'red';
                }
            })
            .catch(error => {
                messageElement.textContent = 'Error saat mengirim file';
                messageElement.style.color = 'red';
            });
        } else {
            alert('Tidak ada file yang diunggah untuk dipindahkan');
        }
    } else if (currentMode === 'manual') {
        const rows = document.querySelectorAll('.modal-table tbody tr');
        const data = [];
        let valid = true; // Flag untuk validasi

        rows.forEach(row => {
            const partnumber = row.querySelector('input[name="partnumber"]').value;
            const description = row.querySelector('input[name="description"]').value;
            const location = row.querySelector('input[name="location"]').value;
            const qty = row.querySelector('input[name="qty"]').value;

            if (!qty) {
                alert('Kolom QTY harus diisi.');
                valid = false;
                return; // Menghentikan iterasi jika qty kosong
            }

            if (partnumber && description && location && qty) {
                data.push({ partnumber, description, location, qty });
            }
        });

        if (!valid) {
            return; // Jika tidak valid, jangan lanjutkan
        }

        if (data.length === 0) {
            alert('Tidak ada data untuk disubmit.');
            return;
        }

        const documentData = textInput.value;

        fetch('submitManualPartDO.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ data, document: documentData }) // Menyertakan document
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Data berhasil disimpan!');
                messageElement.textContent = ''; // Reset message

                // Kosongkan semua input setelah berhasil disimpan
                rows.forEach(row => {
                    row.querySelector('input[name="partnumber"]').value = '';
                    row.querySelector('input[name="description"]').value = '';
                    row.querySelector('input[name="location"]').value = '';
                    row.querySelector('input[name="qty"]').value = '';
                });

                // Ambil data terbaru untuk ditampilkan di data-table
                fetch('partDOtampil.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateDataTable(data); // Memperbarui tabel dengan data yang diterima
                        } else {
                            alert(data.error || 'Terjadi kesalahan saat memperbarui tabel');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengambil data.');
                    });
            } else {
                alert('Gagal menyimpan data: ' + result.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim data.');
        });
    }
});



const uploadButton = document.querySelector('.upload-button');
if (uploadButton) {
    uploadButton.addEventListener('click', function() {
        currentMode = 'upload';
        document.querySelector('#myModal h2').textContent = 'PURCHASE ORDER';
        const tableHead = document.querySelector('.modal-table thead tr');
        tableHead.innerHTML = `
            <th style="width: 14%;">PO Type</th>
            <th style="width: 20%;">Material/Service</th>
            <th style="width: 8%;">QTY</th>
            <th style="width: 14%;">MO Number</th>
            <th style="width: 14%;">Total Price</th>
        `;

        // Reset tabel saat mode upload dipilih
        const tableBody = document.querySelector('.modal-table tbody');
        tableBody.innerHTML = ''; // Reset isi tabel

        // Sembunyikan tombol tambah baris
        const addRowButton = document.getElementById('addRowButton');
        if (addRowButton) {
            addRowButton.style.display = 'none'; // Sembunyikan tombol
        }

        uploadFile();
        modalContent.classList.add('modal-default');
        modalContent.classList.remove('modal-dark');
        const tablep = document.querySelector('.table-price');
        tablep.classList.remove('table-price-dark');
        const textInput = document.getElementById('textInput');
        textInput.classList.remove('border-white');
    });
}


        // Toggle sidebar
        const toggleBtn = document.getElementById('toggleBtn');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) {
                    sidebar.classList.toggle('active');
                }
            });
        }

        // Modal control
        const modal = document.getElementById("myModal");
        const btn = document.getElementById("action-button");
        if (btn) {
            btn.addEventListener('click', function() {
                // Sembunyikan tombol tambah baris
        const addRowButton = document.getElementById('addRowButton');
        if (addRowButton) {
            addRowButton.style.display = 'none'; // Sembunyikan tombol
        }
                if (modal) {
                    modal.style.display = "block";
                }
            });
        }

        function cleanMaterial(material) {
            return material.replace(/[^\w\s/-]/g, '').trim();
        }

        function updateModalTable(response) {
            const tableBody = document.querySelector('.modal-table tbody');
            if (!tableBody) return;
            const poNumber = response.po_number;
            const data = response.data;

            if (Array.isArray(data)) {
                tableBody.innerHTML = '';
                data.forEach(row => {
                    const cleanMaterialValue = cleanMaterial(row.material);
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.poType || 'Tidak ditemukan'}</td>
                        <td>${cleanMaterialValue || 'Tidak ditemukan'}</td>
                        <td>${row.qty || 'Tidak ditemukan'}</td>
                        <td>${row.moNumber || 'Tidak ditemukan'}</td>
                        <td>${row.totalPrice || 'Tidak ditemukan'}</td>
                    `;
                    tableBody.appendChild(tr);
                });

                document.getElementById('subTotal').innerText = response.sub_total;
                document.getElementById('discount').innerText = response.discount;
                document.getElementById('surcharge').innerText = response.surcharge;
                document.getElementById('freight').innerText = response.freight;
                document.getElementById('totalNet').innerText = response.total_net;
                document.getElementById('vat').innerText = response.vat;
                document.getElementById('totalAmount').innerText = response.total_amount;

                document.querySelector('.modal-content h3').textContent = `NO: ${poNumber}`;
            } else {
                console.error('Data bukan merupakan array');
            }
        }

        let uploadedFileName = null;
        let extractedData = null;
        function uploadFile() {
    const fileInput = document.getElementById('fileInput');
    const messageElement = document.getElementById('message');
    const file = fileInput.files[0];

    if (file) {
        messageElement.textContent = ''; // Reset pesan sebelumnya
        const formData = new FormData();
        formData.append('file', file);

        fetch('http://localhost:5000/upload', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response from server:', data); // Debugging untuk melihat respons

            // Cek pesan dari server
            if (data.message === 'File uploaded successfully') {
                uploadedFileName = data.file_name; // Simpan nama file
                extractedData = data.extracted_data; // Ambil data dari respons

                 // Log data yang diekstrak
                 console.log('Data yang Diekstrak:', extractedData);


                if (extractedData && typeof extractedData === 'object' && extractedData.data && Array.isArray(extractedData.data)) {
                    updateModalTable(extractedData);
                    checkAndMatchData(extractedData.data); // Cek kesamaan data
                } else {
                    console.error('extractedData tidak dalam format yang diharapkan', extractedData);
                    messageElement.textContent = 'Data yang diekstrak tidak valid';
                }
            } else if (data.message === 'pdf sudah ada') {
                console.error('PDF sudah ada:', data.message);
                messageElement.textContent = 'PDF sudah ada'; // Tampilkan pesan kepada pengguna
                uploadedFileName = null; // Reset nama file
            } else {
                console.error('Pesan tidak dikenali:', data.message);
                messageElement.textContent = 'Terjadi kesalahan: ' + data.message;
            }
        })
        .catch(error => {
            console.error('Server belum diaktifkan:', error);
            messageElement.textContent = 'Server belum diaktifkan';
        });
    } else {
        messageElement.textContent = 'Silakan pilih file untuk diunggah.'; // Pesan jika tidak ada file
        }
    }
});
function cleanMaterial(material) {
    return material.replace(/[^\w\s/-]/g, '').trim();
}

function checkAndMatchData(modalData) {
    const dataTableRows = document.querySelectorAll('#data-table tbody tr');
    const textInput = document.getElementById('textInput');
    const alerts = []; // Array untuk menyimpan pesan alert

    modalData.forEach(modalRow => {
        const modalMO = modalRow.moNumber;
        const modalMaterial = cleanMaterial(modalRow.material);
        const modalQty = modalRow.qty;

        dataTableRows.forEach(dataTableRow => {
            const dataMO = dataTableRow.querySelector('td:nth-child(9)').textContent.trim(); // MO Number di kolom ke-9
            const dataPartNumberSIS = dataTableRow.querySelector('td:nth-child(5)').textContent.trim(); // Part Number SIS di kolom ke-5
            const dataQty = dataTableRow.querySelector('td:nth-child(8)').textContent.trim(); // QTY di kolom ke-8

            // Cek jika MO Number, Part Number SIS/Material, dan QTY sama
            if (modalMO === dataMO && modalMaterial === dataPartNumberSIS && modalQty === dataQty) {
                const documentValue = dataTableRow.querySelector('td:nth-child(3)').textContent.trim(); // Document di kolom ke-3
                textInput.value = documentValue; // Tampilkan Document di textInput
                
                // Tambahkan pesan ke dalam array alerts
                alerts.push(`Document: ${documentValue}, Part Number: ${modalMaterial}, MO Number: ${modalMO}, QTY: ${modalQty}; sudah ada dalam tabel.`);
            }
        });
    });

    // Tampilkan alert jika ada pesan yang terkumpul
    if (alerts.length > 0) {
        alert(alerts.join('\n')); // Gabungkan pesan dengan line break
    }
}

    function updateDataTable(response) {
    const tableBody = document.querySelector('#data-table tbody');
    if (!tableBody) return;

    tableBody.innerHTML = ''; // Kosongkan tabel sebelum mengisi

    response.data.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${row.no || ''}</td>
            <td>${row.date || ''}</td>
            <td>${row.document || ''}</td>
            <td>${row.partnumber || ''}</td>
            <td>${row.partnumberSIS || ''}</td>
            <td>${row.description || ''}</td>
            <td>${row.location || ''}</td>
            <td>${row.qty || ''}</td>
            <td>${row.MOno || ''}</td>
            <td>${row.POno || ''}</td>
            <td>${row.GRno || ''}</td>
            <td>${row.DOno || ''}</td>
            <td>${row.tipePO || ''}</td>
            <td>${row.remarks || ''}</td>
            <td>
                <button class="edit-button">Edit</button>
                <button class="delete-button">Delete</button>
            </td>
        `;
        tableBody.insertBefore(tr, tableBody.firstChild);
    });
}

// Menangani blur pada kolom partnumber untuk autofill
$(document).on('blur', 'input[name="partnumber"]', function() {
    var row = $(this).closest('tr');
    var partnumber = $(this).val();

    if (partnumber.trim() === '') {
        row.find('input[name="description"]').val('');
        row.find('input[name="location"]').val('');
        row.find('input[name="qty"]').val(''); // Reset qty jika partnumber kosong
        return;
    }

    $.ajax({
        url: 'getPartDetails.php',
        type: 'GET',
        data: { partnumber: partnumber },
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                alert(response.error);
                row.find('input[name="description"]').val('No Data');
                row.find('input[name="location"]').val('No Data');
                row.find('input[name="qty"]').val(''); // Reset qty jika ada error
            } else {
                row.find('input[name="description"]').val(response.description);
                row.find('input[name="location"]').val(response.location);
                // Tidak ada autofill qty dari respons, jika perlu tambahkan
            }
        },
        error: function(xhr, status, error) {
            alert('Error dalam respons dari server.');
        }
    });
});

$(document).ready(function() {
    var currentRow; // Untuk menyimpan baris yang sedang di-edit
    var isSaving = false; // Flag untuk melacak apakah sedang dalam proses menyimpan
    var editModeActive = false; // Flag untuk melacak apakah mode edit sedang aktif

    // Fungsi ketika tombol edit diklik
    $('#data-table').on('click', '.edit-button', function() {
    currentRow = $(this).closest('tr'); // Simpan baris yang di-edit
    
    // Kosongkan input password dan error message
    $('#passwordInput').val('');
    $('#passwordError').hide(); // Sembunyikan pesan kesalahan password

    $('#passwordModal').show(); // Tampilkan modal password
});


    // Fungsi untuk menutup modal
    $('#closeModal').click(function() {
        $('#passwordModal').hide();
    });

    // Fungsi untuk submit password
    $('#submitPassword').click(function() {
        var password = $('#passwordInput').val();

        // Lakukan AJAX untuk verifikasi password
        $.ajax({
            url: 'verifyPassword.php',
            type: 'POST',
            data: { password: password },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#passwordModal').hide(); // Tutup modal jika password benar
                    startEditing(currentRow); // Mulai mode edit
                } else {
                    $('#passwordError').show(); // Tampilkan pesan kesalahan jika password salah
                }
            }
        });
    });

    // Fungsi untuk mulai mode edit setelah verifikasi berhasil
    function startEditing(row) {
        $('#passwordInput').val('');
        $('#passwordError').hide(); // Sembunyikan pesan kesalahan password

        // Pilih kolom yang ingin diedit (Part Number, QTY, MO Number)
        var partNumber = row.find('td:nth-child(4)');
        var qty = row.find('td:nth-child(8)');
        var moNumber = row.find('td:nth-child(9)');

        // Ubah kolom menjadi input field untuk diedit
        partNumber.html('<input type="text" id="partNumberInput" class="edit-input partnumber" value="' + partNumber.text().trim() + '">');
        qty.html('<input type="number" id="qtyInput" class="edit-input" value="' + qty.text().trim() + '">');
        moNumber.html('<input type="text" id="moNumberInput" class="edit-input" value="' + moNumber.text().trim() + '">');

        // Tambahkan class "editing" untuk mengetahui row yang sedang diedit
        row.addClass('editing');

        // Set flag bahwa mode edit aktif
        editModeActive = true;

        // Fokus pada input pertama (Part Number)
        var partNumberInput = partNumber.find('input');
        partNumberInput.focus();
    }

    // Simpan data ketika enter ditekan atau klik di luar input field
    $(document).on('keydown', function(e) {
        if (e.key === 'Enter' && editModeActive) {
            saveEditedRow();
        }
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.editing').length && !$(e.target).hasClass('edit-mode') && editModeActive) {
            saveEditedRow();
        }
    });
    // Fungsi untuk menyimpan baris yang diedit
function saveEditedRow() {
    if (isSaving || !editModeActive) {
        return; // Hentikan eksekusi jika sudah dalam proses penyimpanan atau tidak ada mode edit
    }

    var row = $('.editing');
    if (row.length) {
        var no = row.find('td:nth-child(1)').text(); // Mengambil nilai kolom 'no' sebagai ID
        var partNumber = row.find('td:nth-child(4) input').val(); // Ambil input part number
        var qty = row.find('td:nth-child(8) input').val(); // Ambil input qty
        var moNumber = row.find('td:nth-child(9) input').val(); // Ambil input moNumber

        $.ajax({
            url: 'getpartDO.php',
            method: 'POST',
            data: { partnumber: partNumber },
            dataType: 'json',
            beforeSend: function() {
                isSaving = true; // Set flag menjadi true ketika mulai menyimpan
            },
            success: function(response) {
                if (response.exists) {
                    var partnumberSIS = response.pnsis;
                    var description = response.description;
                    var location = response.location;

                    if (!partnumberSIS || !description || !location) {
                        alert('Gagal memperbarui data: Kolom PartNumberSIS, Description, atau Location tidak boleh kosong.');
                        isSaving = false; 
                        return;
                    }

                    $.ajax({
                        url: 'savepartDO.php',
                        method: 'POST',
                        data: {
                            no: no,
                            partnumber: partNumber,
                            qty: qty,
                            moNumber: moNumber || '', 
                            partnumberSIS: partnumberSIS,
                            description: description,
                            location: location
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                alert('Data berhasil diperbarui.');

                                // Update tampilan data di data-table
                                row.find('td:nth-child(4)').text(partNumber);
                                row.find('td:nth-child(5)').text(partnumberSIS);
                                row.find('td:nth-child(6)').text(description);
                                row.find('td:nth-child(7)').text(location);
                                row.find('td:nth-child(8)').text(qty);
                                row.find('td:nth-child(9)').text(moNumber);

                                // Kembalikan tombol ke status awal setelah proses edit
                                var buttonContainer = row.find('td:nth-child(15)');
                                buttonContainer.html('<button class="edit-button">Edit</button><button class="delete-button">Delete</button>');

                                // Hapus class 'editing'
                                row.removeClass('editing');
                                editModeActive = false;
                            } else {
                                alert('Gagal memperbarui data: ' + (response.error || 'Tidak ada error message.'));
                            }
                            isSaving = false;
                        },
                        error: function(xhr, status, error) {
                            alert('Terjadi kesalahan saat memperbarui data: ' + error);
                            isSaving = false;
                        }
                    });
                } else {
                    alert('Part Number tidak terdaftar.');
                    isSaving = false;
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat memeriksa Part Number.');
                isSaving = false;
            }
        });
    }
}

});

</script>

</body>
</html>