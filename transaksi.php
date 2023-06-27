<?php

require_once "conn.php";

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menangani permintaan GET untuk mendapatkan semua transaksi
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM transaksi";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $transactions = array();
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
        echo json_encode($transactions);
    } else {
        echo "Tidak ada data transaksi.";
    }
}

// Menangani permintaan POST untuk membuat transaksi baru
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $data = json_decode(file_get_contents("php://input"), true);
//     $id_transaksi = $data['id_transaksi'];
//     $nama_pelanggan = $data['nama_pelanggan'];
//     $alamat_pelanggan = $data['alamat_pelanggan'];
//     $tanggal_pesanan = $data['tanggal_pesanan'];
//     $metode_pembayaran = $data['metode_pembayaran'];
//     $kode_pembayaran = $data['kode_pembayaran'];
//     $tanggal_pembayaran = $data['tanggal_pembayaran'];

//     $sql = "INSERT INTO transaksi (id_transaksi, nama_pelanggan, alamat_pelanggan, tanggal_pesanan, metode_pembayaran, kode_pembayaran, tanggal_pembayaran)
//             VALUES ($id_transaksi', '$nama_pelanggan', '$alamat_pelanggan', '$tanggal_pesanan', '$metode_pembayaran', '$kode_pembayaran', '$tanggal_pembayaran')";

//     if ($conn->query($sql) === TRUE) {
//         echo "Transaksi berhasil ditambahkan.";
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }
// }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id_transaksi = $conn->real_escape_string($data['id_transaksi']);
    $nama_pelanggan = $conn->real_escape_string($data['nama_pelanggan']);
    $alamat_pelanggan = $conn->real_escape_string($data['alamat_pelanggan']);
    $tanggal_pesanan = $conn->real_escape_string($data['tanggal_pesanan']);
    $metode_pembayaran = $conn->real_escape_string($data['metode_pembayaran']);
    $kode_pembayaran = $conn->real_escape_string($data['kode_pembayaran']);
    $tanggal_pembayaran = $conn->real_escape_string($data['tanggal_pembayaran']);

    $sql = "INSERT INTO transaksi (id_transaksi, nama_pelanggan, alamat_pelanggan, tanggal_pesanan, metode_pembayaran, kode_pembayaran, tanggal_pembayaran)
            VALUES ('$id_transaksi', '$nama_pelanggan', '$alamat_pelanggan', '$tanggal_pesanan', '$metode_pembayaran', '$kode_pembayaran', '$tanggal_pembayaran')";

    if ($conn->query($sql) === TRUE) {
        echo "Transaksi berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menangani permintaan PUT untuk mengubah transaksi
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $id_transaksi = $data['id_transaksi'];
    $nama_pelanggan = $data['nama_pelanggan'];
    $alamat_pelanggan = $data['alamat_pelanggan'];
    $tanggal_pesanan = $data['tanggal_pesanan'];
    $metode_pembayaran = $data['metode_pembayaran'];
    $kode_pembayaran = $data['kode_pembayaran'];
    $tanggal_pembayaran = $data['tanggal_pembayaran'];

    $sql = "UPDATE transaksi SET id_transaksi='$id_transaksi', nama_pelanggan='$nama_pelanggan', alamat_pelanggan='$alamat_pelanggan', tanggal_pesanan='$tanggal_pesanan',
            metode_pembayaran='$metode_pembayaran', kode_pembayaran='$kode_pembayaran', tanggal_pembayaran='$tanggal_pembayaran' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Transaksi berhasil diperbarui.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menangani permintaan DELETE untuk menghapus transaksi
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];

    $sql = "DELETE FROM transaksi WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Transaksi berhasil dihapus.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>
