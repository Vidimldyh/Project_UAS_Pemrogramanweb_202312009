<?php
include '../../config/koneksi.php';
if (isset($_POST['simpan'])) {
    $id_user = $_POST['id_user'];
    $pesan = $_POST['pesan'];
    mysqli_query($conn, "INSERT INTO testimoni (id_user, pesan) VALUES ('$id_user', '$pesan')");
    header("Location: index.php");
}
$users = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Testimoni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Tambah Testimoni</h3>
    <form method="post">
        <div class="mb-3">
            <label>Nama User</label>
            <select name="id_user" class="form-control" required>
                <option value="">Pilih</option>
                <?php while ($u = mysqli_fetch_assoc($users)) { ?>
                <option value="<?= $u['id_user']; ?>"><?= $u['nama']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Pesan</label>
            <textarea name="pesan" class="form-control" required></textarea>
        </div>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
