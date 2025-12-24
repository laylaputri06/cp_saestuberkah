<section id="beranda" class="hero-section">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="pe-lg-5">
                    <h4 class="text-warning mb-2"><?= $welcome['judul_kecil']; ?></h4>
                    <h1 class="display-4 fw-bold text-dark mb-3"><?= $welcome['judul_utama']; ?></h1>
                    <p class="text-muted mb-4 lead"><?= $welcome['deskripsi']; ?></p>
                    <a href="<?= base_url('produk/index/kaos') ?>" class="btn btn-primary-custom rounded-pill px-4 py-2 fw-bold">JELAJAHI DESAIN KAMI</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?= base_url('assets/images/' . $welcome['foto']) ?>" class="img-fluid rounded shadow-sm" alt="Hero Image">
            </div>
        </div>
    </div>
    <div class="wave-container">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="#2005A2" fill-opacity="1" d="M0,96L40,112C80,128,160,160,240,170.7C320,181,400,171,480,192C560,213,640,267,720,266.7C800,267,880,213,960,181.3C1040,149,1120,139,1200,154.7C1280,171,1360,213,1400,234.7L1440,256L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"></path>
        </svg>
    </div>
</section>

<section id="produk" class="pt-3 pb-5">
    <div class="container">
        
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h2 class="fw-bold mb-1">Produk & Layanan</h2>
                <p class="text-muted mb-0">Kategori Produk</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <button type="button" class="btn btn-wa rounded-pill px-4 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#modalPilihAdmin">
                    <i class="bi bi-whatsapp me-2 fs-5"></i> Konsultasi Via Whatsapp
                </button>
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-md-3 col-6">
                <div class="card card-hover h-100">
                    <img src="<?= base_url('assets/images/fm kaos.jpg') ?>" class="card-img-top" alt="Kaos">
                    <div class="card-body text-center">
                        <h6 class="card-title fw-bold">Kaos Polos Custom</h6>
                        <a href="<?= base_url('produk/hit_and_view/kaos_polos') ?>" class="btn btn-primary btn-sm rounded-pill mt-2 px-4">Lihat lainnya</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="card card-hover h-100">
                    <img src="<?= base_url('assets/images/kemeja.jpg') ?>" class="card-img-top" alt="PDH">
                    <div class="card-body text-center">
                        <h6 class="card-title fw-bold">Kemeja & PDH</h6>
                        <a href="<?= base_url('produk/hit_and_view/kemeja_dan_PDH') ?>" class="btn btn-primary btn-sm rounded-pill mt-2 px-4">Lihat lainnya</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                 <div class="card card-hover h-100">
                    <img src="<?= base_url('assets/images/fm polo k.jpg') ?>" class="card-img-top" alt="Polo">
                    <div class="card-body text-center">
                        <h6 class="card-title fw-bold">Seragam Polo</h6>
                        <a href="<?= base_url('produk/hit_and_view/kaos_polo') ?>" class="btn btn-primary btn-sm rounded-pill mt-2 px-4">Lihat lainnya</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-6">
                 <div class="card card-hover h-100">
                    <img src="<?= base_url('assets/images/fm rompi bg abu.jpg') ?>" class="card-img-top" alt="Rompi">
                    <div class="card-body text-center">
                        <h6 class="card-title fw-bold">Seragam Rompi</h6>
                        <a href="<?= base_url('produk/hit_and_view/rompi') ?>" class="btn btn-primary btn-sm rounded-pill mt-2 px-4">Lihat lainnya</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section id="tentang" class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5">
                <h2 class="fw-bold mb-4"><?= $about['judul_kecil']; ?></h2>
                <div class="text-muted" style="text-align: justify;">
                    <?php 
                    // Memecah teks menjadi paragraf otomatis
                    $paragraf = explode("\n", $about['deskripsi'] ?? ''); 
                    foreach ($paragraf as $p) {
                        if (!empty(trim($p))) {
                            echo '<p class="mb-3">' . trim($p) . '</p>'; 
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-2"></div> 
            <div class="col-md-5 text-end">
                 <img src="<?= base_url('assets/images/' . $about['foto']) ?>" class="img-fluid rounded shadow mb-3" alt="Team">
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Visi & Misi Kami</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="p-5 bg-white shadow-sm rounded h-100">
                    <h4 class="fw-bold text-center mb-3">Visi</h4>
                    <p class="text-center text-muted"><?= $visi_misi['judul_utama']; ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-5 bg-white shadow-sm rounded h-100">
                    <h4 class="fw-bold text-center mb-3">Misi</h4>
                    <ul class="text-muted list-unstyled ps-4">
                        <li class="mb-2">1. Membuat produk dengan bahan bermutu tinggi dengan jahitan berkualitas.</li>
                        <li class="mb-2">2. Memberikan pelayanan terbaik kepada mitra dan konsumen, mulai dari awal hingga purna jual.</li>
                        <li class="mb-2">3. Menjadi perusahaan dengan tingkat inovasi tinggi dan memberikan garansi produk sesuai pesanan.</li>
                    </ul>
                </div>
            </div>
        </div>
      </div>
</section>

<section class="py-5 position-relative" 
         style="background: url('<?= base_url('assets/images/foto line.jpg') ?>') no-repeat center center/cover;">
    
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
    
    <div class="container position-relative z-2 text-white py-5">
        <div class="row">
            <div class="col-lg-8"> <h2 class="fw-bold display-5 mb-4">Siap Kolaborasi & Ciptakan<br>Seragam Berkesan?</h2>
                <button type="button" class="btn btn-wa btn-lg rounded-pill px-4 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#modalPilihAdmin">
                    <i class="bi bi-whatsapp me-2 fs-4"></i> Konsultasi Via Whatsapp
                </button>
            </div>
        </div>
    </div>
</section>

<<section id="kontak" class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark" style="font-family: 'Poppins', sans-serif;">Hubungi & Ikuti Kami</h2>
        </div>

        <div class="d-flex justify-content-center flex-wrap mb-5 pb-3">
            <a href="<?= $konfig->instagram ?>" target="_blank" class="social-btn btn-ig" title="Instagram">
                <i class="bi bi-instagram"></i>
            </a>

            <button type="button" class="social-btn btn-wa border-0" data-bs-toggle="modal" data-bs-target="#modalPilihAdmin" title="WhatsApp">
                <i class="bi bi-whatsapp"></i>
            </button>

            <a href="<?= $konfig->tiktok ?>" target="_blank" class="social-btn btn-tiktok" title="TikTok">
                <i class="bi bi-tiktok"></i>
            </a>

            <a href="mailto:<?= $konfig->email ?>" class="social-btn btn-email" title="Email">
                <i class="bi bi-envelope-fill"></i>
            </a>

            <a href="<?= $konfig->facebook ?>" target="_blank" class="social-btn btn-fb" title="Facebook">
                <i class="bi bi-facebook"></i>
            </a>

            <a href="<?= $konfig->mbizmarket ?>" target="_blank" class="social-btn" title="Mbizmarket" style="background-color: #F68B1F; color: white;">
                <i class="bi bi-bag-check-fill"></i>
            </a>

            <a href="<?= $konfig->youtube ?>" target="_blank" class="social-btn btn-yt" title="YouTube">
                <i class="bi bi-youtube"></i>
            </a>
        </div> 

        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="contact-card">
                    <div class="contact-card-title">
                        <i class="bi bi-chat-left-text-fill fs-4"></i>
                        <span>Kontak Kami</span>
                    </div>
                    <div class="contact-card-text text-start px-3">
                        <p class="mb-1">Instagram: @berkah.konveksiku</p>
                        <p class="mb-1">WA 1: 0<?= substr($konfig->no_wa_1, 2) ?></p>
                        <p class="mb-1">WA 2: 0<?= substr($konfig->no_wa_2, 2) ?></p>
                        <p class="mb-0">Email: <?= $konfig->email ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="contact-card">
                    <div class="contact-card-title">
                        <i class="bi bi-alarm-fill fs-4"></i> <span>Jam Buka</span>
                    </div>
                    <div class="contact-card-text text-center">
                        <p class="mb-0 px-3 fw-bold"><?= nl2br($konfig->jam_operasional) ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="contact-card">
                    <div class="contact-card-title">
                        <i class="bi bi-geo-alt-fill fs-4"></i>
                        <span>Alamat Kami</span>
                    </div>
                    <div class="contact-card-text text-start px-3">
                        <p class="mb-0"><?= $konfig->alamat ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalPilihAdmin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">Pilih Admin WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="text-muted mb-4">Silakan pilih admin untuk konsultasi pesanan:</p>
                
                <div class="d-grid gap-3">
                    <a href="https://wa.me/<?= $konfig->no_wa_1 ?>" target="_blank" id="wa-admin-1" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-whatsapp fs-4"></i> 
                        <div class="text-start lh-1">
                            <div style="font-size: 0.9rem;">Chat Admin 1</div>
                            <div style="font-size: 0.75rem; opacity: 0.8;">0<?= substr($konfig->no_wa_1, 2) ?></div>
                        </div>
                    </a>
                    <a href="https://wa.me/<?= $konfig->no_wa_2 ?>" target="_blank" id="wa-admin-2" class="btn btn-outline-success btn-lg rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-whatsapp fs-4"></i> 
                        <div class="text-start lh-1">
                            <div style="font-size: 0.9rem;">Chat Admin 2</div>
                            <div style="font-size: 0.75rem; opacity: 0.8;">0<?= substr($konfig->no_wa_2, 2) ?></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Tepat di sini kita ambil elemen berdasarkan ID
        const waAdmin1 = document.getElementById('wa-admin-1');
        const waAdmin2 = document.getElementById('wa-admin-2');
        
        // 2. Definisi Fungsi logWaClick
        function logWaClick(adminId) {
            // URL Controller Log kita (Tracking_log)
            const url = '<?= base_url('Tracking_log/log_whatsapp_click'); ?>';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                // Body: Mengirim data admin yang dipilih
                body: JSON.stringify({ admin: adminId }) 
            })
            .then(response => {
                // Tambahkan pengecekan jika response bukan 200/OK
                if (!response.ok) {
                    console.error("HTTP Error:", response.status, response.statusText);
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Log di Console bahwa data berhasil dikirim ke server
                console.log('WA Click Logged:', data.status, 'Admin:', adminId);
            })
            .catch(error => {
                console.error('Error logging WA click:', error);
            });
        }
        
        // 3. Memasang Event Listener pada Tombol Admin 1
        if (waAdmin1) {
            waAdmin1.addEventListener('click', function (e) {
                // Panggil fungsi log saat tombol diklik
                logWaClick('Admin 1');
            });
        }

        // 4. Memasang Event Listener pada Tombol Admin 2
        if (waAdmin2) {
            waAdmin2.addEventListener('click', function (e) {
                // Panggil fungsi log saat tombol diklik
                logWaClick('Admin 2');
            });
        }
        
        // ... (Kode JavaScript Anda yang lain) ...
    });
</script> 