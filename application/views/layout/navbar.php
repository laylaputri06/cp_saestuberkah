<nav class="navbar navbar-expand-lg navbar-dark bg-blue-custom py-3 sticky-top">
  <div class="container">
    
   <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('auth/login') ?>">
        
        <img src="<?= base_url('assets/images/logo putih.png') ?>" 
             alt="Logo" 
             style="height: 50px; width: auto;">
        
        <div class="d-flex flex-column justify-content-center text-white lh-sm">
            <span style="font-weight: 700; font-size: 18px; letter-spacing: 0.5px;">Konveksi</span>
            <span style="font-weight: 300; font-size: 14px;">Saestu Berkah</span>
        </div>

    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-uppercase fs-7 fw-medium">
        <li class="nav-item px-2"><a class="nav-link" href="#beranda">Beranda</a></li>
        <li class="nav-item px-2"><a class="nav-link" href="#produk">Produk & Layanan</a></li>
        <li class="nav-item px-2"><a class="nav-link" href="#tentang">Tentang Kami</a></li>
        <li class="nav-item px-2"><a class="nav-link" href="#kontak">Kontak</a></li>
      </ul>
    </div>
  </div>
</nav>