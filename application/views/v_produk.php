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
            --bg-body: #F8FAFC; 
            --card-bg: #FFFFFF; 
            --watermark-color: #1a0380; 
        }
        
        body { font-family: 'Poppins', sans-serif; background-color: var(--bg-body); margin: 0; overflow-x: hidden; }

        .wrapper { display: flex; width: 100%; min-height: 100vh; }
        .sidebar { width: 280px; background-color: var(--primary-blue); color: white; position: fixed; top: 0; left: 0; height: 100vh; padding: 40px 30px; z-index: 1000; overflow-y: auto; }
        .content { margin-left: 280px; width: calc(100% - 280px); padding: 40px 50px; background-color: var(--bg-body); }

        .sidebar-brand { display: flex; align-items: center; gap: 8px; margin-bottom: 60px; text-decoration: none; color: white; }
        .nav-link-custom { display: block; color: rgba(255, 255, 255, 0.7); text-decoration: none; font-size: 16px; padding: 12px 0; transition: 0.3s; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .nav-link-custom:hover, .nav-link-custom.active { color: white; font-weight: 600; transform: translateX(5px); }

        /* GRID SYSTEM CUSTOM (LAYOUT LETER L - 5 ITEM) */
        .grid-custom-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 280px 280px 280px; 
            gap: 24px;
            margin-bottom: 40px;
        }

        /* Mapping Posisi Card Letter L */
        .pos-left-1 { grid-column: 1 / 2; grid-row: 1 / 2; }
        .pos-left-2 { grid-column: 1 / 2; grid-row: 2 / 3; }
        .pos-left-3 { grid-column: 1 / 2; grid-row: 3 / 4; }
        .pos-hero   { grid-column: 2 / 3; grid-row: 1 / 3; } 
        .pos-right-3 { grid-column: 2 / 3; grid-row: 3 / 4; }

        /* Card Design Umum */
        .card-product { border: none; background: transparent; cursor: pointer; transition: transform 0.3s; height: 100%; width: 100%; display: flex; flex-direction: column; }
        .card-product:hover { transform: translateY(-5px); }

        .img-box {
            background-color: var(--card-bg); 
            border-radius: 20px; 
            padding: 20px; /* Beri sedikit ruang agar gambar tidak menempel ke tepi */
            display: flex; 
            align-items: center;      /* Rata tengah vertikal */
            justify-content: center;   /* Rata tengah horizontal */
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            flex-grow: 1; 
            position: relative; 
            overflow: hidden;
            width: 100%; 
            height: 100%;
        }
        
        .img-box img { 
            width: 100%; height: 100%; object-fit: cover; z-index: 1; 
        } 

        /* STYLE KHUSUS GALERI (2 KOLOM) */
        .gallery-card {
            height: 350px; /* Tinggi kotak galeri */
        }

        /* WATERMARK STYLE */
        .watermark {
            position: absolute; top: 20px; left: 25px; z-index: 10;
            display: flex; align-items: center; gap: 8px;
        }
        .watermark img { height: 28px !important; width: auto !important; object-fit: contain; } 
        .watermark-text {
            color: var(--watermark-color); line-height: 1.1; font-weight: 800; font-size: 0.85rem; text-align: left;
        }

        @media (max-width: 991px) {
            .sidebar { position: relative; width: 100%; height: auto; }
            .content { margin-left: 0; width: 100%; padding: 20px; }
            .wrapper { flex-direction: column; }
            .grid-custom-layout { display: flex; flex-direction: column; gap: 20px; }
            .grid-custom-layout > div { height: 300px; }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="sidebar">
        <a href="<?= base_url() ?>" class="sidebar-brand">
            <img src="<?= base_url('assets/images/js logo sb.png') ?>" alt="Logo" style="height: 50px;">
            <div>
                <div style="font-weight: 700; font-size: 18px;">Konveksi</div>
                <div style="font-weight: 300; font-size: 14px;">Saestu Berkah</div>
            </div>
        </a>
        <nav>
            <a href="<?= base_url('produk/hit_and_view/kaos_polos') ?>" class="nav-link-custom <?= ($kategori_aktif == 'kaos_polos') ? 'active' : '' ?>">Seragam Kaos polos</a>
            <a href="<?= base_url('produk/hit_and_view/kaos_polo') ?>" class="nav-link-custom <?= ($kategori_aktif == 'kaos_polo') ? 'active' : '' ?>">Seragam Polo</a>
            <!-- <a href="<?= base_url('produk/index/jaket') ?>" class="nav-link-custom <?= ($kategori_aktif == 'jaket') ? 'active' : '' ?>">Seragam Jaket</a> -->
            <a href="<?= base_url('produk/hit_and_view/kemeja_dan_PDH') ?>" class="nav-link-custom <?= ($kategori_aktif == 'kemeja_dan_PDH') ? 'active' : '' ?>">Seragam Kemeja & PDH</a>
            <a href="<?= base_url('produk/hit_and_view/rompi') ?>" class="nav-link-custom <?= ($kategori_aktif == 'rompi') ? 'active' : '' ?>">Seragam Rompi</a>
            <div style="height: 20px;"></div>
            <a href="<?= base_url('produk/index/galeri') ?>" class="nav-link-custom <?= ($kategori_aktif == 'galeri') ? 'active' : '' ?>">Galeri Pelanggan</a>
        </nav>
    </div>

    <div class="content">
        <div class="mb-5">
            <h2 class="fw-bold" style="color: #1A1A2E; font-size: 2.5rem;"><?= $judul_halaman; ?></h2>
            <p class="text-muted">Koleksi Produk Kami</p>
        </div>

        <?php if($kategori_aktif == 'galeri'): ?>
            
            <div class="row g-4">
                <?php foreach($produk_list as $p): ?>
                <div class="col-md-6"> <div class="card-product gallery-card">
                        <div class="img-box">
                            <div class="watermark">
                                <img src="<?= base_url('assets/images/logo biru.png') ?>" alt="Logo">
                                <div class="watermark-text">
                                    <div>Konveksi</div>
                                    <div>Saestu Berkah</div>
                                </div>
                            </div>
                            <img src="<?= base_url('assets/images/produk/' . $kategori_aktif . '/' . $p['file_name']) ?>" 
                                class="product-img" 
                                alt="Galeri Pelanggan"
                                style="width: 100%; height: 85%; object-fit: cover; border-radius: 10px;">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>

            <?php 
            $chunks = array_chunk($produk_list, 5);
            foreach($chunks as $batch): 
            ?>
            <div class="grid-custom-layout">
                
                <?php if(isset($batch[0])): ?>
                <div class="card-product pos-left-1">
                    <div class="img-box">
                        <div class="watermark">
                            <img src="<?= base_url('assets/images/logo biru.png') ?>" alt="Logo">
                            <div class="watermark-text"><div>Konveksi</div><div>Saestu Berkah</div></div>
                        </div>
                        <img src="<?= base_url('assets/images/produk/' . $kategori_aktif . '/' . $batch[0]['file_name']) ?>" alt="Produk">
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($batch[1])): ?>
                <div class="card-product pos-left-2">
                    <div class="img-box">
                        <div class="watermark">
                            <img src="<?= base_url('assets/images/logo biru.png') ?>" alt="Logo">
                            <div class="watermark-text"><div>Konveksi</div><div>Saestu Berkah</div></div>
                        </div>
                        <img src="<?= base_url('assets/images/produk/' . $kategori_aktif . '/' . $batch[1]['file_name']) ?>" alt="Produk">
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($batch[2])): ?>
                <div class="card-product pos-left-3">
                    <div class="img-box">
                        <div class="watermark">
                            <img src="<?= base_url('assets/images/logo biru.png') ?>" alt="Logo">
                            <div class="watermark-text"><div>Konveksi</div><div>Saestu Berkah</div></div>
                        </div>
                        <img src="<?= base_url('assets/images/produk/' . $kategori_aktif . '/' . $batch[2]['file_name']) ?>" alt="Produk">
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($batch[3])): ?>
                <div class="card-product pos-hero">
                    <div class="img-box">
                        <div class="watermark">
                            <img src="<?= base_url('assets/images/logo biru.png') ?>" alt="Logo">
                            <div class="watermark-text"><div>Konveksi</div><div>Saestu Berkah</div></div>
                        </div>
                        <img src="<?= base_url('assets/images/produk/' . $kategori_aktif . '/' . $batch[3]['file_name']) ?>" alt="Produk Besar">
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($batch[4])): ?>
                <div class="card-product pos-right-3">
                    <div class="img-box">
                        <div class="watermark">
                            <img src="<?= base_url('assets/images/logo biru.png') ?>" alt="Logo">
                            <div class="watermark-text"><div>Konveksi</div><div>Saestu Berkah</div></div>
                        </div>
                        <img src="<?= base_url('assets/images/produk/' . $kategori_aktif . '/' . $batch[4]['file_name']) ?>" alt="Produk">
                    </div>
                </div>
                <?php endif; ?>

            </div>
            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</div>

<a href="<?= base_url() ?>" style="position: fixed; bottom: 30px; right: 30px; background: white; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 5px 15px rgba(0,0,0,0.2); color: var(--primary-blue); text-decoration: none; z-index: 9999;">
    <i class="bi bi-house-door-fill fs-4"></i>
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>