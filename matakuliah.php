<?php
require_once 'functions.php';

if (isset($_POST['tambah_krs'])) {
    tambahKrs($_POST['mahasiswa_npm'], $_POST['matakuliah_kodemk'], $conn);
    header("Location: krs.php");
    exit();
}

if (isset($_POST['edit_krs'])) {
    editKrs($_POST['id'], $_POST['mahasiswa_npm'], $_POST['matakuliah_kodemk'], $conn);
    header("Location: krs.php");
    exit();
}

if (isset($_GET['hapus_krs'])) {
    hapusKrs($_GET['hapus_krs'], $conn);
    header("Location: krs.php");
    exit();
}

$krs_result = getKrs($conn);

$matakuliah_result = getMatakuliah($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen KRS</title>
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
    <h2>Data KRS</h2>

    <form method="POST">
        <h3>Tambah KRS</h3>
        <input type="text" name="mahasiswa_npm" placeholder="NPM Mahasiswa" required>
        <select name="matakuliah_kodemk" required>
            <option value="">Pilih Mata Kuliah</option>
            <?php while ($matakuliah = $matakuliah_result->fetch_assoc()) { ?>
                <option value="<?php echo $matakuliah['kodemk']; ?>">
                    <?php echo $matakuliah['kodemk'] . ' - ' . $matakuliah['nama'] . ' (' . $matakuliah['jumlah_sks'] . ' SKS)'; ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit" name="tambah_krs">Tambah</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>NPM Mahasiswa</th>
            <th>Mata Kuliah</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $krs_result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['mahasiswa_npm']; ?></td>
                <td><?php echo $row['matakuliah_kodemk'] . ' - ' . $row['nama_matakuliah']; ?></td>
                <td>
                    <a href="?edit_krs=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="?hapus_krs=<?php echo $row['id']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <?php
    if (isset($_GET['edit_krs'])) {
        $edit_krs_row = getKrsById($_GET['edit_krs'], $conn);
        $matakuliah_result = getMatakuliah($conn); 
    ?>
        <form method="POST">
            <h3>Edit KRS</h3>
            <input type="hidden" name="id" value="<?php echo $edit_krs_row['id']; ?>">
            <input type="text" name="mahasiswa_npm" value="<?php echo $edit_krs_row['mahasiswa_npm']; ?>" required>
            <select name="matakuliah_kodemk" required>
                <option value="">Pilih Mata Kuliah</option>
                <?php while ($matakuliah = $matakuliah_result->fetch_assoc()) { ?>
                    <option value="<?php echo $matakuliah['kodemk']; ?>" <?php if ($matakuliah['kodemk'] == $edit_krs_row['matakuliah_kodemk']) echo 'selected'; ?>>
                        <?php echo $matakuliah['kodemk'] . ' - ' . $matakuliah['nama'] . ' (' . $matakuliah['jumlah_sks'] . ' SKS)'; ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit" name="edit_krs">Simpan</button>
        </form>
    <?php } ?>

    <p><a href="index.php">Kembali ke Data Mahasiswa</a> | <a href="matakuliah.php">Kelola Mata Kuliah</a></p>
</body>
</html>

<?php $conn->close(); ?>