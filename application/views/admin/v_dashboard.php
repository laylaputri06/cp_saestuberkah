<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-blue: #2005a2;
            --active-blue: #304FFE; 
            --page-bg: #FFFFFF;       
            --card-bg: #EEF8FF;       
            --activity-bg: #D4E4FC;   
            --text-dark: #1F2937;
            --strong-shadow: 0 10px 25px rgba(26, 3, 128, 0.12); 
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--page-bg);
            overflow-x: hidden;
            margin: 0;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            height: 100vh;
            background-color: var(--primary-blue);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            padding: 30px 0;
            z-index: 1000;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 30px;
            margin-bottom: 50px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.7);
            font-weight: 600;
            padding: 15px 30px;
            text-decoration: none;
            display: block;
            transition: 0.3s;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            border-left: 5px solid transparent;
        }

        .nav-link:hover { color: white; background-color: rgba(255, 255, 255, 0.1); }

        .nav-link.active {
            background-color: #304FFE; 
            color: white;
            border-left: 5px solid #fff;
        }

        .logout-btn {
            margin: auto 30px 30px 30px;
            background-color: #4C6EF5;
            color: white;
            text-align: center;
            padding: 12px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .logout-btn:hover { background-color: #3b5bdb; color: white; }

        /* --- MAIN CONTENT --- */
        .main-content { margin-left: 260px; }

        /* --- HEADER NAVBAR --- */
        .top-navbar {
            background-color: var(--card-bg);
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(26, 3, 128, 0.08); 
            margin-bottom: 40px;
        }

        .page-title {
            font-weight: 800;
            font-size: 1.6rem;
            margin: 0;
            color: var(--text-dark);
        }

        .date-text {
            font-size: 0.9rem;
            color: #666;
            margin-top: 4px;
            font-weight: 500;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-dark);
        }

        /* --- CONTENT AREA --- */
        .content-wrapper { padding: 0 50px 50px 50px; }

        /* --- CARD STYLE --- */
        .custom-card {
            background-color: var(--card-bg);
            border-radius: 25px;
            padding: 30px;
            box-shadow: var(--strong-shadow);
            height: 100%;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .welcome-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        
        /* --- PERBAIKAN DI SINI --- */
        .welcome-img { 
            height: 160px; 
            object-fit: contain; 
            /* SAYA SUDAH MENGHAPUS 'filter: ...' SUPAYA WARNA GAMBAR ASLI MUNCUL */
        }

        .stat-val { font-size: 3.5rem; font-weight: 800; line-height: 1; color: var(--text-dark); }
        .stat-title { font-size: 1rem; font-weight: 600; color: var(--text-dark); margin-bottom: 10px; }
        
        .stat-icon { font-size: 2rem; color: var(--text-dark); }
        
        /* Icon Baju SVG */
        .icon-shirt {
            width: 45px;
            height: 45px;
            stroke: var(--text-dark);
            fill: none;
            stroke-width: 1.5;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .activity-item {
            background-color: var(--activity-bg);
            border-radius: 15px;
            padding: 15px 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-weight: 500;
            color: var(--text-dark);
            font-size: 0.95rem;
        }
        
        .check-circle {
            background-color: #22C55E;
            color: white;
            width: 28px; height: 28px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .btn-riwayat {
            background-color: #240099;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            float: right;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            background-color: #eef2ff; /* Biru sangat muda */
            padding: 10px 15px;
            border-radius: 12px;
            margin-bottom: 10px;
        }

        .check-circle {
            background-color: #10b981; /* Warna hijau sukses */
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="<?= base_url('assets/images/logo putih.png') ?>" alt="Logo" height="45">
            <div style="line-height: 1.1; color: white;">
                <div style="font-weight: 800; font-size: 18px;">Konveksi</div>
                <div style="font-weight: 300; font-size: 13px;">Saestu Berkah</div>
            </div>
        </div>

        <nav>
            <a href="<?= base_url('admin/dashboard') ?>" class="nav-link active">DASHBOARD</a>
            <a href="<?= base_url('admin/produk') ?>" class="nav-link">PRODUK</a>            
            <a href="<?= base_url('admin/halaman') ?>" class="nav-link">HALAMAN</a>
            <a href="<?= base_url('admin/layanan') ?>" class="nav-link">LAYANAN</a>
        </nav>

        <a href="<?= base_url('auth/logout') ?>" class="logout-btn">
            Logout <i class="bi bi-box-arrow-right"></i>
        </a>
    </div>

    <div class="main-content">
        
        <div class="top-navbar">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <div class="date-text">
                    <i class="bi bi-calendar3 me-2"></i> <?= isset($tanggal) ? $tanggal : date('l, d/m/Y'); ?>
                </div>
            </div>
        </div>

        <div class="content-wrapper">

            <div class="custom-card mb-4">
                <div class="welcome-section">
                    <div>
                        <h3 class="fw-bold mb-3" style="color: #2005A2;">SELAMAT DATANG ADMIN !</h3>
                        
                        <p class="mb-0" style="color: #333; font-size: 1rem; max-width: 500px; line-height: 1.6;">
                            Ini adalah panel kontrol utama. Anda dapat mengelola produk, melihat statistik, dan memperbarui informasi website dari sini.
                        </p>
                    </div>
                    
                    <img src="<?= base_url('assets/images/admin 1.png') ?>" class="welcome-img" alt="Work">
                </div>
            </div>

            <div class="row g-4 mb-4">
                
                <div class="col-md-4">
                    <div class="custom-card d-flex flex-column justify-content-between">
                        <div class="stat-title">Total Produk</div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="stat-val" id="kpi-produk"><?= number_format($total_produk); ?></div>
                            <svg class="icon-shirt" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="custom-card d-flex flex-column justify-content-between">
                        <div class="stat-title">Total Konsultasi<br>Via Whatsapp</div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="stat-val" id="kpi-wa"><?= number_format($total_wa); ?></div>
                            <i class="bi bi-chat-left-text stat-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="custom-card d-flex flex-column justify-content-between">
                        <div class="stat-title">Pengunjung Situs</div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="stat-val" id="kpi-visitors"><?= number_format($total_visitors); ?></div>
                            <i class="bi bi-graph-up-arrow stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                
                <div class="col-md-7">
                    <div class="custom-card">
                        <div class="section-header">
                            <i class="bi bi-bar-chart-line fs-4"></i>
                            Produk Paling sering di Kunjungi
                        </div>
                        <div style="height: 320px;">
                            <canvas id="produkChart"></canvas>
                        </div>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                const ctx = document.getElementById('produkChart').getContext('2d');
                const dataKategori = <?php echo json_encode($top_products); ?>;
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: dataKategori.map(item => item.kategori.toUpperCase().replace('_', ' ')),
                        datasets: [{
                            label: 'Kunjungan',
                            data: dataKategori.map(item => item.total_views), 
                            backgroundColor: '#81bef7', 
                            borderRadius: 4,
                            barThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 35,
                                grid: { color: '#e0e0e0' },
                                ticks: { font: { weight: 'bold' } }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { weight: 'bold' } }
                            }
                        }
                    }
                });
            </script>

                <div class="col-md-5">
                    <div class="custom-card">
                        <h5 class="fw-bold mb-1">Aktivitas Website</h5>
                        <p class="text-muted small mb-4 fw-bold">Status Konten Halaman</p>

                        <div id="activity-list-container">
            
                         <div id="activity-list-container">
                
                        <?php if (empty($latest_activities)): ?>
                            <div class="alert alert-info text-center" role="alert">
                                <i class="bi bi-info-circle me-2"></i> Belum ada aktivitas terbaru yang tercatat.
                            </div>
                        <?php else: ?>
                            <?php foreach ($latest_activities as $activity): 
                                $time_ago = date('d/M H:i', strtotime($activity['waktu'])); 
                            ?>
                                <div class="activity-item">
                                    <div class="check-circle"><i class="bi bi-check"></i></div>
                                    <div>
                                        <?= $activity['deskripsi']; ?> 
                                        <small class="text-muted">
                                            Oleh: <?= isset($activity['oleh']) ? $activity['oleh'] : 'Admin'; ?> 
                                            - <?= date('d/M H:i', strtotime($activity['waktu'])); ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div> <a href="<?= base_url('admin/riwayat') ?>" class="btn-riwayat" style="text-decoration: none;">
                        Lihat Riwayat <i class="bi bi-clock-history"></i>
                    </a>
                    </div>
                </div>

            </div>

        </div> 

    </div>

    <script>
        function updateKpiNumbers() {
            fetch('<?= base_url('admin/get_kpi_json'); ?>')
                .then(response => response.json())
                .then(data => {
                    // Memformat angka dengan koma/titik sebagai pemisah ribuan
                    const formatNumber = (num) => new Intl.NumberFormat('id-ID').format(num);

                    // Update Total Produk
                    document.getElementById('kpi-produk').textContent = formatNumber(data.total_produk);
                    
                    // Update Total Konsultasi WA
                    document.getElementById('kpi-wa').textContent = formatNumber(data.total_wa);
                    
                    // Update Total Pengunjung Situs
                    document.getElementById('kpi-visitors').textContent = formatNumber(data.total_visitors);
                })
                .catch(error => {
                    console.error('Error fetching KPI data:', error);
                });
        }

        // Panggil fungsi segera setelah halaman dimuat
        updateKpiNumbers(); 

        // Panggil fungsi setiap 10 detik (10000 milidetik), lebih jarang dari aktivitas
        setInterval(updateKpiNumbers, 10000);
        
    </script>

</body>
</html>