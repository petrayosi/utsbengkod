<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];

    // Periksa apakah username atau email sudah ada
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username atau email sudah terdaftar.";
    } else {
        // Masukkan data ke dalam tabel users
        $stmt = $conn->prepare("INSERT INTO users (username, password, nama_lengkap, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password, $nama_lengkap, $email);

        if ($stmt->execute()) {
            echo "Registrasi berhasil!";
            header("Location: LoginUser.php"); // Arahkan ke halaman login setelah registrasi
            exit();
        } else {
            echo "Registrasi gagal: " . $stmt->error;
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna</title>
</head>
<body>
    <h2>Registrasi Pengguna</h2>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>Nama Lengkap:</label>
        <input type="text" name="nama_lengkap"><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <button type="submit">Registrasi</button>
    </form>
</body>
</html>
