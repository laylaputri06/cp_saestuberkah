<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-blue: #2005a2; 
            --active-blue: #304FFE; 
            --page-bg: #F5F7FA;       
            --card-bg: #FFFFFF;       
            --header-bg: #EEF8FF;
            --text-dark: #1F2937;
            --product-shadow: 0 5px 20px rgba(0,0,0,0.06); 
        }

        body { font-family: 'Poppins', sans-serif; background-color: var(--page-bg); overflow-x: hidden; margin: 0; }

        /* SIDEBAR */
        .sidebar { width: 260px; height: 100vh; background-color: var(--primary-blue); position: fixed; top: 0; left: 0; display: flex; flex-direction: column; padding: 30px 0; z-index: 1000; }
        .sidebar-logo { display: flex; align-items: center; gap: 12px; padding: 0 30px; margin-bottom: 50px; }
        .nav-link { color: rgba(255, 255, 255, 0.7); font-weight: 600; padding: 15px 30px; text-decoration: none; display: block; transition: 0.3s; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 0.5px; border-left: 5px solid transparent; }
        .nav-link:hover { color: white; background-color: rgba(255, 255, 255, 0.1); }
        .nav-link.active { background-color: var(--active-blue); color: white; border-left: 5px solid #fff; } 
        .logout-btn { margin: auto 30px 30px 30px; background-color: #4C6EF5; color: white; text-align: center; padding: 12px; border-radius: 12px; text-decoration: none; font-weight: 600; display: flex; justify-content: center; align-items: center; gap: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .logout-btn:hover { background-color: #3b5bdb; color: white; }

        /* CONTENT */
        .main-content { margin-left: 260px; }
        .top-navbar { background-color: var(--header-bg); padding: 20px 50px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 20px rgba(26, 3, 128, 0.08); margin-bottom: 40px; }
        .page-title { font-weight: 800; font-size: 1.6rem; margin: 0; color: var(--text-dark); }
        .date-text { font-size: 0.9rem; color: #666; margin-top: 4px; font-weight: 500; }
        .user-profile { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 1rem; color: var(--text-dark); }
        .content-wrapper { padding: 0 50px 50px 50px; }
        .section-title { font-weight: 800; font-size: 2rem; color: #000; margin-bottom: 25px; }

        /* FORM STYLE */
        .form-card { background-color: var(--card-bg); border-radius: 15px; padding: 40px; box-shadow: var(--product-shadow); }
        .form-label { font-weight: 600; color: #333; margin-bottom: 8px; }
        .form-control { border-radius: 8px; padding: 12px 15px; border: 1px solid #ddd; margin-bottom: 20px; transition: 0.3s; }
        .form-control:focus { border-color: var(--active-blue); box-shadow: 0 0 0 3px rgba(48, 79, 254, 0.1); }
        .input-group-text { background-color: #f0f4ff; border: 1px solid #ddd; color: var(--primary-blue); font-weight: bold; }
        .section-header { font-size: 1.1rem; font-weight: 700; color: var(--primary-blue); margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #eee; display: flex; align-items: center; gap: 10px; }
        .btn-simpan { background-color: var(--active-blue); color: white; border: none; padding: 12px 40px; border-radius: 8px; font-weight: 600; font-size: 1rem; transition: 0.3s; }
        .btn-simpan:hover { background-color: #1a0380; transform: translateY(-2px); }

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
            <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">DASHBOARD</a>
            <a href="<?= base_url('admin/produk') ?>" class="nav-link">PRODUK</a>            
            <a href="<?= base_url('admin/halaman') ?>" class="nav-link">HALAMAN</a>
            <a href="<?= base_url('admin/layanan') ?>" class="nav-link active">LAYANAN</a>
        </nav>
        <a href="<?= base_url('auth/logout') ?>" class="logout-btn">Logout <i class="bi bi-box-arrow-right"></i></a>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <div>
                <h1 class="page-title">Layanan</h1>
                <div class="date-text"><i class="bi bi-calendar3 me-2"></i> <?= isset($tanggal) ? $tanggal : date('l, d/m/Y'); ?></div>
            </div>
        </div>

        <div class="content-wrapper">
            <h2 class="section-title">Pengaturan Kontak</h2>
            <?= $this->session->flashdata('pesan'); ?>

            <div class="form-card">
                <form action="<?= base_url('admin/update_layanan') ?>" method="post">
                    <div class="row">
                        <div class="col-md-6 pe-md-5">
                            <div class="section-header">
                                <i class="bi bi-telephone-fill"></i> Kontak Utama
                            </div>

                            <label class="form-label">WhatsApp Admin 1 (Tombol Chat Utama)</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text">+62</span>
                                <input type="number" name="no_wa_1" class="form-control mb-0" placeholder="857xxxx" 
                                       value="<?= isset($konfig->no_wa_1) ? (substr($konfig->no_wa_1, 0, 2) == '62' ? substr($konfig->no_wa_1, 2) : $konfig->no_wa_1) : '' ?>">
                            </div>

                            <label class="form-label">WhatsApp Admin 2 (Cadangan)</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text">+62</span>
                                <input type="number" name="no_wa_2" class="form-control mb-0" placeholder="812xxxx" 
                                       value="<?= isset($konfig->no_wa_2) ? (substr($konfig->no_wa_2, 0, 2) == '62' ? substr($konfig->no_wa_2, 2) : $konfig->no_wa_2) : '' ?>">
                            </div>

                            <div class="mb-3 mt-4">
                                <label class="form-label">Email Resmi</label>
                                <input type="email" name="email" class="form-control" value="<?= isset($konfig->email) ? $konfig->email : '' ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jam Operasional</label>
                                <input type="text" name="jam_buka" class="form-control" value="<?= isset($konfig->jam_operasional) ? $konfig->jam_operasional : '' ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="4"><?= isset($konfig->alamat) ? $konfig->alamat : '' ?></textarea>
                            </div>
                        </div>

                        <div class="col-md-6 ps-md-5" style="border-left: 1px solid #f0f0f0;">
                            <div class="section-header">
                                <i class="bi bi-share-fill"></i> Sosial Media & Marketplace
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-instagram text-danger me-2"></i> Link Instagram</label>
                                <input type="text" name="instagram" class="form-control" value="<?= isset($konfig->instagram) ? $konfig->instagram : '' ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-tiktok text-dark me-2"></i> Link TikTok</label>
                                <input type="text" name="tiktok" class="form-control" value="<?= isset($konfig->tiktok) ? $konfig->tiktok : '' ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-facebook text-primary me-2"></i> Link Facebook</label>
                                <input type="text" name="facebook" class="form-control" value="<?= isset($konfig->facebook) ? $konfig->facebook : '' ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-youtube text-danger me-2"></i> Link YouTube</label>
                                <input type="text" name="youtube" class="form-control" value="<?= isset($konfig->youtube) ? $konfig->youtube : '' ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-briefcase-fill text-warning me-2"></i> Link Mbizmarket (E-Procurement)
                                </label>
                                <input type="text" name="mbizmarket" class="form-control" placeholder="https://www.mbizmarket.co.id/..." value="<?= isset($konfig->mbizmarket) ? $konfig->mbizmarket : '' ?>">
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn-simpan"><i class="bi bi-save-fill me-2"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>