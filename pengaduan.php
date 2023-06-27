<?php
require_once "conn.php";

// GET pengaduan
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Query untuk mengambil data pengaduan dan join dengan transaksi
    $sql = "SELECT transaksi.id, transaksi.id_transaksi, transaksi.nama_pelanggan, pengaduan.jenis_pengaduan, transaksi.tanggal_pesanan
            FROM transaksi
            INNER JOIN pengaduan ON transaksi.id_transaksi = pengaduan.id_transaksi";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $pengaduan = [];
        while ($row = $result->fetch_assoc()) {
            $pengaduan[] = $row;
        }
        echo json_encode($pengaduan);
    } else {
        echo "Tidak ada data pengaduan.";
    }
}

// POST pengaduan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id_transaksi = $conn->real_escape_string($data['id_transaksi']);
    $nama_pelanggan = $conn->real_escape_string($data['nama_pelanggan']);
    $jenis_pengaduan = $conn->real_escape_string($data['jenis_pengaduan']);
    $tanggal_pesanan = $conn->real_escape_string($data['tanggal_pesanan']);

    $sql = "INSERT INTO pengaduan (id_transaksi, nama_pelanggan, jenis_pengaduan, tanggal_pesanan)
            VALUES ('$id_transaksi', '$nama_pelanggan', '$jenis_pengaduan', '$tanggal_pesanan')";

    if ($conn->query($sql) === TRUE) {
        $inserted_id = $conn->insert_id;
        echo "Pengaduan berhasil ditambahkan. ID Pengaduan: " . $inserted_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// PUT pengaduan
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $conn->real_escape_string($data['id']);
    $id_transaksi = $conn->real_escape_string($data['id_transaksi']);
    $nama_pelanggan = $conn->real_escape_string($data['nama_pelanggan']);
    $jenis_pengaduan = $conn->real_escape_string($data['jenis_pengaduan']);
    $tanggal_pesanan = $conn->real_escape_string($data['tanggal_pesanan']);

    $sql = "UPDATE pengaduan SET
            id_transaksi = '$id_transaksi',
            nama_pelanggan = '$nama_pelanggan',
            jenis_pengaduan = '$jenis_pengaduan',
            tanggal_pesanan = '$tanggal_pesanan'
            WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Pengaduan berhasil diperbarui.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// DELETE pengaduan
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];

    $sql = "DELETE FROM pengaduan WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Pengaduan berhasil dihapus.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
