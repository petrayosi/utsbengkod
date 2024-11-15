<?php
include 'db.php';

// Add Data
if (isset($_POST['add'])) {
    $pasien = $_POST['pasien'];
    $dokter = $_POST['dokter'];
    $tanggal_periksa = $_POST['tanggal_periksa'];
    $catatan = $_POST['catatan'];
    $obat = $_POST['obat'];

    $sql = "INSERT INTO periksa (pasien, dokter, tanggal_periksa, catatan, obat) 
            VALUES ('$pasien', '$dokter', '$tanggal_periksa', '$catatan', '$obat')";
    $conn->query($sql);
    header("Location: periksa.php");
}

// Delete Data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM periksa WHERE id=$id";
    $conn->query($sql);
    header("Location: periksa.php");
}

// Get Data for Edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM periksa WHERE id=$id");
    $editData = $result->fetch_assoc();
}

// Update Data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $pasien = $_POST['pasien'];
    $dokter = $_POST['dokter'];
    $tanggal_periksa = $_POST['tanggal_periksa'];
    $catatan = $_POST['catatan'];
    $obat = $_POST['obat'];

    $sql = "UPDATE periksa SET pasien='$pasien', dokter='$dokter', tanggal_periksa='$tanggal_periksa', 
            catatan='$catatan', obat='$obat' WHERE id=$id";
    $conn->query($sql);
    header("Location: periksa.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Poliklinik - Periksa</title>
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
                <li class="nav-item"><a class="nav-link active" href="#">Periksa</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Log Out</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h3>Periksa</h3>

    <!-- Form Add/Edit Examination -->
    <form method="POST" action="periksa.php">
        <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
        <div class="mb-3">
            <label for="pasien" class="form-label">Pasien</label>
            <input type="text" name="pasien" class="form-control" placeholder="Nama Pasien" value="<?= $editData['pasien'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="dokter" class="form-label">Dokter</label>
            <input type="text" name="dokter" class="form-control" placeholder="Nama Dokter" value="<?= $editData['dokter'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_periksa" class="form-label">Tanggal Periksa</label>
            <input type="datetime-local" name="tanggal_periksa" class="form-control" value="<?= $editData['tanggal_periksa'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <input type="text" name="catatan" class="form-control" placeholder="Catatan" value="<?= $editData['catatan'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="obat" class="form-label">Obat</label>
            <input type="text" name="obat" class="form-control" placeholder="Obat yang diberikan" value="<?= $editData['obat'] ?? '' ?>" required>
        </div>
        <button type="submit" name="<?= isset($editData) ? 'update' : 'add' ?>" class="btn btn-primary"><?= isset($editData) ? 'Update' : 'Simpan' ?></button>
    </form>

    <!-- Table of Examinations -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Tanggal Periksa</th>
                <th>Catatan</th>
                <th>Obat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM periksa");
            $i = 1;
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $row['pasien'] ?></td>
                    <td><?= $row['dokter'] ?></td>
                    <td><?= $row['tanggal_periksa'] ?></td>
                    <td><?= $row['catatan'] ?></td>
                    <td><?= $row['obat'] ?></td>
                    <td>
                        <a href="periksa.php?edit=<?= $row['id'] ?>" class="btn btn-success btn-sm">Ubah</a>
                        <a href="periksa.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
