<?php
include 'db.php';

// Tambah Data
if (isset($_POST['add'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    $sql = "INSERT INTO pasien (nama, alamat, no_hp) VALUES ('$nama', '$alamat', '$no_hp')";
    if ($conn->query($sql) === TRUE) {
        header("Location: pasien.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Hapus Data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM pasien WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: pasien.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil Data untuk Edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM pasien WHERE id=$id");
    $editData = $result->fetch_assoc();
}

// Update Data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    $sql = "UPDATE pasien SET nama='$nama', alamat='$alamat', no_hp='$no_hp' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: pasien.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistem Informasi Poliklinik</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Data Master</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Periksa</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Log Out</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h3>Pasien</h3>

    <!-- Formulir Tambah / Edit Pasien -->
    <form method="POST" action="pasien.php">
        <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" placeholder="Nama" value="<?= $editData['nama'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="<?= $editData['alamat'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input type="text" name="no_hp" class="form-control" placeholder="No HP" value="<?= $editData['no_hp'] ?? '' ?>" required>
        </div>
        <button type="submit" name="<?= isset($editData) ? 'update' : 'add' ?>" class="btn btn-primary"><?= isset($editData) ? 'Update' : 'Simpan' ?></button>
    </form>

    <!-- Tabel Data Pasien -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM pasien");
            $i = 1;
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                    <td><?= htmlspecialchars($row['no_hp']) ?></td>
                    <td>
                        <a href="pasien.php?edit=<?= $row['id'] ?>" class="btn btn-success btn-sm">Ubah</a>
                        <a href="pasien.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
