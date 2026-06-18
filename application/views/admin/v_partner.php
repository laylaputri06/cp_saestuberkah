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
        :root { --primary-blue: #2005a2; --page-bg: #FFFFFF; --card-bg: #EEF8FF; --text-dark: #1F2937; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--page-bg); margin: 0; }

        /* --- SIDEBAR & LAYOUT --- */
        .sidebar { width: 260px; height: 100vh; background-color: var(--primary-blue); position: fixed; top: 0; left: 0; display: flex; flex-direction: column; padding: 30px 0; z-index: 1000; }
        .sidebar-logo { display: flex; align-items: center; gap: 12px; padding: 0 30px; margin-bottom: 50px; }
        .nav-link { color: rgba(255, 255, 255, 0.7); font-weight: 600; padding: 15px 30px; text-decoration: none; display: block; transition: 0.3s; text-transform: uppercase; font-size: 0.9rem; border-left: 5px solid transparent; }
        .nav-link.active { background-color: #304FFE; color: white; border-left: 5px solid #fff; }
        .nav-link:hover { color: white; background-color: rgba(255, 255, 255, 0.1); }
        .main-content { margin-left: 260px; }
        .top-navbar { background-color: var(--card-bg); padding: 20px 50px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 20px rgba(26, 3, 128, 0.08); margin-bottom: 40px; }
        .content-wrapper { padding: 0 50px 50px 50px; }
        .section-title { font-weight: 800; font-size: 2rem; color: #000; }
        .page-title { font-weight: 800; font-size: 1.6rem; margin: 0; color: var(--text-dark); }

        /* --- GRID LOGO STYLE --- */
        .partner-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 25px; margin-top: 30px; }
        .partner-card { background: #fff; border: 1px solid #e0e0e0; border-radius: 12px; padding: 20px; text-align: center; transition: 0.3s; position: relative; }
        .partner-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); border-color: var(--active-blue); }
        .logo-display { height: 100px; width: 100%; object-fit: contain; margin-bottom: 15px; background: #fdfdfd; padding: 10px; }
        .partner-name { font-weight: 700; font-size: 0.9rem; color: var(--text-dark); margin-bottom: 15px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .card-actions { display: flex; gap: 10px; justify-content: center; }
        .modal-header { background-color: var(--primary-blue); color: white; padding: 15px 25px; border-bottom: none; }
        .btn-action-edit { background-color: #f0f7ff; color: #007bff; border: none; padding: 8px 15px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; transition: 0.3s; }
        .btn-action-delete { background-color: #fff5f5; color: #dc3545; border: none; padding: 8px 15px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; transition: 0.3s; }
        .btn-action-edit:hover { background-color: #007bff; color: white; }
        .btn-action-delete:hover { background-color: #dc3545; color: white; }

        /* Floating Add Button */
        .btn-add-partner { background-color: var(--primary-blue); color: white; padding: 12px 25px; border-radius: 30px; font-weight: 700; border: none; box-shadow: 0 4px 15px rgba(26, 3, 128, 0.2); }
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
            <a href="<?= base_url('admin/halaman') ?>" class="nav-link active">HALAMAN</a>
            <a href="<?= base_url('admin/layanan') ?>" class="nav-link">LAYANAN</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <div>
                <h1 class="page-title">Partner Kami</h1>
                <div class="date-text">
                    <i class="bi bi-calendar3 me-2"></i> <?= isset($tanggal) ? $tanggal : date('l, d/m/Y'); ?>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title">Kelola Partner</h2>
                <button class="btn-add-partner" data-bs-toggle="modal" data-bs-target="#modalTambahPartner">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Partner
                </button>
            </div>
            <div class="partner-grid">
                <?php foreach($partner as $p): ?>
                <div class="partner-card">
                    <img src="<?= base_url('assets/images/partner/' . $p['logo']); ?>" class="logo-display" alt="Logo">
                    <div class="partner-name"><?= $p['nama_partner']; ?></div>
                    <div class="card-actions">
                        <button class="btn-action-edit" data-bs-toggle="modal" data-bs-target="#modalEditPartner<?= $p['id_partner']; ?>">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <a href="<?= base_url('admin/hapus_partner/' . $p['id_partner']); ?>" 
                           class="btn-action-delete" onclick="return confirm('Hapus partner ini?')">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    </div>
                </div>

                <div class="modal fade" id="modalEditPartner<?= $p['id_partner']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Partner</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('admin/update_partner') ?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id_partner" value="<?= $p['id_partner']; ?>">
                                <div class="modal-body">
                                    <div class="text-center mb-4">
                                        <img src="<?= base_url('assets/images/partner/' . $p['logo']); ?>" id="prevEdit<?= $p['id_partner']; ?>" style="max-height: 80px; object-fit: contain;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-600">Ganti Logo</label>
                                        <input type="file" name="logo" class="form-control" onchange="previewImg(this, 'prevEdit<?= $p['id_partner']; ?>')">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-600">Nama Partner</label>
                                        <input type="text" name="nama_partner" class="form-control" value="<?= $p['nama_partner']; ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Update Partner</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambahPartner" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Partner Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/tambah_partner') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-600">Nama Instansi</label>
                            <input type="text" name="nama_partner" class="form-control" placeholder="Contoh: PT. Saestu Berkah" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-600">Upload Logo</label>
                            <input type="file" name="logo" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Simpan Partner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImg(input, targetID) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) { document.getElementById(targetID).src = e.target.result; }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>