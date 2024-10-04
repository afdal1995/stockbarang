<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Part IN</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
                    /* Custom CSS */
        body {
            padding-top: 56px;
            background-color: #000;
            color: #fff;
            box-sizing: border-box;
        }
        .navbar {
            background-color: #343a40;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 190px;
            background-color: #212529;
            padding: 1rem;
            z-index: 100;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            display: flex;
            text-align: center;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .sidebar .nav-link:hover {
            color: #0f0e0e;
            background-color: #38de1b;
            width: 220px;
            margin-left: -20px;
            font-weight: bold;
        }
        .sidebar .nav-link i {
            margin-right: 5px;
            font-size: 1.5rem;
        }
        .main-content {
            margin-left: 190px; /* Menyesuaikan margin kiri */
            padding: 1rem;
            background-color: #1c1c1c;
            border-radius: 5px;
            width: calc(125% - 210px); /* Menyesuaikan lebar untuk menghindari tumpang tindih dengan sidebar */
            min-height: calc(100vh - 56px); /* Menyesuaikan tinggi konten */
            margin-top: 0; /* Menghapus margin-top yang tidak perlu */
            box-sizing: border-box; /* Menghitung padding dan border dalam lebar dan tinggi elemen */
        }
        .form-control-custom {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            height: 2rem;
            background-color: #343a40;
            color: #fff;
            border: 1px solid #495057;
            box-sizing: border-box;
        }
        .form-control-custom:focus {
            background-color: #495057;
            color: #fff;
            border-color: #80bdff;
        }
        .form-control-custom[readonly] {
            background-color: #e9ecef;
            color: black;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-small {
            padding: 4px 8px;
            font-size: 0.75rem;
            margin-top: -10px;
        }
        .ui-autocomplete {
            z-index: 1050;
        }
        .modal-content-custom {
            background-color: #fff;
            color: #000;
            width: 800px;
        }
        .modal-dialog {
            max-width: 60%;
        }
        .modal-header-custom, .modal-footer-custom {
            border-color: #dee2e6;
        }
        .navbar-brand {
            font-size: 1.50rem;
        }
        #dataTable, #modalTable {
            font-size: 0.75rem;
            width: 100%;
            table-layout: fixed;
            box-sizing: border-box;
        }
        #dataTable th, #dataTable td, #modalTable th, #modalTable td {
            padding: 0;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #495057;
        }
        #dataTable th, #modalTable th {
            background-color: #343a40;
            color: #fff;
        }
        #dataTable td, #modalTable td {
            background-color: #1c1c1c;
        }
        #dataTable tr:nth-child(even) td, #modalTable tr:nth-child(even) td {
            background-color: #2a2a2a;
        }
        #dataTable tr:hover td, #modalTable tr:hover td {
            background-color: #495057;
        }
        #dataTable th:nth-child(1), #dataTable td:nth-child(1),
        #modalTable th:nth-child(1), #modalTable td:nth-child(1) {
            width: 13%;
        }
        #dataTable th:nth-child(2), #dataTable td:nth-child(2),
        #modalTable th:nth-child(2), #modalTable td:nth-child(2) {
            width: 24%;
        }
        #dataTable th:nth-child(3), #dataTable td:nth-child(3),
        #modalTable th:nth-child(3), #modalTable td:nth-child(3) {
            width: 17%;
        }
        #dataTable th:nth-child(4), #dataTable td:nth-child(4),
        #modalTable th:nth-child(4), #modalTable td:nth-child(4) {
            width: 23%;
        }
        #dataTable th:nth-child(5), #dataTable td:nth-child(5),
        #modalTable th:nth-child(5), #modalTable td:nth-child(5) {
            width: 13%;
        }
        #dataTable th:nth-child(6), #dataTable td:nth-child(6) {
            width: 5%;
        }
        #modalTable input[type="text"], #modalTable input[type="number"] {
            background-color: #1c1c1c;
            color: #fff;
            border: 1px solid #495057;
        }
        #modalTable input[type="text"]:focus, #modalTable input[type="number"]:focus {
            background-color: #495057;
            border-color: #80bdff;
            color: #fff;
        }
        #modalTable th {
            font-size: 1rem;
            color: #fff;
        }
          /* CSS untuk modal dengan ID 'largeModal' */
        #passwordModal .modal-dialog {
            width: 20%;
            height: 10%;
            margin-top: 11%;
        }
        /* CSS untuk tabel utama */
        #dataTable {
            color: #000;
            width: 100%;
            overflow-y: auto; /* Menambahkan scroll vertikal jika konten melebihi tinggi maksimum */
            table-layout: fixed ; /* Atur ke auto jika tidak sudah ditetapkan */
            border-collapse: collapse; /* Memastikan border kolom tidak bertumpuk */
        }
        #dataTable th {
            background-color: #343a40;
            color: #fff;
            font-size: 1rem;
            text-align: center;
            line-height: 1.5rem;
            border: 2px solid #0be807;
            position: sticky;
            top: 0; /* Memastikan header tetap di bagian atas */
        }
        #dataTable td {
            background-color: #fff;
            color: #000;
            border: 2px solid #0be807;
            line-height: 1rem; /* Coba nilai yang lebih besar */
            font-size: 12px;
            font-weight: bold;
            padding: 0; /* Coba nilai padding yang lebih besar */
            margin: 0 !important; /* Atur margin menjadi 0 jika diperlukan */
            overflow: hidden; /* Menyembunyikan konten yang meluap */
            display: table-cell; /* Pastikan sel berperilaku seperti sel tabel */
            height: 20px !important; /* Atur tinggi sel */
        }
        #dataTable td:nth-child(3), #dataTable th:nth-child(3),
        #dataTable td:nth-child(4), #dataTable th:nth-child(4),
        #dataTable td:nth-child(5), #dataTable th:nth-child(5) {
            text-align: left;
            padding-left: 10px; /* Ganti 20px dengan nilai yang diinginkan */
        }
        #dataTable tr:nth-child(even) td {
            background-color: #f9f9f9;
        }
        #dataTable tr:hover td {
            background-color: #e0e0e0;
        }
        .form-control-custom {
            background-color: #343a40;
            color: #fff;
            border: 1px solid #495057;
        }
        .form-control-custom:focus {
            background-color: #495057;
            border-color: #80bdff;
            color: #fff;
        }
       /* Mengatur ukuran ikon edit dan delete */
       .edit-icon, .delete-icon {
            width: 23px; /* Atur lebar sesuai kebutuhan */
            height: 23px; /* Atur tinggi sesuai kebutuhan */
            padding: 0;
            margin: 0 2px; /* Jarak antar ikon */
            display: inline-block; /* Pastikan elemen tidak mempengaruhi tinggi baris */
            padding-bottom: 10px;   /* Jarak antara border bawah dan ikon */
        }
                /* Aturan CSS untuk mengatur tinggi baris tabel utama */
        #dataTable tbody tr {
            height: 10px !important; /* Atur tinggi baris sesuai kebutuhan */
            line-height: 10px !important; /* Pastikan tinggi teks sesuai dengan tinggi baris */
        }
        /* Container untuk tabel dengan scrollbar */
.table-container {
    max-height: 600px; /* Ganti dengan tinggi maksimum yang diinginkan */
    overflow-y: auto; /* Menampilkan scrollbar vertikal saat konten melebihi tinggi */
    border: 1px solid #0be807; /* Tambahkan border jika diperlukan */
    border-radius: 5px; /* Tambahkan border-radius untuk sudut yang membulat */
    background-color: #0be807; /* Warna latar belakang container */
    margin-top: 0rem; /* Tambahkan margin atas jika diperlukan */
}
    </style>
</head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <a class="navbar-brand" href="#">Barang Masuk</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <form class="form-inline my-2 my-lg-0">
                    <input id="searchInput" class="form-control form-control-custom mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                </form>
            </li>
            
            <li class="nav-item">
                    <button id="showModalBtn" class="btn btn-primary">Part IN</button>
                </li>
            </ul>
        </div>
    </nav>

<div class="container-fluid">
        <div class="row">
        <div class="sidebar">
    <div class="nav flex-column">
        <a class="nav-link" href="index.php">
            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
            Stock Barang
        </a>
        <a class="nav-link" href="utama.php">
            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
            Home
        </a>
        <a class="nav-link" href="index.php">
            <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
            Data Stock
        </a>
        <a class="nav-link" href="keluar.php">
            <div class="sb-nav-link-icon"><i class="fas fa-arrow-alt-circle-up"></i></div>
            Part OUT
        </a>
        <a class="nav-link" href="adjust.php">
            <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
            Adjustment
        </a>
        <a class="nav-link" href="index.html">
            <div class="sb-nav-link-icon"><i class="fas fa-file"></i></div>
            Backlog
        </a>
    </div>
</div>

            <div class="main-content">
            <div class="table-container">
                <table id="dataTable" class="table table-bordered">
                    <thead>
                        <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 8%;">Date</th>
                        <th style="width: 8%;">Document</th>
                        <th style="width: 18%;">Partnumber</th>
                        <th style="width: 13%;">OEM</th>
                        <th style="width: 15%;">Description</th>
                        <th style="width: 7%;">Location</th>
                        <th style="width: 5%;">QTY</th>
                        <th style="width: 5%;">Actions</th> <!-- Kolom untuk tombol Edit dan Delete -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan dimuat secara dinamis -->
                    </tbody>
                </table>
                <div id="noDataMessage" class="alert alert-info" style="display: none;">
        Data tidak ada.
    </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputModalLabel">Input Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="modalTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Document</th>
                            <th>Partnumber</th>
                            <th>OEM</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>QTY</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" class="form-control form-control-custom document" name="document" placeholder="Document"></td>
                            <td><input type="text" class="form-control form-control-custom partnumber" name="partnumber" placeholder="Partnumber"></td>
                            <td><input type="text" class="form-control form-control-custom" name="oem" placeholder="OEM" readonly></td>
                            <td><input type="text" class="form-control form-control-custom" name="description" placeholder="Description" readonly></td>
                            <td><input type="text" class="form-control form-control-custom" name="location" placeholder="Location" readonly></td>
                            <td><input type="text" class="form-control form-control-custom qty" name="qty" placeholder="QTY"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
                <div class="modal-footer modal-footer-custom">
                    <button type="button" id="saveChangesBtn" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Password -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passwordModalLabel">Verifikasi Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="password" id="passwordInput" class="form-control" placeholder="Masukkan password">
        <div id="passwordError" class="text-danger mt-2" style="display: none;">Password salah!</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="confirmPasswordBtn">Verifikasi</button>
      </div>
    </div>
  </div>
</div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script>
$(document).ready(function() {
    var selectedCell = null; // Variabel untuk menyimpan sel yang dipilih
    var selectedRow = null; // Variabel untuk menyimpan baris yang dipilih saat edit

    // Menampilkan modal dan menginisialisasi tabel dengan satu baris kosong
    $('#showModalBtn').click(function() {
        $('#inputModal').modal('show');
    });

    // Menangani klik pada sel tabel untuk memilih sel
    $('#modalTable').on('click', 'td input', function() {
        $('#modalTable td input').removeClass('selected'); // Hapus kelas 'selected' dari sel lain
        $(this).addClass('selected'); // Tambahkan kelas 'selected' ke sel yang diklik
        selectedCell = $(this); // Simpan sel yang dipilih
    });

    // Menangani event paste untuk tabel modal
    $('#modalTable').on('paste', function(event) {
        event.preventDefault(); // Mencegah aksi default paste

        if (!selectedCell) {
            alert('Pilih kolom terlebih dahulu.');
            return;
        }

        var clipboardData = event.originalEvent.clipboardData || window.clipboardData;
        var pastedData = clipboardData.getData('text');

        // Memecah data yang dipaste menjadi baris dan kolom
        var rows = pastedData.split('\n').map(function(row) {
            return row.split('\t');
        }).filter(function(row) {
            return row.length > 0;
        });

        var colName = selectedCell.attr('name');
        var colIndex = {
            'document': 0,
            'partnumber': 1,
            'oem': 2,
            'description': 3,
            'location': 4,
            'qty': 5
        }[colName];

        var tbody = $('#modalTable tbody');
        var startRowIndex = selectedCell.closest('tr').index();

        // Tambahkan baris baru jika tidak ada baris dalam tabel
        while (tbody.find('tr').length <= (startRowIndex + rows.length - 1)) {
            tbody.append('<tr>' +
                '<td><input type="text" class="form-control form-control-custom document" name="document" placeholder="Document"></td>' +
                '<td><input type="text" class="form-control form-control-custom partnumber" name="partnumber" placeholder="Partnumber"></td>' +
                '<td><input type="text" class="form-control form-control-custom" name="oem" placeholder="OEM" readonly></td>' +
                '<td><input type="text" class="form-control form-control-custom" name="description" placeholder="Description" readonly></td>' +
                '<td><input type="text" class="form-control form-control-custom" name="location" placeholder="Location" readonly></td>' +
                '<td><input type="text" class="form-control form-control-custom qty" name="qty" placeholder="QTY"></td>' +
                '</tr>');
        }

        // Memperbarui data di tabel modal
        rows.forEach(function(row, rowIndex) {
            var $row = tbody.find('tr:eq(' + (startRowIndex + rowIndex) + ')');
            var cells = $row.find('input');

            cells.each(function(cellIndex) {
                if (cellIndex === colIndex) {
                    $(this).val(row[0] || ''); // Mengisi data pada kolom yang dipilih
                }
            });

            // Trigger blur event untuk autofill setiap baris setelah paste
            if (colName === 'partnumber') {
                var partnumberInput = $row.find('input[name="partnumber"]');
                partnumberInput.trigger('blur');
            }
        });

        // Menghapus kelas 'selected' setelah paste
        $('#modalTable td input').removeClass('selected');
        selectedCell = null;

        validateSubmitButton(); // Validasi setelah paste
    });

    // Menangani blur pada kolom partnumber untuk autofill
    $(document).on('blur', 'input[name="partnumber"]', function() {
        var row = $(this).closest('tr');
        var partnumber = $(this).val();

        if (partnumber.trim() === '') {
            row.find('input[name="oem"]').val('');
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
                    row.find('input[name="oem"]').val('No Data');
                    row.find('input[name="description"]').val('No Data');
                    row.find('input[name="location"]').val('No Data');
                    row.find('input[name="qty"]').val(''); // Reset qty jika ada error
                } else {
                    row.find('input[name="oem"]').val(response.oem);
                    row.find('input[name="description"]').val(response.description);
                    row.find('input[name="location"]').val(response.location);
                    row.find('input[name="qty"]').val(response.qty); // Autofill qty dari respons
                }
                validateSubmitButton(); // Validasi setelah response
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
                alert('Error dalam respons dari server.');
            }
        });
    });

    // Validasi tombol Simpan berdasarkan baris tabel
    function validateSubmitButton() {
        var allValid = true;

        $('#modalTable tbody tr').each(function() {
            var row = $(this);
            var oem = row.find('input[name="oem"]').val();
            var description = row.find('input[name="description"]').val();
            var location = row.find('input[name="location"]').val();

            if (oem === 'No Data' || description === 'No Data' || location === 'No Data') {
                allValid = false;
            }
        });

        $('#saveChangesBtn').prop('disabled', !allValid);
    }

    // Menangani penyimpanan perubahan
    $('#saveChangesBtn').click(function() {
        var allValid = true;
        var tableData = [];

        $('#modalTable tbody tr').each(function() {
            var row = $(this);
            var document = row.find('input[name="document"]').val();
            var partnumber = row.find('input[name="partnumber"]').val();
            var oem = row.find('input[name="oem"]').val();
            var description = row.find('input[name="description"]').val();
            var location = row.find('input[name="location"]').val();
            var qty = row.find('input[name="qty"]').val();

            if (partnumber && (oem === 'No Data' || description === 'No Data' || location === 'No Data')) {
                allValid = false;
            }

            if (partnumber) {
                tableData.push({
                    document: document,
                    partnumber: partnumber,
                    oem: oem,
                    description: description,
                    location: location,
                    qty: qty
                });
            }
        });

        if (!allValid) {
            alert('Pastikan semua data valid sebelum menyimpan.');
            return; // Tidak lanjutkan jika data tidak valid
        }

        // Mengirim data ke server
        fetch('savemasuk.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(tableData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Data berhasil disimpan!');
                $('#inputModal').modal('hide');
                loadData(); // Memuat ulang data setelah menyimpan
            } else {
                alert('Gagal menyimpan data: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan data.');
        });
    });

    // Membersihkan tabel saat modal ditutup dan mengatur ulang ke 1 baris
    $('#inputModal').on('hidden.bs.modal', function() {
        var tbody = $('#modalTable tbody');
        tbody.empty();
        tbody.append('<tr>' +
            '<td><input type="text" class="form-control form-control-custom document" name="document" placeholder="Document"></td>' +
            '<td><input type="text" class="form-control form-control-custom partnumber" name="partnumber" placeholder="Partnumber"></td>' +
            '<td><input type="text" class="form-control form-control-custom" name="oem" placeholder="OEM" readonly></td>' +
            '<td><input type="text" class="form-control form-control-custom" name="description" placeholder="Description" readonly></td>' +
            '<td><input type="text" class="form-control form-control-custom" name="location" placeholder="Location" readonly></td>' +
            '<td><input type="text" class="form-control form-control-custom qty" name="qty" placeholder="QTY"></td>' +
            '</tr>');
        selectedCell = null; // Reset sel yang dipilih
    });

    // Fungsi untuk memfilter tabel
    $('#searchInput').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        var hasVisibleRows = false;

        $('#dataTable tbody tr').each(function() {
            var rowText = $(this).text().toLowerCase();
            if (rowText.includes(searchTerm)) {
                $(this).show();
                hasVisibleRows = true;
            } else {
                $(this).hide();
            }
        });

        // Tampilkan pesan jika tidak ada data yang sesuai
        if (hasVisibleRows) {
            $('#noDataMessage').hide();
        } else {
            $('#noDataMessage').show();
        }
    });

    // Fungsi untuk memuat data dari server ke tabel utama
    function loadData() {
        $.ajax({
            url: 'dbmasuk.php', // Endpoint yang sesuai
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var $tbody = $('#dataTable tbody');
                $tbody.empty(); // Bersihkan tabel sebelum menambah data

                if (data.length > 0) {
                    data.forEach(function(item) {
                        $tbody.append('<tr data-id="' + item.no + '">' + // Gunakan No sebagai data-id
                            '<td>' + item.no + '</td>' + // Menampilkan nomor urut dari data
                            '<td>' + item.date + '</td>' +
                            '<td>' + item.document + '</td>' +
                            '<td>' + item.partnumber + '</td>' +
                            '<td>' + item.oem + '</td>' +
                            '<td>' + item.description + '</td>' +
                            '<td>' + item.location + '</td>' +
                            '<td>' + item.qty + '</td>' +
                            '<td>' +
                            '<button class="btn btn-link edit-icon"><i class="fas fa-edit"></i></button> ' +
                            '<button class="btn btn-link delete-icon"><i class="fas fa-trash"></i></button>' +
                            '</td>' +
                            '</tr>');
                    });
                    $('#noDataMessage').hide(); // Sembunyikan pesan jika ada data
                } else {
                    $('#noDataMessage').show(); // Tampilkan pesan jika tidak ada data
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
                alert('Gagal memuat data.');
            }
        });
    }

    // Panggil loadData saat dokumen siap
    loadData();
});

$(document).ready(function() {
    let currentAction = null; // Variabel untuk menyimpan aksi yang sedang dilakukan
    let currentRow = null; // Variabel untuk menyimpan baris yang sedang diakses

    // Fungsi untuk autofill data
    function autofillData(partnumber) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: 'autodataTable.php',
            type: 'POST',
            data: { partnumber: partnumber },
            success: function(response) {
                try {
                    let responseData = typeof response === 'string' ? JSON.parse(response) : response;
                    if (responseData.status === 'success') {
                        let $row = currentRow;
                        $row.find('td').eq(4).text(responseData.data.oem);
                        $row.find('td').eq(5).text(responseData.data.description);
                        $row.find('td').eq(6).text(responseData.data.location);
                        resolve(); // Autofill selesai, lanjutkan
                    } else {
                        // Panggil fungsi handleUpdateFailure jika data tidak ditemukan
                        handleUpdateFailure(currentRow);
                        reject(); // Gagal memuat data
                    }
                } catch (e) {
                    console.error('Gagal mem-parsing respons:', response);
                    // Panggil fungsi handleUpdateFailure jika terjadi kesalahan parsing
                    handleUpdateFailure(currentRow);
                    reject(); // Gagal parsing respons
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
                // Panggil fungsi handleUpdateFailure jika terjadi kesalahan AJAX
                handleUpdateFailure(currentRow);
                reject(); // Terjadi kesalahan pada request
            }
        });
    });
}



    // Menangani klik pada tombol Edit
    $('#dataTable').on('click', '.edit-icon', function() {
        currentAction = 'edit';
        currentRow = $(this).closest('tr');
        $('#passwordModal').modal('show'); // Tampilkan modal password
    });

    // Menangani klik pada tombol Delete
    $('#dataTable').on('click', '.delete-icon', function() {
        currentAction = 'delete';
        currentRow = $(this).closest('tr');
        $('#passwordModal').modal('show'); // Tampilkan modal password
    });

    // Menangani klik pada tombol Verifikasi di modal password
    $('#confirmPasswordBtn').click(function() {
        let password = $('#passwordInput').val().trim();
        if (password) {
            $.ajax({
                url: 'verifyPassword.php',
                type: 'POST',
                data: { password: password },
                dataType: 'json', // Pastikan ini diatur ke 'json'
                success: function(response) {
                    console.log('Response:', response); // Debugging
                    if (response.status === 'success') {
                        if (currentAction === 'edit') {
                            startEditing(currentRow);
                        } else if (currentAction === 'delete') {
                            deleteRow(currentRow);
                        }
                        $('#passwordModal').modal('hide');
                    } else {
                        $('#passwordError').text(response.message || 'Password salah!').show();
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                    $('#passwordError').text('Terjadi kesalahan saat memverifikasi password.').show();
                }
            });
        } else {
            $('#passwordError').text('Password tidak boleh kosong!').show();
        }
    });

    // Ketika modal ditutup
    $('#passwordModal').on('hidden.bs.modal', function () {
        // Kosongkan nilai input password
        $('#passwordInput').val('');
        // Sembunyikan pesan error jika ada
        $('#passwordError').hide();
    });

    // Deklarasi variabel global untuk menyimpan baris yang sedang diedit
    let currentEditingRow = null;

    function startEditing(row) {
    if (currentEditingRow) {
        restoreRow(currentEditingRow);
    }

    currentEditingRow = row;
    row.data('editing', true);

    // Simpan partnumber lama di data atribut
    let oldPartnumber = row.find('td').eq(3).text().trim();
    row.data('old-partnumber', oldPartnumber);

    row.find('td').each(function(index) {
        let $cell = $(this);
        let text = $cell.text().trim();

        if (index === 2 || index === 3 || index === 7) {
            let input = $('<input type="text" class="form-control form-control-custom">').val(text);
            $cell.html(input);
            input.focus();

            input.off('blur').on('blur', function() {
                let newValue = $(this).val().trim();
                if (newValue !== text) {
                    if (index === 3) { // Kolom 'partnumber'
                        // Jalankan autofill dan kemudian saveChanges
                        autofillData(newValue).then(() => {
                            saveChanges(row);
                        }).catch(() => {
                            console.log('Autofill gagal, tidak menyimpan perubahan.');
                        });
                    } else {
                        saveChanges(row);
                    }
                }
            });

            input.off('keydown').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    let newValue = $(this).val().trim();
                    if (index === 3 && newValue) { // Kolom 'partnumber'
                        // Jalankan autofill dan kemudian saveChanges
                        autofillData(newValue).then(() => {
                            saveChanges(row);
                        }).catch(() => {
                            console.log('Autofill gagal, tidak menyimpan perubahan.');
                        });
                    } else {
                        saveChanges(row);
                    }
                }
            });

            if (index === 3) { // Kolom 'partnumber'
                input.off('blur.autofill').on('blur.autofill', function() {
                    let partnumber = $(this).val().trim();
                    if (partnumber) {
                        autofillData(partnumber);
                    }
                });
            }
        }
    });

    row.find('td:last').html('<button class="btn btn-link delete-icon"><i class="fas fa-trash"></i></button>');
}

function saveChanges(row) {
    let id = row.data('id');

    // Ambil nilai input
    let documentInput = row.find('td').eq(2).find('input');
    let documentValue = documentInput.length > 0 ? documentInput.val().trim() : '';

    let partnumberInput = row.find('td').eq(3).find('input'); // Kolom 'partnumber'
    let partnumberValue = partnumberInput.length > 0 ? partnumberInput.val().trim() : '';

    let qtyInput = row.find('td').eq(7).find('input');
    let qtyValue = qtyInput.length > 0 ? qtyInput.val().trim() : '';

    // Log data untuk debugging
    console.log("Document Value:", documentValue);
    console.log("Partnumber Value:", partnumberValue);
    console.log("Quantity Value:", qtyValue);

    // Validasi data
    if (!documentValue || !partnumberValue || !qtyValue) {
        alert('Semua kolom yang dapat diisi harus diisi!');
        return;
    }

    let oem = row.find('td').eq(4).text().trim();
    let description = row.find('td').eq(5).text().trim();
    let location = row.find('td').eq(6).text().trim();

    let data = {
        id: id,
        document: documentValue,
        oldPartnumber: row.data('old-partnumber'), // Gunakan nilai lama dari data atribut
        newPartnumber: partnumberValue,
        oem: oem,
        description: description,
        location: location,
        qty: qtyValue
    };

    console.log('Data yang dikirim:', data);

    $.ajax({
        url: 'editmasuk.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            try {
                let responseData = typeof response === 'string' ? JSON.parse(response) : response;
                console.log('Response Data:', responseData);
                if (responseData.status === 'success') {
                    alert('Data berhasil diperbarui!');
                    updateRow(row, data);
                    currentEditingRow = null;
                } else {
                    alert('Gagal memperbarui data: ' + responseData.message);
                }
            } catch (e) {
                console.error('Failed to parse response:', response);
                alert('Gagal memperbarui data: Terjadi kesalahan saat mem-parsing respons.');
            }
        },
        error: function(xhr, status, error) {
            console.log('Error: ' + error);
            alert('Terjadi kesalahan saat memperbarui data.');
        }
    });
}


function updateRow(row, data) {
    row.find('td').eq(2).text(data.document);
    row.find('td').eq(3).text(data.newPartnumber); // Pastikan ini yang benar
    row.find('td').eq(7).text(data.qty);

    row.find('td').eq(4).text(data.oem);
    row.find('td').eq(5).text(data.description);
    row.find('td').eq(6).text(data.location);

    row.find('td:last').html('<button class="btn btn-link edit-icon"><i class="fas fa-edit"></i></button>' +
                            '<button class="btn btn-link delete-icon"><i class="fas fa-trash"></i></button>');

    row.removeData('editing');
}


function handleUpdateFailure(row) {
    // Update the row to show "No Data" in the relevant cells
    row.find('td').eq(4).text("No Data");
    row.find('td').eq(5).text("No Data");
    row.find('td').eq(6).text("No Data");

    row.find('td:last').html('<button class="btn btn-link edit-icon"><i class="fas fa-edit"></i></button> ' +
                            '<button class="btn btn-link delete-icon"><i class="fas fa-trash"></i></button>');

    row.removeData('editing');
}


    function restoreRow(row) {
        row.find('td').each(function() {
            let $cell = $(this);
            let input = $cell.find('input');
            if (input.length > 0) {
                $cell.text(input.val());
            }
        });

        row.find('td:last').html('<button class="btn btn-link edit-icon"><i class="fas fa-edit"></i></button> ' +
                                '<button class="btn btn-link delete-icon"><i class="fas fa-trash"></i></button>');

        row.removeData('editing');
    }

    function deleteRow(row) {
        if (confirm('Anda yakin ingin menghapus data ini?')) {
            let no = row.find('td').eq(0).text();

            if (!no) {
                alert('No tidak ditemukan untuk baris ini.');
                return;
            }

            $.ajax({
                url: 'deletemasuk.php',
                type: 'POST',
                data: { no: no },
                success: function(response) {
                    console.log('Raw Response:', response);
                    try {
                        let responseData = typeof response === 'string' ? JSON.parse(response) : response;

                        if (responseData.status === 'success') {
                            alert('Data berhasil dihapus!');
                            row.remove();
                        } else {
                            alert('Gagal menghapus data: ' + responseData.message);
                        }
                    } catch (e) {
                        console.error('Failed to parse response:', response);
                        alert('Gagal menghapus data: Respon server tidak valid.');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                    alert('Terjadi kesalahan saat menghapus data.');
                }
            });
        }
    }

    function updateRowNumbers() {
        $('#dataTable').find('tr').each(function(index) {
            $(this).find('td').eq(0).text(index + 1);
        });
    }
});

    </script>

</body>
</html>
