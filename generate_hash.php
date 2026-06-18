<?php

// Password Asli yang ingin di-hash
$password_plain = 'Adminkonveksi1025'; 

// 2. Generate Hash (Menggunakan algoritma Bcrypt yang direkomendasikan PHP)
// PASSWORD_BCRYPT adalah algoritma yang kuat dan otomatis menggunakan salt.
$hashed_password = password_hash($password_plain, PASSWORD_BCRYPT);

echo "Password Asli Anda: " . $password_plain . "\n";
echo "Hash yang siap dimasukkan ke database: " . $hashed_password . "\n";
echo "Panjang Hash ini: " . strlen($hashed_password) . " karakter.\n";
?>