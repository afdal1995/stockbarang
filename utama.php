<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    color: #fff;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
/* Gaya untuk video latar belakang */
.background-video {
            position: absolute;
            top: 1px;
            left: 0;
            width: 100%;
            height: 99.8%;
            object-fit: cover; /* Menyesuaikan ukuran video agar menutupi seluruh area */
            z-index: -1; /* Menempatkan video di belakang konten */
        }
header {
    background: rgba(0, 0, 0, 0.2);
    color: white;
    padding: 8px 16px;
    text-align: center;
    flex-shrink: 0;
    position: relative;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    margin-bottom: 1px;
}
.sidebar-toggle {
    position: absolute;
    top: 8px;
    left: 8px;
    cursor: pointer;
    color: white;
    font-size: 16px;
    background: rgba(0, 0, 0, 0.3);
    border: none;
    padding: 4px 8px;
    border-radius: 4px;
    z-index: 1001;
    transition: background-color 0.3s;
}
.sidebar-toggle:hover {
    background-color: rgba(0, 0, 0, 0.5);
}
.sidebar {
    position: fixed;
    top: 0;
    left: -250px;
    height: 100%;
    background: rgba(0, 0, 0, 0.0);
    color: #949381;
    padding: 20px;
    transition: left 0.3s;
    box-shadow: 2px 0 5px rgba(0,0,0,0.0);
    z-index: 1000;
}
.sidebar.active {
    left: 0;
    background: rgba(0, 0, 0, 0.7);
    width: 120px;
}
.sidebar ul {
    list-style: none;
    padding: 0;
}
.sidebar ul li {
    margin: 20px 0;
}
.sidebar ul li a {
    color: #949381;
    font-size: 16px;
    text-decoration: none;
}
.sidebar ul li a:hover {
    color: #ffcc00;
}
.dropdown-content {
    display: none;
    position: absolute;
    background: rgba(0, 0, 0, 0.0);
    min-width: 160px;
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 10px 10px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background: rgba(0, 0, 0, 0.0);
}

.dropdown {
    position: relative;
}

.date {
    color: #cccfdb;
    font-size: 20px;
    font-weight: bold;
    font-family: 'Trirong', serif;
}
.container {
    display: flex;
    flex-direction: row;
    padding: 10px;
    flex: 1;
    gap: 5px; /* Add space between columns */
}
.left-container {
    width: 60%; /* Adjust width as needed */
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.label-container {
    width: 42%; /* Adjust width as needed */
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.label-row {
    display: flex;
    justify-content: space-between;
    gap: 5px;
}
.label {
    background: rgba(0, 0, 0, 0.0);
    border: 2px solid #eb8705;
    border-radius: 8px;
    padding: 16px;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.0);
    font-family: 'Trirong', serif;
    font-size: 20px;
    text-align: center;
    height: 80px;
    display: flex; /* Gunakan flexbox */
    flex-direction: column; /* Susun anak secara vertikal */
    align-items: center; /* Pusatkan item secara horizontal */
    margin: 2px; /* Margin di sekitar elemen label */
}
#label1 {
            font-size: 20px; /* Ganti dengan ukuran font yang diinginkan */
            height: 65px;
            margin-top: 0px;
            border: 0px solid #f5020b;
            color: #f5020b;
        }
    #incomeAmount {
        font-size: 50px;
        font-weight: bold;
        }
#label2 {
            border: 0px solid #f54b02;
            color: #f54b02;
            width: 150px;
        }
    #inCount {
        font-size: 45px;
        font-weight: bold;
        } 
#label3 {
            border: 0px solid #e9f502;
            color: #e9f502;
            width: 150px;
        }
    #outCount {
        font-size: 45px;
        font-weight: bold;
        }   
#label4 {
            border: 0px solid #02fa1b;
            color: #02fa1b;
            width: 150px;
        }
    #adjCount {
        font-size: 45px;
        font-weight: bold;
        } 
#label5 {
            border: 0px solid #0f07f0;
            color: #0f07f0;
            width: 150px;
        }
    #doCount {
        font-size: 45px;
        font-weight: bold;
        }   
.chart-container {
    display: flex;
    justify-content: center;
    align-items: center;
}
.chart-border {
    border: 0px solid #ba43ac;
    border-radius: 8px;
    padding: 5px;
    background: rgba(0, 0, 0, 0.0);
    height: 480px; /* Pastikan kontainer ini menyesuaikan tinggi dari chart-container */
    width: 800px; /* Atur lebar jika diperlukan */
    box-sizing: border-box;
}
#horizontalBarChart {
    height: 100%;
    width: 100%;
}
.right-container {
    width: 80%;
    display: flex;
    flex-direction: column;
    gap:5px;
}
.table {
    background: rgba(0, 0, 0, 0.0);
    border-radius: 8px;
    color: #fff;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.0);
    padding: 10px;
    border: 1px solid #fff;
    overflow-x: auto; /* Izinkan gulir horizontal */
    height: 250px;
    text-align: center;
    
}
/* Pengaturan khusus untuk tabel "Item Out Today" */
.table.item-out-today {
    width: 150%; /* Atur lebar khusus jika diperlukan */
    height: 321px;
    background: rgba(0, 0, 0, 0.0); /* Warna latar belakang yang berbeda */
    border: 0px solid #fc03f4; /* Border khusus */
    margin-left: -465px; /* Margin kiri khusus */
    margin-bottom: 2px;
}
.table.item-out-today h3 {
    color: #c7d4d3; /* Warna judul khusus */
    font-size: 26px;
    margin-top: 2px;
    margin-bottom: 0px;
}

.table.part-vhs-stock {
    width: 860px; /* Atur lebar khusus jika diperlukan */
    height: 214px;
    max-width: 860px; /* Lebar maksimum, jika diperlukan */
    background: rgba(0, 0, 0, 0.0); /* Warna latar belakang yang berbeda */
    border: 0px solid #66ccff; /* Border khusus */
}

.table.part-vhs-stock h3 {
    color: #c7d4d3; /* Warna judul khusus */
    font-size: 26px;
    margin-top: 2px;
    margin-bottom: 0px;
}
.table table {
    width: 100%;
    border-collapse: collapse;
    table-layout: auto; /* Layout tetap untuk memastikan lebar kolom yang konsisten */
}
.table th, .table td {
    border: 1px solid #fff;
    padding: 2px;
    overflow: hidden; /* Menyembunyikan konten yang meluap */
    text-overflow: ellipsis; /* Menampilkan elipsis jika teks meluap */
    white-space: nowrap; /* Mencegah teks membungkus ke baris berikutnya */
    font-size: 14px; /* Ubah ukuran font sesuai kebutuhan */
}
/* Menetapkan lebar kolom secara tetap */
.table th:nth-child(1),
.table td:nth-child(1) { width: 150px; }

.table th:nth-child(2),
.table td:nth-child(2) { width: 150px; }

.table th:nth-child(3),
.table td:nth-child(3) { width: 30px; }

.table th:nth-child(4),
.table td:nth-child(4) { width: 120px; }

.table th:nth-child(5),
.table td:nth-child(5) { width: 100px; }

.table th:nth-child(6),
.table td:nth-child(6) { width: 100px; }

/* Tambahkan aturan lebih lanjut jika Anda memiliki lebih banyak kolom */
.table th {
    background: rgba(0, 0, 0, 0.1);
}

    </style>
</head>
<body>
    <!-- Video latar belakang -->
    <video class="background-video" autoplay muted loop>
        <source src="Background/1.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <header>
        <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
        <div class="date" id="currentDate">Loading date...</div>
    </header>
    <div class="sidebar" id="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="index.php" title="datastock"><i class="fas fa-database"></i> Data Stock</a></li>
            <li><a href="masuk.php" title="pmasuk"><i class="fas fa-arrow-alt-circle-down"></i> Part IN</a></li>
            <li><a href="keluar.php" title="pkeluar"><i class="fas fa-arrow-alt-circle-up"></i> Part OUT</a></li>
            <li><a href="adjust.php" title="padjust"><i class="fas fa-tools"></i> Adjustment</a></li>
            <li><a href="partDO.php" title="pdeliv"><i class="fas fa-shopping-cart"></i> Part DO</a></li>
             <!-- Dropdown Menu -->
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn" onclick="toggleDropdown()">
                <i class="fas fa-user-cog"></i> Akun <i class="fas fa-caret-down"></i>
            </a>
            <div class="dropdown-content" id="dropdownContent">
                <a href="tambah_akun.php" title="tambah_akun"><i class="fas fa-user-plus"></i> Tambah Akun</a>
                <a href="logout.php" title="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </li>
        </ul>
    </div>

    <div class="container">
        <div class="left-container">
            <div class="label-container">
                <div class="label" id="label1">
                    Income IDR: 
                    <span id="incomeAmount">120.000.000</span>
                </div>
            <div class="label-row">
                <div class="label" id="label2">
                    IN: 
                    <span id="inCount">27</span>
                </div>
                <div class="label" id="label3">
                    OUT: <span id="outCount">4</span>
                </div>
            </div>
            <div class="label-row">
                <div class="label" id="label4">
                    Adj: 
                    <span id="adjCount">0</span>
                </div>
                <div class="label" id="label5">
                    DO: 
                    <span id="doCount">28</span>
                </div>
            </div>
            </div>
            <div class="chart-container">
                <div class="chart-border">
                    <canvas id="horizontalBarChart"></canvas>
                </div>
            </div>
        </div>
        <div class="right-container">
    <div class="table item-out-today">
        <h3>Item Out Today</h3>
        <table>
            <thead>
            <tr>
                <th style="width: 6%;">Document</th>
                <th style="width: 7%;">Partnumber</th>
                <th style="width: 8%;">Part Number SIS</th>
                <th style="width: 10%;">Description</th>
                <th style="width: 5%;">Location</th>
                <th style="width: 3%;">QTY</th>
                <th style="width: 5%;">MO Number</th>
                <th style="width: 5%;">PO Number</th>
                <th style="width: 5%;">Tipe PO</th>
                <th style="width: 5%;">Remarks</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- Isi baris tabel di sini -->
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table part-vhs-stock">
        <h3>Part VHS Stock Mendekati Minus</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 7%;">Partnumber</th>
                    <th style="width: 8%;">Part Number SIS</th>
                    <th style="width: 10%;">Description</th>
                    <th style="width: 5%;">MIN</th>
                    <th style="width: 5%;">MAX</th>
                    <th style="width: 5%;">SOH</th>
                    <th style="width: 5%;">Remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- Isi baris tabel di sini -->
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table part-vhs-stock">
        <h3>Pengambilan Manual Belum ada PO</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">Document</th>
                    <th style="width: 7%;">Partnumber</th>
                    <th style="width: 8%;">Part Number SIS</th>
                    <th style="width: 10%;">Description</th>
                    <th style="width: 5%;">Location</th>
                    <th style="width: 5%;">QTY</th>
                    <th style="width: 5%;">Tipe Item</th>
                    <th style="width: 5%;">Remarks</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- Isi baris tabel di sini -->
                </tr>
            </tbody>
        </table>
    </div>
</div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        function updateDate() {
            const dateElement = document.getElementById('currentDate');
            if (dateElement) {
                const now = new Date();
                const day = String(now.getDate()).padStart(2, '0');
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const year = now.getFullYear();
                dateElement.textContent = `${day}-${month}-${year}`;
            }
        }

        function toggleDropdown() {
    var dropdownContent = document.getElementById("dropdownContent");
    if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
    } else {
        dropdownContent.style.display = "block";
    }
}

        document.addEventListener('DOMContentLoaded', updateDate);

        async function fetchLabelData() {
            try {
                const response = await fetch('data.json');
                const data = await response.json();
                document.getElementById('label1').textContent = `Label 1: ${data[0]}`;
                document.getElementById('label2').textContent = `Label 2: ${data[1]}`;
                document.getElementById('label3').textContent = `Label 3: ${data[2]}`;
                document.getElementById('label4').textContent = `Label 4: ${data[3]}`;
                document.getElementById('label5').textContent = `Label 5: ${data[4]}`;
            } catch (error) {
                console.error('Error fetching label data:', error);
            }
        }

        document.addEventListener('DOMContentLoaded', fetchLabelData);

        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('horizontalBarChart').getContext('2d');
            const data = [10, 20, 30, 40, 50, 60, 40, 20, 80, 100, 68, 14];

            const backgroundColors = data.map(value => {
                if (value <= 20) return 'rgba(255, 99, 132, 0.2)';
                if (value <= 40) return 'rgba(54, 162, 235, 0.2)';
                if (value <= 60) return 'rgba(255, 206, 86, 0.2)';
                return 'rgba(75, 192, 192, 0.2)';
            });

            const borderColors = data.map(value => {
                if (value <= 20) return 'rgba(255, 99, 132, 1)';
                if (value <= 40) return 'rgba(54, 162, 235, 1)';
                if (value <= 60) return 'rgba(255, 206, 86, 1)';
                return 'rgba(75, 192, 192, 1)';
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map((_, index) => `${index + 1}`),
                    datasets: [{
                        label: 'Data',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 2
                    }]
                },
                options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        color: '#fff' // Warna font sumbu X
                    },
                    title: {
                        color: '#fff' // Warna font judul sumbu X
                    }
                },
                y: {
                    ticks: {
                        color: '#fff' // Warna font sumbu Y
                    },
                    title: {
                        color: '#fff' // Warna font judul sumbu Y
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#fff' // Warna font legenda
                    }
                },
                tooltip: {
                    callbacks: {
                        title: function(tooltipItems) {
                            return tooltipItems[0].label;
                        },
                        label: function(tooltipItem) {
                            return `Data: ${tooltipItem.raw}`;
                        }
                    },
                    titleColor: '#fff', // Warna font judul tooltip
                    bodyColor: '#fff', // Warna font isi tooltip
                    footerColor: '#fff' // Warna font footer tooltip
                }
            }
        }
    });
});
    </script>
</body>
</html>
