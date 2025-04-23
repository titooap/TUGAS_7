<?php
require_once 'koneksi.php';

function cleanInput($data, $conn) {
    return mysqli_real_escape_string($conn, htmlspecialchars($data));
}

function tambahMahasiswa($npm, $nama, $jurusan, $keterangan, $conn) {
    $npm = cleanInput($npm, $conn);
    $nama = cleanInput($nama, $conn);
    $jurusan = cleanInput($jurusan, $conn);
    $keterangan = cleanInput($keterangan, $conn);

    $sql = "INSERT INTO mahasiswa (npm, nama, jurusan, keterangan) VALUES ('$npm', '$nama', '$jurusan', '$keterangan')";
    return $conn->query($sql);
}

function tambahKrs($mahasiswa_npm, $matakuliah_kodemk, $conn) {
    $mahasiswa_npm = cleanInput($mahasiswa_npm, $conn);
    $matakuliah_kodemk = cleanInput($matakuliah_kodemk, $conn);

    $sql = "INSERT INTO krs (mahasiswa_npm, matakuliah_kodemk) VALUES ('$mahasiswa_npm', '$matakuliah_kodemk')";
    return $conn->query($sql);
}

function tambahMatakuliah($kodemk, $nama, $jumlah_sks, $conn) {
    $kodemk = cleanInput($kodemk, $conn);
    $nama = cleanInput($nama, $conn);
    $jumlah_sks = cleanInput($jumlah_sks, $conn);

    $sql = "INSERT INTO matakuliah (kodemk, nama, jumlah_sks) VALUES ('$kodemk', '$nama', '$jumlah_sks')";
    return $conn->query($sql);
}

function hapusMahasiswa($npm, $conn) {
    $npm = cleanInput($npm, $conn);
    $sql = "DELETE FROM mahasiswa WHERE npm='$npm'";
    return $conn->query($sql);
}

function hapusKrs($id, $conn) {
    $id = cleanInput($id, $conn);
    $sql = "DELETE FROM krs WHERE id='$id'";
    return $conn->query($sql);
}

function hapusMatakuliah($kodemk, $conn) {
    $kodemk = cleanInput($kodemk, $conn);
    $sql = "DELETE FROM matakuliah WHERE kodemk='$kodemk'";
    return $conn->query($sql);
}

function editMahasiswa($npm, $nama, $jurusan, $keterangan, $conn) {
    $npm = cleanInput($npm, $conn);
    $nama = cleanInput($nama, $conn);
    $jurusan = cleanInput($jurusan, $conn);
    $keterangan = cleanInput($keterangan, $conn);

    $sql = "UPDATE mahasiswa SET nama='$nama', jurusan='$jurusan', keterangan='$keterangan' WHERE npm='$npm'";
    return $conn->query($sql);
}

function editKrs($id, $mahasiswa_npm, $matakuliah_kodemk, $conn) {
    $id = cleanInput($id, $conn);
    $mahasiswa_npm = cleanInput($mahasiswa_npm, $conn);
    $matakuliah_kodemk = cleanInput($matakuliah_kodemk, $conn);

    $sql = "UPDATE krs SET mahasiswa_npm='$mahasiswa_npm', matakuliah_kodemk='$matakuliah_kodemk' WHERE id='$id'";
    return $conn->query($sql);
}

function editMatakuliah($kodemk, $nama, $jumlah_sks, $conn) {
    $kodemk = cleanInput($kodemk, $conn);
    $nama = cleanInput($nama, $conn);
    $jumlah_sks = cleanInput($jumlah_sks, $conn);

    $sql = "UPDATE matakuliah SET nama='$nama', jumlah_sks='$jumlah_sks' WHERE kodemk='$kodemk'";
    return $conn->query($sql);
}

function getMahasiswa($conn) {
    return $conn->query("SELECT * FROM mahasiswa");
}

function getKrs($conn) {
    return $conn->query("SELECT krs.*, matakuliah.nama AS nama_matakuliah FROM krs JOIN matakuliah ON krs.matakuliah_kodemk = matakuliah.kodemk");
}

function getMatakuliah($conn) {
    return $conn->query("SELECT * FROM matakuliah");
}

function getMahasiswaByNpm($npm, $conn) {
    $npm = cleanInput($npm, $conn);
    $result = $conn->query("SELECT * FROM mahasiswa WHERE npm='$npm'");
    return $result->fetch_assoc();
}

function getKrsById($id, $conn) {
    $id = cleanInput($id, $conn);
    $result = $conn->query("SELECT * FROM krs WHERE id='$id'");
    return $result->fetch_assoc();
}

function getMatakuliahByKodemk($kodemk, $conn) {
    $kodemk = cleanInput($kodemk, $conn);
    $result = $conn->query("SELECT * FROM matakuliah WHERE kodemk='$kodemk'");
    return $result->fetch_assoc();
}
?>