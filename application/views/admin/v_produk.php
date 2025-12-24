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
            --danger-red: #DC2626; /* Warna Merah untuk Hapus */
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

        /* TOOLBAR */
        .toolbar { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; }
        .btn-add { background-color: var(--active-blue); color: white; padding: 10px 25px; border-radius: 8px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 8px; border: none; font-size: 0.9rem; cursor: pointer; }
        .btn-add:hover { background-color: #1a0380; color: white; }
        .filter-btn { background-color: #FFFFFF; color: #333; padding: 10px 25px; border-radius: 5px; text-decoration: none; font-weight: 500; font-size: 0.95rem; box-shadow: 0 2px 5px rgba(0,0,0,0.05); transition: 0.3s; }
        .filter-btn:hover { background-color: #e5e7eb; }
        .filter-btn.active { background-color: #E0E7FF; color: #1a0380; font-weight: 700; border: 1px solid var(--active-blue); }

        /* CARD STYLE */
        .product-card { background-color: var(--card-bg); border-radius: 15px; padding: 0; box-shadow: var(--product-shadow); position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; width: 100%; transition: 0.3s; }
        .product-card:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.12); }
        .card-small { height: 250px; margin-bottom: 24px; }
        .card-large { height: 524px; margin-bottom: 24px; } 
        .card-grid  { height: 350px; } 
        .product-img { max-width: 100%; max-height: 100%; object-fit: cover; z-index: 2; }
        .watermark { position: absolute; top: 20px; left: 20px; z-index: 1; display: flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.8); padding: 5px 10px; border-radius: 20px; }
        .watermark img { height: 24px; }
        .watermark-text { color: #1a0380; line-height: 1.1; font-weight: 800; font-size: 0.75rem; }
        .action-container { position: absolute; bottom: 20px; right: 20px; display: flex; gap: 12px; z-index: 3; }
        
        /* ACTION ICONS */
        .action-icon { font-size: 1.3rem; color: #000; cursor: pointer; transition: 0.2s; }
        .action-icon:hover { color: var(--active-blue); transform: scale(1.1); }
        .action-icon.delete:hover { color: var(--danger-red); } /* Merah kalau di-hover */

        /* --- MODAL STYLE --- */
        .modal-content { border-radius: 15px; border: none; overflow: hidden; }
        .modal-header { background-color: var(--active-blue); color: white; padding: 15px 25px; border-bottom: none; }
        .modal-title { font-weight: 700; font-size: 1.2rem; }
        .btn-close-white { filter: invert(1) grayscale(100%) brightness(200%); }
        .modal-body { padding: 30px; }

        /* Area Upload & Form */
        .upload-area { background-color: #D1D5DB; height: 220px; width: 100%; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; overflow: hidden; }
        .upload-area img { width: 100%; height: 100%; object-fit: contain; } /* Tampilan Preview Gambar */
        .user-icon-placeholder { background-color: white; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .user-icon-placeholder i { font-size: 3rem; color: #D1D5DB; }
        .btn-upload { background-color: var(--active-blue); color: white; width: 100%; padding: 10px; border-radius: 8px; font-weight: 600; border: none; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .form-control, .form-select { border-radius: 8px; padding: 10px 15px; border: 1px solid #ccc; margin-bottom: 20px; }
        
        .modal-footer-custom { display: flex; justify-content: flex-end; gap: 15px; margin-top: 20px; }
        .btn-batal { background-color: #E5E7EB; color: #333; border: none; padding: 8px 30px; border-radius: 6px; font-weight: 600; }
        .btn-simpan { background-color: var(--active-blue); color: white; border: none; padding: 8px 30px; border-radius: 6px; font-weight: 600; }

        /* Modal Hapus Khusus */
        .modal-hapus-icon { font-size: 4rem; color: var(--danger-red); margin-bottom: 15px; display: block; text-align: center; }
        .modal-hapus-text { text-align: center; font-size: 1.1rem; font-weight: 500; color: #333; margin-bottom: 25px; }
        .btn-hapus-confirm { background-color: var(--danger-red); color: white; border: none; padding: 8px 30px; border-radius: 6px; font-weight: 600; }
        .btn-hapus-confirm:hover { background-color: #b91c1c; }

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
            <a href="<?= base_url('admin/produk') ?>" class="nav-link active">PRODUK</a>            
            <a href="<?= base_url('admin/halaman') ?>" class="nav-link">HALAMAN</a>
            <a href="<?= base_url('admin/layanan') ?>" class="nav-link">LAYANAN</a>
        </nav>
        <a href="<?= base_url('auth/logout') ?>" class="logout-btn">Logout <i class="bi bi-box-arrow-right"></i></a>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <div>
                <h1 class="page-title">Produk</h1>
                <div class="date-text"><i class="bi bi-calendar3 me-2"></i> <?= isset($tanggal) ? $tanggal : date('l, d/m/Y'); ?></div>
            </div>
        </div>

        <div class="content-wrapper">
            <h2 class="section-title">Kelola Produk</h2>
            
            <div class="toolbar">
                
                <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
                    <i class="bi bi-plus-lg"></i> Tambah Produk
                </button>
                
                <a href="<?= base_url('admin/produk/kemeja_dan_PDH') ?>" class="filter-btn <?= ($kategori_aktif == 'kemeja_dan_PDH') ? 'active' : '' ?>">Kemeja dan PDH</a>
                <a href="<?= base_url('admin/produk/kaos_polo') ?>" class="filter-btn <?= ($kategori_aktif == 'kaos_polo') ? 'active' : '' ?>">Kaos Polo</a>
                <a href="<?= base_url('admin/produk/kaos_polos') ?>" class="filter-btn <?= ($kategori_aktif == 'kaos_polos') ? 'active' : '' ?>">Kaos Polos</a>
                <a href="<?= base_url('admin/produk/rompi') ?>" class="filter-btn <?= ($kategori_aktif == 'rompi') ? 'active' : '' ?>">Rompi</a>
                <a href="<?= base_url('admin/produk/galeri') ?>" class="filter-btn <?= ($kategori_aktif == 'galeri') ? 'active' : '' ?>">Galeri Pelanggan</a>
            </div>

            <h3 class="fw-bold mb-4 text-dark"><?= $judul_kategori; ?></h3>

            <?php if(isset($is_dashboard) && $is_dashboard == true): ?>
                <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                    <h5 class="fw-bold mb-0"></i>Kemeja dan PDH</h5>
                    <a href="<?= base_url('admin/produk/kemeja_dan_PDH') ?>" class="btn btn-sm btn-outline-primary px-3" style="border-radius: 20px;">Lihat Lainnya</a>
                </div>
                <div class="row row-cols-2 row-cols-md-5 g-3 mb-5">
                    <?php foreach($preview_kemeja as $p): ?>
                        <div class="col">
                            <div class="product-card" style="height: 180px;">
                                <img src="<?= base_url('assets/images/produk/kemeja_dan_PDH/' . $p['file_name']) . '?t=' . time(); ?>" class="product-img">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"></i>Kaos Polo</h5>
                    <a href="<?= base_url('admin/produk/kaos_polo') ?>" class="btn btn-sm btn-outline-primary px-3" style="border-radius: 20px;">Lihat Lainnya</a>
                </div>
                <div class="row row-cols-2 row-cols-md-5 g-3 mb-5">
                    <?php foreach($preview_polo as $p): ?>
                        <div class="col">
                            <div class="product-card" style="height: 180px;">
                                <img src="<?= base_url('assets/images/produk/kaos_polo/' . $p['file_name']) . '?t=' . time(); ?>" class="product-img">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"></i>Kaos Polos</h5>
                    <a href="<?= base_url('admin/produk/kaos_polos') ?>" class="btn btn-sm btn-outline-primary px-3" style="border-radius: 20px;">Lihat Lainnya</a>
                </div>
                <div class="row row-cols-2 row-cols-md-5 g-3 mb-5">
                    <?php foreach($preview_polos as $p): ?>
                        <div class="col">
                            <div class="product-card" style="height: 180px;">
                                <img src="<?= base_url('assets/images/produk/kaos_polos/' . $p['file_name']) . '?t=' . time(); ?>" class="product-img">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"></i>Rompi</h5>
                    <a href="<?= base_url('admin/produk/rompi') ?>" class="btn btn-sm btn-outline-primary px-3" style="border-radius: 20px;">Lihat Lainnya</a>
                </div>
                <div class="row row-cols-2 row-cols-md-5 g-3 mb-5">
                    <?php foreach($preview_rompi as $p): ?>
                        <div class="col">
                            <div class="product-card" style="height: 180px;">
                                <img src="<?= base_url('assets/images/produk/rompi/' . $p['file_name']) . '?t=' . time(); ?>" class="product-img">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"></i>Galeri Pelanggan</h5>
                    <a href="<?= base_url('admin/produk/galeri') ?>" class="btn btn-sm btn-outline-primary px-3" style="border-radius: 20px;">Lihat Lainnya</a>
                </div>
                <div class="row row-cols-2 row-cols-md-4 g-3 mb-5">
                    <?php foreach($preview_galeri as $p): ?>
                        <div class="col">
                            <div class="product-card" style="height: 220px;">
                                <img src="<?= base_url('assets/images/produk/galeri/' . $p['file_name']) . '?t=' . time(); ?>" class="product-img">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>  
                <?php if($kategori_aktif == 'galeri'): ?>
                    <div class="row g-4">
                        <?php foreach($products as $p): ?>
                        <div class="col-md-6">
                            <div class="product-card card-grid"> 
                                <div class="watermark">
                                    <img src="<?= base_url('assets/images/logo biru.png') ?>" alt="Logo">
                                    <div class="watermark-text"><div>Konveksi</div><div>Saestu Berkah</div></div>
                                </div>
                                <img src="<?= base_url('assets/images/produk/' . $kategori_aktif . '/' . $p['file_name']) ?>" class="product-img" alt="Produk">
                                
                                <div class="action-container">
                                    <i class="bi bi-pencil-square action-icon" 
                                    onclick="persiapanEdit('<?= $p['id'] ?>', 'Produk <?= $kategori_aktif ?>', '<?= $kategori_aktif ?>', '<?= $p['file_name'] ?>')"></i>
                                    <i class="bi bi-trash3-fill action-icon delete" 
                                    onclick="konfirmasiHapus('<?= $p['id'] ?>', '<?= $kategori_aktif ?>')"></i>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                <?php else: 
                    $chunks = array_chunk($products, 5);
                    foreach($chunks as $chunk): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php for($i=0; $i<3; $i++): if(isset($chunk[$i])): $p=$chunk[$i]; ?>
                            <div class="product-card card-small">
                                <div class="watermark">
                                    <img src="<?= base_url('assets/images/logo biru.png') ?>" alt="Logo">
                                    <div class="watermark-text"><div>Konveksi</div><div>Saestu Berkah</div></div>
                                </div>
                                <img src="<?= base_url('assets/images/produk/' . $kategori_aktif . '/' . $p['file_name']) ?>" class="product-img" alt="Produk">
                                <div class="action-container">
                                    <i class="bi bi-pencil-square action-icon" 
                                    onclick="persiapanEdit('<?= $p['id'] ?>', 'Produk <?= $kategori_aktif ?>', '<?= $kategori_aktif ?>', '<?= $p['file_name'] ?>')"></i>
                                    <i class="bi bi-trash3-fill action-icon delete" 
                                    onclick="konfirmasiHapus('<?= $p['id'] ?>', '<?= $kategori_aktif ?>')"></i>
                                </div>
                            </div>
                            <?php endif; endfor; ?>
                        </div>

                        <div class="col-md-6">
                            <?php if(isset($chunk[3])): $p=$chunk[3]; ?>
                            <div class="product-card card-large">
                                <div class="watermark">
                                    <img src="<?= base_url('assets/images/logo biru.png') ?>" alt="Logo">
                                    <div class="watermark-text"><div>Konveksi</div><div>Saestu Berkah</div></div>
                                </div>
                                <img src="<?= base_url('assets/images/produk/' . $kategori_aktif . '/' . $p['file_name']) ?>" class="product-img" alt="Produk">
                                <div class="action-container">
                                    <i class="bi bi-pencil-square action-icon" 
                                    onclick="persiapanEdit('<?= $p['id'] ?>', 'Produk <?= $kategori_aktif ?>', '<?= $kategori_aktif ?>', '<?= $p['file_name'] ?>')"></i>
                                    <i class="bi bi-trash3-fill action-icon delete" 
                                    onclick="konfirmasiHapus('<?= $p['id'] ?>', '<?= $kategori_aktif ?>')"></i>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(isset($chunk[4])): $p=$chunk[4]; ?>
                            <div class="product-card card-small">
                                <div class="watermark">
                                    <img src="<?= base_url('assets/images/logo biru.png') ?>" alt="Logo">
                                    <div class="watermark-text"><div>Konveksi</div><div>Saestu Berkah</div></div>
                                </div>
                                <img src="<?= base_url('assets/images/produk/' . $kategori_aktif . '/' . $p['file_name']) ?>" class="product-img" alt="Produk">
                                <div class="action-container">
                                    <i class="bi bi-pencil-square action-icon" 
                                    onclick="persiapanEdit('<?= $p['id'] ?>', 'Produk <?= $kategori_aktif ?>', '<?= $kategori_aktif ?>', '<?= $p['file_name'] ?>')"></i>
                                    <i class="bi bi-trash3-fill action-icon delete" 
                                    onclick="konfirmasiHapus('<?= $p['id'] ?>', '<?= $kategori_aktif ?>')"></i>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; endif; ?>

            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/save_produk') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="upload-area" id="preview-container">
                                    <div class="user-icon-placeholder" id="placeholder-icon">
                                        <i class="bi bi-image-fill" style="font-size: 3rem; color: #D1D5DB;"></i>
                                    </div>
                                </div>
                                
                                <input type="file" name="foto_produk" id="file-input" class="d-none" accept="image/*" required>
                                
                                <button type="button" class="btn-upload" onclick="document.getElementById('file-input').click()">
                                    <i class="bi bi-cloud-arrow-up-fill"></i> Upload Photo
                                </button>
                            </div>
                            
                            <div class="col-md-7 d-flex flex-column justify-content-center">
                                <label class="fw-bold mb-1">Nomor Urut Gambar</label>
                                <input type="number" name="nomor_file" class="form-control" placeholder="Contoh: 1" required>
                                
                                <label class="fw-bold mb-1">Pilih Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="" selected disabled>Pilih Kategori</option>
                                    <option value="kemeja_dan_PDH">Kemeja dan PDH</option>
                                    <option value="kaos_polo">Kaos Polo</option>
                                    <option value="kaos_polos">Kaos Polos</option>
                                    <option value="rompi">Rompi</option>
                                    <option value="galeri">Galeri Pelanggan</option>
                                </select>

                                <div class="modal-footer-custom">
                                    <button type="submit" class="btn-simpan">Simpan</button>
                                    <button type="button" class="btn-batal" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHapusProduk" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body pt-5 pb-5">
                    <h4 class="text-center fw-bold mb-3">Hapus Produk?</h4>
                    <p class="modal-hapus-text">Apakah Anda yakin ingin menghapus produk ini? <br>Tindakan ini tidak dapat dibatalkan.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn-batal" data-bs-dismiss="modal">Batal</button>
                        <a href="#" id="btn-confirm-delete" class="btn btn-danger py-2 px-4" style="border-radius: 10px; font-weight: bold;">Ya, Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditProduk" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Produk</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="<?= base_url('admin/update_produk') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit-id"> <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div id="preview-edit-container" class="upload-area" style="background: white; border: 1px solid #ddd;">
                                <img id="img-edit-preview" src="" alt="Preview">
                            </div>
                            <input type="file" name="foto_produk" id="file-edit-input" style="display:none;" accept="image/*">
                            <button type="button" class="btn-upload" onclick="document.getElementById('file-edit-input').click()">
                                <i class="bi bi-cloud-arrow-up-fill"></i> Ganti Photo
                            </button>
                        </div>
                        <div class="col-md-7 d-flex flex-column justify-content-center">
                                <label class="fw-bold mb-1">Nomor Urut Gambar</label>
                                <input type="number" name="nomor_file" id="edit-nomor" class="form-control bg-light" readonly>
                                <small class="text-muted mb-3">*Nomor urut posisi gambar tetap (tidak bisa diubah).</small>
                                
                                <label class="fw-bold mb-1">Kategori</label>
                                <input type="text" id="display-kategori" class="form-control bg-light" readonly>
                                <input type="hidden" name="kategori" id="edit-kategori">
                                <small class="text-muted mb-3">*Kategori penempatan sudah sesuai posisi asli.</small>

                            <div class="modal-footer-custom">
                                    <button type="submit" class="btn-simpan">Update</button>
                                    <button type="button" class="btn-batal" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.getElementById('file-input').onchange = function (evt) {
        const [file] = this.files;
        if (file) {
            const container = document.getElementById('preview-container');
            container.innerHTML = `<img src="${URL.createObjectURL(file)}" style="width:100%; height:100%; object-fit:contain;">`;
        }
        };

        function konfirmasiHapus(id, kategori) {
            const urlHapus = "<?= base_url('admin/hapus_produk/') ?>" + id + "/" + kategori;
            const btnDelete = document.getElementById('btn-confirm-delete');
        
            if (btnDelete) {
                btnDelete.setAttribute('href', urlHapus);
                
                var modalEl = document.getElementById('modalHapusProduk');
                var myModal = bootstrap.Modal.getOrCreateInstance(modalEl); 
                
                // Tambahkan timeout singkat untuk memastikan DOM siap menampilkan modal
                setTimeout(() => {
                    myModal.show();
                }, 50); 
            } else {
                console.error("Elemen 'btn-confirm-delete' tidak ditemukan!");
            }
        }

        // 1. Letakkan listener onchange di LUAR fungsi agar efisien
        document.getElementById('file-edit-input').onchange = function (evt) {
            const [file] = this.files; // Ambil file dari input
            if (file) {
                // Buat URL sementara untuk pratinjau
                const objectUrl = URL.createObjectURL(file);
                const previewImg = document.getElementById('img-edit-preview');
                
                previewImg.src = objectUrl;
                
                // Pastikan styling tetap rapi
                previewImg.style.width = '100%';
                previewImg.style.height = '100%';
                previewImg.style.objectFit = 'contain';
            }
        };

        // 2. Fungsi untuk menyiapkan data modal
        function persiapanEdit(id, nama, kategori, foto, nomor) {
            // Isi ID dan Kategori ke form
            document.getElementById('edit-id').value = id;
            if(document.getElementById('edit-kategori')) {
                document.getElementById('edit-kategori').value = kategori;
            }
            
            // Tampilkan teks kategori untuk user (Opsional)
            if(document.getElementById('display-kategori')) {
                document.getElementById('display-kategori').value = kategori.replace(/_/g, " ").toUpperCase();
            }

            // Isi Nomor Urut agar bisa dicatat di riwayat
            if(document.getElementById('edit-nomor')) {
                document.getElementById('edit-nomor').value = nomor;
            }

            // Set Preview Gambar Lama (Tambahkan anti-cache dengan timestamp)
            const pathFoto = "<?= base_url('assets/images/produk/') ?>" + kategori + "/" + foto + "?t=" + new Date().getTime();
            document.getElementById('img-edit-preview').src = pathFoto;
            
            // Munculkan Modal Edit menggunakan Bootstrap Instance
            var modalEl = document.getElementById('modalEditProduk');
            var myModal = bootstrap.Modal.getOrCreateInstance(modalEl);
            myModal.show();
        }

    </script>
</body>
</html>