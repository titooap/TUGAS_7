<?php
require_once 'functions.php';

// Proses tambah matakuliah
if (isset($_POST['tambah_matakuliah'])) {
    tambahMatakuliah($_POST['kodemk'], $_POST['nama'], $_POST['jumlah_sks'], $conn);
    header("Location: matakuliah.php");
    exit();
}

// Proses edit matakuliah
if (isset($_POST['edit_matakuliah'])) {
    editMatakuliah($_POST['kodemk'], $_POST['nama'], $_POST['jumlah_sks'], $conn);
    header("Location: matakuliah.php");
    exit();
}

// Proses hapus matakuliah
if (isset($_GET['hapus_matakuliah'])) {
    hapusMatakuliah($_GET['hapus_matakuliah'], $conn);
    header("Location: matakuliah.php");
    exit();
}

// Ambil data matakuliah
$matakuliah_result = getMatakuliah($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Mata Kuliah</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { color: #333; }
        form { margin-bottom: 20px; }
        input, select { margin: 5px; padding: 5px; width: 200px; }
        button { padding: 5px 10px; }
        a { color: red; text-decoration: none; }
    </style>
</head>
<body>
    <h2>Kelola Mata Kuliah</h2>

    <!-- Form Tambah Mata Kuliah -->
    <form method="POST">
        <h3>Tambah Mata Kuliah</h3>
        <input type="text" name="kodemk" placeholder="Kode Mata Kuliah (contoh: BD001)" required>
        <input type="text" name="nama" placeholder="Nama Mata Kuliah" required>
        <input type="number" name="jumlah_sks" placeholder="Jumlah SKS (1-4)" min="1" max="4" required>
        <button type="submit" name="tambah_matakuliah">Tambah</button>
    </form>

    <!-- Tabel Mata Kuliah -->
    <table>
        <tr>
            <th>Kode Mata Kuliah</th>
            <th>Nama Mata Kuliah</th>
            <th>Jumlah SKS</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $matakuliah_result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['kodemk']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['jumlah_sks']; ?> SKS</td>
                <td>
                    <a href="?edit_matakuliah=<?php echo $row['kodemk']; ?>">Edit</a> |
                    <a href="?hapus_matakuliah=<?php echo $row['kodemk']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- Form Edit Mata Kuliah -->
    <?php
    if (isset($_GET['edit_matakuliah'])) {
        $edit_matakuliah_row = getMatakuliahByKodemk($_GET['edit_matakuliah'], $conn);
    ?>
        <form method="POST">
            <h3>Edit Mata Kuliah</h3>
            <input type="hidden" name="kodemk" value="<?php echo $edit_matakuliah_row['kodemk']; ?>">
            <input type="text" name="nama" value="<?php echo $edit_matakuliah_row['nama']; ?>" placeholder="Nama Mata Kuliah" required>
            <input type="number" name="jumlah_sks" value="<?php echo $edit_matakuliah_row['jumlah_sks']; ?>" placeholder="Jumlah SKS (1-4)" min="1" max="4" required>
            <button type="submit" name="edit_matakuliah">Simpan</button>
        </form>
    <?php } ?>

    <p><a href="index.php">Kembali ke Data Mahasiswa</a> | <a href="krs.php">Kembali ke Data KRS</a></p>
</body>
</html>

<?php $conn->close(); ?>