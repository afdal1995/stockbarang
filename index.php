<?php
require 'function.php';
require 'cek.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Stock</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <style>
    .table {
        width: 100% !important; /* Pastikan tabel menggunakan lebar penuh */
        table-layout: fixed; /* Tetapkan lebar tetap untuk kolom tabel */
    }
    .table thead th, .table tfoot th, .table tbody td {
        font-size: 0.9em;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        padding: 0.5rem; /* Mengurangi padding dalam sel tabel */
        line-height: 0.6; /* Mengatur tinggi baris */
    }
    /* Atur lebar kolom individual jika diperlukan */
    .table th:nth-child(1), .table td:nth-child(1) { width: 30%; } /* Part Number */
    .table th:nth-child(2), .table td:nth-child(2) { width: 20%; } /* OEM */
    .table th:nth-child(3), .table td:nth-child(3) { width: 25%; } /* Part SIS */
    .table th:nth-child(4), .table td:nth-child(4) { width: 30%; } /* Deskripsi */
    .table th:nth-child(5), .table td:nth-child(5) { width: 10%; } /* Lokasi */
    .table th:nth-child(6), .table td:nth-child(6) { width: 8%; } /* QTY */
    .table th:nth-child(7), .table td:nth-child(7) { width: 10%; } /* Tipe Item */
    
    /* CSS tambahan untuk form pencarian */
    .form-inline {
        display: flex;
        align-items: center;
    }

    #searchInput {
        width: 200px; /* Atur lebar input pencarian sesuai kebutuhan */
    }

    .float-right {
        float: right;
    }

    /* CSS tambahan untuk navbar */
.navbar .form-inline {
    display: flex;
    align-items: center;
}

.navbar .form-control {
    width: 200px; /* Atur lebar input pencarian sesuai kebutuhan */
}

.navbar .btn-primary {
    margin-left: 1rem; /* Spasi antara tombol tambah dan input pencarian */
}

@media (max-width: 768px) {
    .navbar .form-inline {
        margin-top: 0.5rem; /* Jarak tambahan untuk tampilan mobile */
    }
}
/* CSS untuk link Part Number */
.partnumber-link {
    color: #08121c; /* Warna link */
    cursor: pointer; /* Tanda tangan klik */
    font-weight: 300; /* Font tebal */
}

.partnumber-link:hover {
    color: #0056b3; /* Warna saat hover */
}

/* CSS untuk modal gambar */
.modal-dialog {
    max-width: 70%; /* Maksimal lebar modal */
    width: auto; /* Lebar otomatis sesuai konten */
}

.modal-body {
    text-align: center; /* Pusatkan gambar dalam modal */
    padding: 2; /* Menghilangkan padding tambahan */
}
/* Gaya untuk modal dengan ID myModal */
#myModal .modal-dialog {
    max-width: 20%; /* Lebar maksimal modal */
    margin: 1.75rem auto; /* Spasi dari atas dan bawah */
}

#myModal .modal-content {
    border-radius: 8px; /* Radius sudut modal */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan modal */
}

#myModal .modal-header {
    background-color: #343a40; /* Warna latar belakang header */
    color: #fff; /* Warna teks header */
    border-bottom: 1px solid #dee2e6; /* Garis bawah header */
}

#myModal .modal-body {
    padding: 1rem; /* Padding untuk tubuh modal */
}

#myModal .modal-footer {
    border-top: 1px solid #dee2e6; /* Garis atas footer modal */
    padding: 1rem; /* Padding footer modal */
}

#myModal .modal-title {
    font-size: 1.25rem; /* Ukuran font judul modal */
    font-weight: 500; /* Berat font judul modal */
}

#myModal .btn-primary {
    background-color: #007bff; /* Warna latar belakang tombol */
    border-color: #007bff; /* Warna border tombol */
}
/* Gaya untuk elemen form di dalam modal */
#myModal .modal-body .form-control {
    margin-bottom: 0.5rem; /* Jarak bawah antara elemen form */
}

#myModal .btn-primary:hover {
    background-color: #0056b3; /* Warna latar belakang tombol saat hover */
    border-color: #00408a; /* Warna border tombol saat hover */
}

/* Responsif untuk perangkat kecil */
@media (max-width: 576px) {
    #myModal .modal-dialog {
        max-width: 95%; /* Lebar modal lebih kecil pada perangkat kecil */
    }
}

.img-fluid {
    max-width: 100%; /* Lebar gambar responsif sesuai lebar modal */
    max-height: 80vh; /* Maksimal tinggi gambar, sesuaikan dengan viewport */
    height: auto; /* Tinggi otomatis untuk menjaga aspek rasio gambar */
    object-fit: contain; /* Pastikan gambar tidak terpotong */
}

/* Pastikan container tabel mendukung overflow */
.table-container {
    width: 100%;
    overflow-x: auto; /* Mengaktifkan gulir horizontal jika diperlukan */
}

/* CSS untuk membuat header tabel tetap terlihat */
.table thead th {
    position: -webkit-sticky; /* Dukungan untuk Safari */
    position: sticky;
    top: 0; /* Jarak dari bagian atas */
    background-color: #343a40; /* Warna latar belakang header tabel */
    color: #ffffff; /* Warna teks header tabel */
    z-index: 102; /* Pastikan header berada di atas konten lainnya */
    border-bottom: 1px solid #dee2e6; /* Garis bawah untuk membedakan header dan konten */
}

footer {
    height: 25px; /* Sesuaikan tinggi sesuai kebutuhan */
    background-color: #292330 !important; /* Warna latar belakang hitam */
    border-top: 0px solid #dee2e6; /* Garis atas untuk footer */
    display: flex; /* Gunakan Flexbox untuk memusatkan konten */
    align-items: center; /* Vertikal align konten */
    justify-content: center; /* Horisontal align konten */
    padding: 0 !important; /* Padding horizontal */
    color: #f5f2f2 !important; /* Warna teks putih untuk kontras */
    margin-top: 0; /* Menghapus margin atas pada footer */
}

#downloadButton {
    margin-left: auto; /* Letakkan tombol di sebelah kanan */
    font-size: 0.80rem; /* Ukuran font */
    color: #998d8d; /* Warna teks */
    align-items: center;
    padding: 0.0rem 0.5rem; /* Padding dalam tombol */
    margin: 0; /* Jarak luar tombol */
    background-color: #292330; /* Warna latar belakang tombol */
    border: none; /* Menghapus border default */
    border-radius: 0.20rem; /* Radius sudut tombol */
    cursor: pointer; /* Tanda kursor klik */
    height: 21px;
}

#downloadButton:hover {
    background-color: #05ff1e; /* Warna latar belakang saat hover */
    color: #1c1b1b;
    font-weight: bold;
}

/* Tambahkan ini untuk memastikan bahwa body tabel memiliki scroll */
.table tbody {
    display: block;
    overflow-y: auto; /* Mengaktifkan gulir vertikal */
    height: 740px; /* Atur tinggi sesuai kebutuhan */
}

.table thead, .table tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
}
.table-container {
    display: flex;
    flex-direction: column;
    border: #ed1818; /* Menghapus border di sekitar tabel container */
}

/* Mengatur margin dan padding untuk tabel */
.table-container {
    margin-bottom: 0; /* Menghapus margin bawah pada container tabel */
    padding-bottom: 0; /* Menghapus padding bawah pada container tabel */
}

/* Mengatur margin dan padding pada card dan body */
.card {
    margin-bottom: 0; /* Menghapus margin bawah pada card */
}

.card-body {
    margin-bottom: 0; /* Menghapus margin bawah pada card body */
    padding-bottom: 0; /* Menghapus padding bawah pada card body */
    height: auto;
}

/* Mengatur margin pada elemen utama */
#layoutSidenav_content {
    margin-bottom: 0; /* Menghapus margin bawah pada konten */
    padding-bottom: 0; /* Menghapus padding bawah pada konten */
}

/* Reset CSS untuk elemen dasar */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html, body {
    overflow: hidden; /* Menghapus scroll vertikal dari seluruh halaman */
    height: 100%; /* Pastikan tinggi penuh */
}

    </style>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">DATA STOCK</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <!-- Form Pencarian -->
    <form id="searchForm" class="form-inline ml-auto">
        <input type="text" id="searchInput" name="search" class="form-control" placeholder="Cari...">
    </form>
    <!-- Tombol untuk Membuka Modal -->
    <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#myModal">
        Tambah Item Baru
    </button>
    <!-- Navbar-->
</nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="utama.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                            Home
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-alt-circle-down"></i></div>
                            Part IN
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-alt-circle-up"></i></div>
                            Part OUT
                        </a>
                        <a class="nav-link" href="adjust.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                            Adjustment
                        </a>   
                        <a class="nav-link" href="partDO.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Part DO
                        </a>
                        <a class="nav-link" href="index.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-file"></i></div>
                            Backlog
                        </a>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="accountDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
                            Akun
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
                            <a class="dropdown-item" href="tambah_akun.php">Tambah Akun</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="card mb-4">
                        <div class="card-body">
                        <div class="table-container">
                            <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Part Number</th>
                                            <th>OEM</th>
                                            <th>Part SIS</th>
                                            <th>Deskripsi</th>
                                            <th>Lokasi</th>
                                            <th>QTY</th>
                                            <th>Tipe Item</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    <tbody>
                                    <?php
                                    // Ambil dan tampilkan data
                                    require 'dbstock.php'; // Path ke file koneksi database Anda

                                    // Query untuk mengambil data dari database
                                    $sql = "SELECT partnumber, oem, pnsis, description, location, qty, tipeitem FROM datastock";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        // Menampilkan data dari setiap baris
                                        while($row = $result->fetch_assoc()) {
                                            // Misalkan gambar disimpan di folder 'images' dengan nama file sesuai dengan 'partnumber' dan ekstensi '.jpg'
                                            $imageUrl = 'images/' . htmlspecialchars($row["partnumber"]) . '.jpg'; 
                                        
                                            echo "<tr>";
                                            echo "<td><a href='#' class='partnumber-link' data-img='" . $imageUrl . "'><strong>" . htmlspecialchars($row["partnumber"]) . "</strong></a></td>";
                                            echo "<td>" . htmlspecialchars($row["oem"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["pnsis"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["location"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["qty"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["tipeitem"]) . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                                    }
                                    $conn->close();
                                    ?>
                                    </tbody>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="custom-footer">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Hak Cipta &copy; oleh Afdal Irsam</div>
                        <button id="downloadButton" class="btn btn-success">Download Data</button>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Header Modal -->
                <div class="modal-header">
                    <h4 class="modal-title">Form Input</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Isi Modal -->
                <form id="formModal" method="post">
                    <div class="modal-body">
                        <div id="partnumber-feedback" class="text-danger"></div>
                        <input type="text" id="partnumber" name="partnumber" placeholder="Part Number" class="form-control" required>
                        <input type="text" id="oem" name="oem" placeholder="OEM" class="form-control" required>
                        <input type="text" id="pnsis" name="pnsis" placeholder="Part Number SIS" class="form-control">
                        <input type="text" id="description" name="description" placeholder="Deskripsi" class="form-control" required>
                        <input type="text" id="location" name="location" placeholder="Lokasi" class="form-control" required>
                        <input type="number" id="qty" name="qty" placeholder="QTY" class="form-control" required>
                        <input type="text" id="tipeitem" name="tipeitem" placeholder="Tipe Item" class="form-control" required>
                        <br>
                        <button type="submit" class="btn btn-primary" name="addnewbarang">Input</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Skrip JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>

    <!-- Skrip Validasi Part Number -->
    <script>
        $(document).ready(function() {
    // Menyimpan apakah partnumber sudah dicek atau tidak
    let partnumberChecked = false;

    $('#partnumber').on('blur', function() {
        // Cek apakah partnumber sudah dicek
        if (partnumberChecked) return;

        // Ambil nilai partnumber
        const partnumber = $('#partnumber').val().trim(); // Trim untuk menghapus spasi tambahan

        // Validasi partnumber
        if (partnumber === '') return;

        $.ajax({
            url: 'cekpn.php', // Ganti dengan path ke file validasi PHP
            method: 'POST',
            data: { partnumber: partnumber },
            success: function(response) {
                try {
                    // Parse JSON response
                    const data = JSON.parse(response);
                    if (data.exists) {
                        $('#partnumber').css('color', 'red');
                        $('#partnumber-feedback').text('Partnumber sudah ada');

                        // Kosongkan field input jika partnumber sudah ada
                        $('#partnumber').val('');

                        // Set flag bahwa partnumber sudah dicek
                        partnumberChecked = true;
                    } else {
                        $('#partnumber').css('color', '');
                        $('#partnumber-feedback').text('');
                        partnumberChecked = false;
                    }
                } catch (e) {
                    $('#partnumber-feedback').text('Format respon tidak valid.');
                }
            },
            error: function() {
                $('#partnumber-feedback').text('Terjadi kesalahan saat memeriksa partnumber.');
            }
        });
    });

    // Tambahkan event listener untuk input 'partnumber' untuk menghapus pesan kesalahan saat mengetik
    $('#partnumber').on('input', function() {
        $('#partnumber-feedback').text('');
        $('#partnumber').css('color', '');
        partnumberChecked = false;
    });

    // Tambahkan event handler untuk form submission
    $('#formModal').on('submit', function(event) {
        event.preventDefault(); // Mencegah pengiriman form default

        // Ambil nilai partnumber
        const partnumber = $('#partnumber').val().trim();

        // Validasi partnumber sebelum form dikirim
        if (partnumber === '') {
            $('#partnumber-feedback').text('Partnumber harus diisi.');
            return;
        }

        // Kirim data form jika partnumber valid
        $.ajax({
            url: 'function.php', // Ganti dengan path ke file PHP untuk memproses form
            method: 'POST',
            data: $(this).serialize(), // Kirim data form
            success: function(response) {
                // Handle sukses jika perlu
                alert('Data berhasil dikirim!');
                $('#myModal').modal('hide'); // Tutup modal setelah berhasil
                $('#formModal')[0].reset(); // Reset form setelah berhasil
            },
            error: function() {
                $('#partnumber-feedback').text('Terjadi kesalahan saat mengirim data.');
            }
        });
    });
});
</script>

<script>
// Script untuk menangani pencarian di tabel
$(document).ready(function() {
    $('#searchInput').on('input', function() {
        // Ambil nilai pencarian
        const searchQuery = $(this).val().toLowerCase();

        // Filter baris tabel berdasarkan pencarian
        $('#dataTable tbody tr').each(function() {
            const rowText = $(this).text().toLowerCase();
            if (rowText.indexOf(searchQuery) === -1) {
                $(this).hide(); // Sembunyikan baris jika tidak cocok
            } else {
                $(this).show(); // Tampilkan baris jika cocok
            }
        });
    });
});

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    document.getElementById('downloadButton').addEventListener('click', function() {
        var wb = XLSX.utils.book_new();
        var ws_data = [];
        var rows = document.querySelectorAll('#dataTable tr');

        // Ambil data dari tabel
        rows.forEach(function(row) {
            var rowData = [];
            var cells = row.querySelectorAll('td, th');

            cells.forEach(function(cell) {
                rowData.push(cell.innerText);
            });

            ws_data.push(rowData);
        });

        var ws = XLSX.utils.aoa_to_sheet(ws_data);

        // Atur ukuran kolom
        ws['!cols'] = [
            { wpx: 165 }, // Lebar kolom pertama
            { wpx: 100 }, // Lebar kolom kedua
            { wpx: 100 }, // Lebar kolom ketiga
            { wpx: 165 }, // Lebar kolom keempat
            { wpx: 50 }, // Lebar kolom kelima
            { wpx: 30 },  // Lebar kolom keenam
            { wpx: 50 }  // Lebar kolom ketujuh
        ];

        // Atur tinggi baris (opsional)
        ws['!rows'] = ws_data.map(() => ({ hpx: 16 }));

        // Tambahkan border pada setiap sel dan atur font
        Object.keys(ws).forEach(function(cell) {
            if (cell[0] === '!') return; // Abaikan metadata
            var cellRef = ws[cell];
            if (!cellRef.s) cellRef.s = {};

            // Mengatur border
            if (!cellRef.s.border) {
                cellRef.s.border = {
                    top: { style: 'medium', color: { rgb: "000000" } },
                    left: { style: 'medium', color: { rgb: "000000" } },
                    bottom: { style: 'medium', color: { rgb: "000000" } },
                    right: { style: 'medium', color: { rgb: "000000" } }
                };
            }

            // Mengatur font
            cellRef.s.font = {
                name: 'Calibri',
                sz: 8,
                color: { rgb: "000000" }
            };
        });

        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

        // Konversi workbook menjadi file Excel
        XLSX.writeFile(wb, 'data.xlsx');
    });
</script>


</body>
<!-- Modal untuk Menampilkan Gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" class="img-fluid" alt="Part Number Image">
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Event listener untuk link Part Number
    $(document).on('click', '.partnumber-link', function(event) {
        event.preventDefault(); // Mencegah link dari membuka URL

        const imageUrl = $(this).data('img'); // Ambil URL gambar dari data-img
        $('#modalImage').attr('src', imageUrl); // Set src dari modal image
        $('#imageModal').modal('show'); // Tampilkan modal
    });
});
</script>
</html>

