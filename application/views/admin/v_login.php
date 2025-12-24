<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* 1. BACKGROUND LUAR: BIRU TUA PEKAT */
        body {
            background-color: #1a0380;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        /* 2. KARTU LOGIN */
        .login-card {
            background-color: #ffffff;
            border-radius: 30px;
            overflow: hidden;
            width: 900px;
            max-width: 90%;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            min-height: 500px;
        }

        /* 3. BAGIAN KIRI: GAMBAR + LOGO OVERLAY */
        .left-side {
            /* Pastikan nama file gambar background benar */
            background-image: url('<?= base_url("assets/images/ft login admin.jpg") ?>'); 
            background-size: cover;
            background-position: center;
            position: relative; /* PENTING: Agar logo bisa di-absolute di sini */
            min-height: 500px;
        }

        /* POSISI LOGO: MOJOK KIRI ATAS DI ATAS GAMBAR */
        .brand-overlay {
            position: absolute;
            top: 40px;  /* Jarak dari Atas */
            left: 40px; /* Jarak dari Kiri */
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 10; /* Pastikan muncul di atas gambar */
        }
        
        /* Teks Logo */
        .brand-text {
            line-height: 1.2;
            color: #1a0380; /* Warna Biru Tua (Sesuai Logo Biru) */
        }

        /* 4. BAGIAN KANAN: FORM SAJA */
        .right-side {
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #ffffff; /* Putih Bersih */
        }

        .login-title {
            font-weight: 700;
            font-size: 2rem;
            color: #000;
            margin-bottom: 40px;
            text-align: center;
        }

        .form-label {
            font-weight: 700;
            margin-bottom: 10px;
            color: #000;
            font-size: 0.95rem;
        }

        /* INPUT FIELD */
        .form-control {
            background-color: #E6E8F5; /* Warna Abu-Ungu Muda */
            border: none;
            border-radius: 20px;
            padding: 15px 25px;
            color: #000;
            font-weight: 500;
            font-size: 1rem;
        }
        
        .form-control:focus {
            background-color: #E6E8F5;
            box-shadow: none;
            outline: 2px solid #3b5bdb;
        }

        /* TOMBOL LOGIN */
        .btn-login {
            background-color: #3b5bdb; /* Biru terang */
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 0;
            width: 150px;
            font-weight: 700;
            font-size: 1.1rem;
            margin-top: 30px;
            float: right;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #1a0380;
        }

        @media (max-width: 768px) {
            .left-side { display: none; }
            .login-card { width: 100%; border-radius: 0; min-height: 100vh; }
            .right-side { padding: 30px; }
        }
    </style>
</head>
<body>

    <div class="login-card row g-0">
        
        <div class="col-md-6 left-side"></div>

        <div class="col-md-6 right-side">
            
            <h2 class="login-title">Please Login</h2>

            <?= $this->session->flashdata('pesan'); ?>

            <form action="<?= base_url('auth/login') ?>" method="post">
                
                <div class="mb-4">
                    <label for="username" class="form-label">Email</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-login">Login</button>
                </div>

            </form>
        </div>

    </div>

</body>
</html>