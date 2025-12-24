<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-blue: #1a0380; 
            --page-bg: #FFFFFF;       
            --card-bg: #EEF8FF;       
            --header-table-bg: #CFD8EF; /* Warna Header Tabel sesuai gambar */
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

        /* --- MAIN CONTENT --- */
        .main-content { margin-left: 260px; }


        /* Class Khusus untuk Menu Dashboard di Halaman Riwayat */
        /* Teks Putih Terang, TAPI Tidak ada Background Biru Terang */
        .nav-link.parent-active {
            color: #FFFFFF !important; /* Putih Terang */
            font-weight: 700;
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

        .section-title {
            font-weight: 800;
            font-size: 2rem;
            margin-bottom: 30px;
            color: #000;
        }

        /* TABEL STYLE */
        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #000;
            border-radius: 8px;
            overflow: hidden;
        }

        .table-custom th, .table-custom td {
            padding: 12px 20px;
            border-bottom: 1px solid #000;
            border-right: 1px solid #000;
            font-size: 0.95rem;
            color: #000;
        }

        .table-custom th:last-child, .table-custom td:last-child {
            border-right: none;
        }

        .table-custom tr:last-child td {
            border-bottom: none;
        }

        .table-custom thead {
            background-color: var(--header-table-bg); /* Biru Muda */
        }

        .table-custom th {
            font-weight: 700;
            text-align: center;
        }

        .table-custom tbody tr {
            background-color: #fff;
        }
        
        .table-custom td {
            vertical-align: middle;
        }

        /* TOMBOL BAWAH */
        .btn-download {
            background-color: #240099;
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .btn-download:hover { background-color: #1a0380; color: white; }

        .btn-tutup {
            background-color: white;
            color: black;
            padding: 10px 40px;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid #000;
            display: inline-flex;
            align-items: center;
        }
        .btn-tutup:hover { background-color: #f0f0f0; }

        .action-buttons {
            display: flex;
            gap: 20px;
            margin-top: 30px;
            align-items: center;
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
            <a href="#" class="nav-link">PRODUK</a>
            <a href="#" class="nav-link">HALAMAN</a>
            <a href="#" class="nav-link">LAYANAN</a>
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
            <div class="user-profile">
                <i class="bi bi-person-circle fs-2"></i>
                <span><?= strtoupper($nama_admin); ?></span>
            </div>
        </div>

        <div class="content-wrapper">
            <?php 
                $CI =& get_instance(); 
            ?>

             <?php if ($CI->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 25px;">
                    <?= $CI->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <h2 class="section-title">Riwayat</h2>

            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Hari, Tanggal</th>
                            <th style="width: 10%;">Waktu</th>
                            <th style="width: 40%;">Status</th>
                            <th style="width: 25%;">Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($logs as $log): ?>
                        <tr>
                            <td class="text-center">
                                <?php 
                                    $hari = [
                                        'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 
                                        'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
                                    ];
                                    $nama_hari = date('l', strtotime($log['waktu']));
                                    echo $hari[$nama_hari] . ', ' . date('d/m/Y', strtotime($log['waktu'])); 
                                ?>
                            </td>
                            
                            <td class="text-center">
                                <?= date('H:i', strtotime($log['waktu'])); ?>
                            </td>
                            
                            <td style="padding-left: 30px;">
                                <?= $log['deskripsi']; ?>
                            </td>
                            
                            <td class="text-center">
                                <?= isset($log['oleh']) ? $log['oleh'] : 'Admin'; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="action-buttons">
                <a href="<?= base_url('admin/export_riwayat_csv'); ?>" class="btn-download">
                    Mengunduh CSV <i class="bi bi-download"></i>
                </a>
                
                <a href="<?= base_url('admin/dashboard') ?>" class="btn-tutup">
                    Tutup
                </a>
            </div>

        </div> 

    </div>

</body>
</html>