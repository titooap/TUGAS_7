<?php
require_once 'functions.php';

if (isset($_POST['tambah_mahasiswa'])) {
    tambahMahasiswa($_POST['npm'], $_POST['nama'], $_POST['jurusan'], $_POST['keterangan'], $conn);
    header("Location: index.php");
    exit();
}

if (isset($_POST['edit_mahasiswa'])) {
    editMahasiswa($_POST['npm'], $_POST['nama'], $_POST['jurusan'], $_POST['keterangan'], $conn);
    header("Location: index.php");
    exit();
}

if (isset($_GET['hapus_mahasiswa'])) {
    hapusMahasiswa($_GET['hapus_mahasiswa'], $conn);
    header("Location: index.php");
    exit();
}

$mahasiswa_result = getMahasiswa($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { color: #333; }
        form { margin-bottom: 20px; }
        input, select { margin: 5px; padding: 5px; }
        button { padding: 5px 10px; }
        a { color: red; text-decoration: none; }
    </style>
</head>
<body>
    <h2>Data Mahasiswa</h2>
    
    <!-- Form Tambah Mahasiswa -->
    <form method="POST">
        <h3>Tambah Mahasiswa</h3>
        <input type="text" name="npm" placeholder="NPM" required>
        <input type="text" name="nama" placeholder="Nama" required>
        <input type="text" name="jurusan" placeholder="Jurusan" required>
        <input type="text" name="keterangan" placeholder="Keterangan" required>
        <button type="submit" name="tambah_mahasiswa">Tambah</button>
    </form>

    <!-- Tabel Mahasiswa -->
    <table>
        <tr>
            <th>NPM</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $mahasiswa_result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['npm']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['jurusan']; ?></td>
                <td><?php echo $row['keterangan']; ?></td>
                <td>
                    <a href="?edit_mahasiswa=<?php echo $row['npm']; ?>">Edit</a> |
                    <a href="?hapus_mahasiswa=<?php echo $row['npm']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- Form Edit Mahasiswa -->
    <?php
    if (isset($_GET['edit_mahasiswa'])) {
        $edit_row = getMahasiswaByNpm($_GET['edit_mahasiswa'], $conn);
    ?>
        <form method="POST">
            <h3>Edit Mahasiswa</h3>
            <input type="hidden" name="npm" value="<?php echo $edit_row['npm']; ?>">
            <input type="text" name="nama" value="<?php echo $edit_row['nama']; ?>" required>
            <input type="text" name="jurusan" value="<?php echo $edit_row['jurusan']; ?>" required>
            <input type="text" name="keterangan" value="<?php echo $edit_row['keterangan']; ?>" required>
            <button type="submit" name="edit_mahasiswa">Simpan</button>
        </form>
    <?php } ?>

    <p><a href="krs.php">Lihat Data KRS</a> | <a href="matakuliah.php">Kelola Mata Kuliah</a></p>
</body>
</html>

<?php $conn->close(); ?>