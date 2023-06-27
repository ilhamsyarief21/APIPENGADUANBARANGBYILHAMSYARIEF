<?php
require_once "conn.php";
// Memeriksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Mendapatkan data penukaran menggunakan INNER JOIN dengan tabel transaksi
function getPenukaran()
{
    global $conn;
    $query = "SELECT p.id, p.id_penukaran, p.id_transaksi, t.nama_pelanggan, t.alamat_pelanggan, t.tanggal_pesanan, t.metode_pembayaran
              FROM penukaran p
              INNER JOIN transaksi t ON p.id_transaksi = t.id_transaksi";
    $result = mysqli_query($conn, $query);

    $penukaran = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $penukaran[] = $row;
    }

    return $penukaran;
}

// Menampilkan data penukaran
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Mendapatkan data penukaran menggunakan fungsi getPenukaran()
    $penukaran = getPenukaran();

    if (!empty($penukaran)) {
        // Data penukaran ditemukan
        $response = array(
            'status' => 'success',
            'data' => $penukaran
        );
    } else {
        // Data penukaran tidak ditemukan
        $response = array(
            'status' => 'error',
            'message' => 'Data penukaran tidak ditemukan.'
        );
    }

    // Mengubah response menjadi format JSON
    echo json_encode($response);
}

// Menambahkan data penukaran
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data dari permintaan POST
    $id_penukaran = $_POST['id_penukaran'];
    $id_transaksi = $_POST['id_transaksi'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat_pelanggan = $_POST['alamat_pelanggan'];
    $tanggal_pesanan = $_POST['tanggal_pesanan'];

    // Query INSERT untuk menambahkan data penukaran
    $query = "INSERT INTO penukaran (id_penukaran, id_transaksi, nama_pelanggan, alamat_pelanggan, tanggal_pesanan)
              VALUES ('$id_penukaran', '$id_transaksi', '$nama_pelanggan', '$alamat_pelanggan', '$tanggal_pesanan')";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Data penukaran berhasil ditambahkan
        $response = array(
            'status' => 'success',
            'message' => 'Data penukaran berhasil ditambahkan.'
        );
    } else {
        // Error saat menambahkan data penukaran
        $response = array(
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat menambahkan data penukaran: ' . mysqli_error($conn)
        );
    }

    // Mengubah response menjadi format JSON
    echo json_encode($response);
}

// Mengubah data penukaran
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Mendapatkan data dari permintaan PUT
    parse_str(file_get_contents("php://input"), $putData);
    $id_penukaran = $putData['id_penukaran'];
    $id_transaksi = $putData['id_transaksi'];
    $nama_pelanggan = $putData['nama_pelanggan'];
    $alamat_pelanggan = $putData['alamat_pelanggan'];
    $tanggal_pesanan = $putData['tanggal_pesanan'];

    // Query UPDATE untuk mengubah data penukaran
    $query = "UPDATE penukaran
              SET id_transaksi = '$id_transaksi', nama_pelanggan = '$nama_pelanggan', alamat_pelanggan = '$alamat_pelanggan', tanggal_pesanan = '$tanggal_pesanan'
              WHERE id_penukaran = '$id_penukaran'";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Data penukaran berhasil diubah
        $response = array(
            'status' => 'success',
            'message' => 'Data penukaran berhasil diubah.'
        );
    } else {
        // Error saat mengubah data penukaran
        $response = array(
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat mengubah data penukaran: ' . mysqli_error($conn)
        );
    }

    // Mengubah response menjadi format JSON
    echo json_encode($response);
}

// Menghapus data penukaran
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Mendapatkan data dari permintaan DELETE
    parse_str(file_get_contents("php://input"), $deleteData);
    $id_penukaran = $deleteData['id_penukaran'];

    // Query DELETE untuk menghapus data penukaran
    $query = "DELETE FROM penukaran WHERE id_penukaran = '$id_penukaran'";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Data penukaran berhasil dihapus
        $response = array(
            'status' => 'success',
            'message' => 'Data penukaran berhasil dihapus.'
        );
    } else {
        // Error saat menghapus data penukaran
        $response = array(
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat menghapus data penukaran: ' . mysqli_error($conn)
        );
    }

    // Mengubah response menjadi format JSON
    echo json_encode($response);
}

// Menutup koneksi database
mysqli_close($conn);
?>
