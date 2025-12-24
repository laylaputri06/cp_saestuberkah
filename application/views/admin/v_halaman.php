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
            --primary-blue: #2005a2; 
            --active-blue: #304FFE;
            --page-bg: #FFFFFF;       
            --section-bg: #F0F8FF;    
            --header-bg: #EEF8FF;
            --text-dark: #1F2937;
            --text-gold: #D4AF37;     
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
        .section-title { font-weight: 800; font-size: 2rem; color: #000; margin-bottom: 30px; }

        /* CONTENT CARDS */
        .content-card {
            background-color: var(--section-bg);
            padding: 40px;
            margin-bottom: 30px;
            border-radius: 0;
            position: relative;
        }

        .edit-link {
            display: block;
            text-align: right;
            margin-top: 20px;
            color: #1a0380;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer; /* Ubah kursor jadi pointer agar terlihat bisa diklik */
        }
        .edit-link i { margin-left: 5px; }
        .edit-link:hover { text-decoration: underline; }

        /* Typography */
        .welcome-title-small { color: #C5A027; font-size: 1.2rem; margin-bottom: 10px; font-weight: 500; }
        .welcome-title-big { font-weight: 800; font-size: 1.5rem; color: #1A1A2E; margin-bottom: 20px; line-height: 1.3; max-width: 80%; }
        .welcome-desc { color: #4B5563; line-height: 1.6; font-size: 0.95rem; max-width: 90%; }
        .welcome-img { width: 100%; height: 250px; object-fit: cover; border-radius: 4px; }
        .about-title { font-weight: 800; font-size: 1.8rem; color: #1A1A2E; margin-bottom: 20px; }
        .vm-title { font-weight: 800; font-size: 1.8rem; color: #1A1A2E; margin-bottom: 30px; text-transform: uppercase; }
        .vm-sub { font-weight: 700; font-size: 1.1rem; color: #4B5563; text-align: center; margin-bottom: 15px; }
        .vm-text { color: #333; line-height: 1.6; font-size: 0.95rem; }
        .vm-list { padding-left: 20px; color: #333; line-height: 1.8; font-size: 0.95rem; }

        /* --- STYLE MODAL EDIT (Sama dengan Produk) --- */
        .modal-content { border-radius: 15px; border: none; overflow: hidden; }
        .modal-header { background-color: var(--active-blue); color: white; padding: 15px 25px; border-bottom: none; }
        .modal-title { font-weight: 700; font-size: 1.2rem; }
        .btn-close-white { filter: invert(1) grayscale(100%) brightness(200%); }
        .modal-body { padding: 30px; }

        /* Area Upload & Form */
        .upload-area { background-color: #FFFFFF; border: 1px solid #ddd; height: 220px; width: 100%; border-radius: 4px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; overflow: hidden; }
        .upload-area img { width: 100%; height: 100%; object-fit: contain; }
        .btn-upload { background-color: var(--active-blue); color: white; width: 100%; padding: 10px; border-radius: 8px; font-weight: 600; border: none; display: flex; align-items: center; justify-content: center; gap: 8px; }
        
        .form-label { font-weight: 600; font-size: 0.9rem; margin-bottom: 5px; color: #333; }
        .form-control { border-radius: 8px; padding: 10px 15px; border: 1px solid #ccc; margin-bottom: 15px; }
        textarea.form-control { resize: none; height: 100px; }

        .modal-footer-custom { display: flex; justify-content: flex-end; gap: 15px; margin-top: 20px; }
        .btn-batal { background-color: #E5E7EB; color: #333; border: none; padding: 8px 30px; border-radius: 6px; font-weight: 600; }
        .btn-simpan { background-color: var(--active-blue); color: white; border: none; padding: 8px 30px; border-radius: 6px; font-weight: 600; }

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
        <a href="<?= base_url('auth/logout') ?>" class="logout-btn">Logout <i class="bi bi-box-arrow-right"></i></a>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <div>
                <h1 class="page-title">Halaman</h1>
                <div class="date-text"><i class="bi bi-calendar3 me-2"></i> <?= isset($tanggal) ? $tanggal : date('l, d/m/Y'); ?></div>
            </div>
        </div>

        <div class="content-wrapper">
            <h2 class="section-title">Kelola Halaman</h2>

            <div class="content-card">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="welcome-title-small"><?= $welcome['judul_kecil']; ?></div>
                        <h3 class="welcome-title-big"><?= $welcome['judul_utama']; ?></h3>
                        <p class="welcome-desc"><?= $welcome['deskripsi']; ?></p>
                    </div>
                    <div class="col-md-5">
                        <div class="col-md-5">
                            <img src="<?= base_url('assets/images/' . $welcome['foto']) ?>" class="welcome-img" alt="Hero Image" >
                        </div>
                    </div>
                </div>
                <a class="edit-link" data-bs-toggle="modal" data-bs-target="#modalEditWelcome">
                    Edit Halaman Selamat Datang <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
            </div>

            <div class="content-card">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h3 class="about-title"><?= $about['judul_kecil']; ?></h3>
                        <div class="welcome-desc" style="text-align: justify;">
                            <?php 
                            $paragraf_about = explode("\n", $about['deskripsi'] ?? ''); 

                            foreach ($paragraf_about as $p) {
                                if (!empty(trim($p))) {
                                    echo '<p style="margin-bottom: 15px; line-height: 1.6;">' . trim($p) . '</p>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <img src="<?= base_url('assets/images/' . $about['foto']) ?>" class="img-fluid rounded shadow mb-3" alt="Team">
                    </div>
                </div>
                <a class="edit-link" data-bs-toggle="modal" data-bs-target="#modalEditAbout">
                    Edit Halaman Tentang Kami <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
            </div>

            <div class="content-card">
                <h3 class="vm-title">VISI & MISI</h3>
                <div class="row">
                    <div class="col-md-6 border-end">
                        <h4 class="vm-sub">Visi</h4>
                        <p class="vm-text text-center px-4"><?= $visi_misi['judul_utama']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <h4 class="vm-sub">Misi</h4>
                        <ol class="vm-list">
                            <?php 
                                $misi_array = explode("\n", $visi_misi['deskripsi']); 
                                foreach($misi_array as $m): if(!empty(trim($m))): ?>
                                <li><?= trim($m); ?></li>
                            <?php endif; endforeach; ?>
                        </ol>
                    </div>
                </div>
                <a class="edit-link" data-bs-toggle="modal" data-bs-target="#modalEditVisi">
                    Edit Halaman Visi & Misi <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalEditWelcome" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tag Line Halaman Beranda</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/update_konten_halaman') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="slug" value="beranda">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="upload-area">
                                    <img src="<?= base_url('assets/images/' . $welcome['foto']) ?>" class="welcome-img" alt="Hero Image" id="prev-welcome">
                                </div>
                                <input type="file" name="foto" id="file-welcome" class="d-none" onchange="previewImg(this, 'prev-welcome')">
                                <button type="button" class="btn-upload" onclick="document.getElementById('file-welcome').click()">
                                    <i class="bi bi-cloud-arrow-up-fill"></i> Ganti Photo
                                </button>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label">Judul Kecil</label>
                                <input type="text" name="judul_kecil" class="form-control" value="<?= $welcome['judul_kecil']; ?>">

                                <label class="form-label">Judul Utama</label>
                                <textarea name="judul_utama" class="form-control"><?= $welcome['judul_utama']; ?></textarea>

                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control"><?= $welcome['deskripsi']; ?></textarea>

                                <div class="modal-footer-custom">
                                    <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                                    <button type="button" class="btn-batal" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditAbout" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Halaman Tentang Kami</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/update_konten_halaman') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="slug" value="tentang_kami">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="upload-area">
                                    <img src="<?= base_url('assets/images/' . $about['foto']) ?>" class="welcome-img" alt="About Image" id="prev-about">
                                </div>
                                <input type="file" name="foto" id="file-about" class="d-none" onchange="previewImg(this, 'prev-about')">
                                <button type="button" class="btn-upload" onclick="document.getElementById('file-about').click()">
                                    <i class="bi bi-cloud-arrow-up-fill"></i> Ganti Photo
                                </button>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label">Judul Section</label>
                                <input type="text" name="judul_kecil" class="form-control" value="<?= $about['judul_kecil'] ?? ''; ?>">
                                
                                <label class="form-label">Deskripsi Tentang Kami</label>
                                <textarea name="deskripsi" class="form-control" style="height: 150px;"><?= $about['deskripsi'] ?? ''; ?></textarea>

                                <div class="modal-footer-custom">
                                    <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                                    <button type="button" class="btn-batal" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditVisi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Visi & Misi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/update_konten_halaman') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="slug" value="visi_misi">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Visi Perusahaan</label>
                                <textarea name="judul_utama" class="form-control" style="height: 200px;"><?= $visi_misi['judul_utama']; ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Misi Perusahaan</label>
                                <div id="misi-container">
                                    <?php 
                                    // 1. Ambil data deskripsi dari variabel $visi_misi, bukan $sections
                                    // 2. Gunakan ?? '' untuk menghindari error "null"
                                    $misi_text = $visi_misi['deskripsi'] ?? '';
                                    
                                    // 3. Pecah teks menjadi array berdasarkan baris baru
                                    $misi_array = explode("\n", $misi_text); 
                                    $count = 1;
                                    // 4. Lakukan foreach pada array yang baru dibuat
                                    foreach($misi_array as $m): 
                                        if(!empty(trim($m))): 
                                    ?>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text bg-light"><?= $count++ ?></span>
                                            <input type="text" name="misi[]" class="form-control" value="<?= trim($m); ?>">
                                        </div>
                                    <?php 
                                        endif; 
                                    endforeach; 
                                    ?>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addMisiField()">+ Tambah Poin Misi</button>
                            </div>
                        <div class="modal-footer-custom">
                        <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                        <button type="button" class="btn-batal" data-bs-dismiss="modal">Batal</button>
                    </div>
                            </div>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi Preview Gambar agar Admin bisa melihat foto sebelum diupload
        function previewImg(input, targetID) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(targetID).src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function addMisiField() {
            const container = document.getElementById('misi-container');
            // Menghitung jumlah elemen saat ini untuk menentukan nomor urut
            const index = container.querySelectorAll('.input-group').length + 1;
            
            const html = `
                <div class="input-group mb-2">
                    <span class="input-group-text bg-light">${index}</span>
                    <input type="text" name="misi[]" class="form-control" placeholder="Masukkan poin misi baru...">
                    <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }
    </script>

</body>
</html>