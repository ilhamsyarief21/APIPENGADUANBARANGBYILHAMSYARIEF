<?php
require_once "conn.php";

// Mendapatkan data pengembalian dengan INNER JOIN tabel transaksi
function getPengembalian() {
    global $conn;
    $query = "SELECT pengembalian.id, pengembalian.id_pengembalian_dana, pengembalian.id_transaksi, transaksi.nama_pelanggan, transaksi.metode_pembayaran
              FROM pengembalian
              INNER JOIN transaksi ON pengembalian.id_transaksi = transaksi.id_transaksi";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $pengembalian = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $pengembalian[] = $row;
        }
        return $pengembalian;
    } else {
        return array();
    }
}

// Menambahkan data pengembalian
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data yang dikirimkan melalui POST request
    $id_pengembalian_dana = $_POST['id_pengembalian_dana'];
    $id_transaksi = $_POST['id_transaksi'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    // Query untuk menambahkan data pengembalian
    $query = "INSERT INTO pengembalian (id_pengembalian_dana, id_transaksi, nama_pelanggan, metode_pembayaran)
              VALUES ('$id_pengembalian_dana', '$id_transaksi', '$nama_pelanggan', '$metode_pembayaran')";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Data pengembalian berhasil ditambahkan
        $response = array(
            'status' => 'success',
            'message' => 'Data pengembalian berhasil ditambahkan.'
        );
    } else {
        // Error saat menambahkan data pengembalian
        $response = array(
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat menambahkan data pengembalian: ' . mysqli_error($conn)
        );
    }

    // Mengubah response menjadi format JSON
    echo json_encode($response);
}

// Mengubah data pengembalian
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Mendapatkan ID pengembalian dari URL
    $id_pengembalian = $_GET['id'];

    // Mendapatkan data yang dikirimkan melalui PUT request
    parse_str(file_get_contents('php://input'), $data);
    $id_pengembalian_dana = $data['id_pengembalian_dana'];
    $id_transaksi = $data['id_transaksi'];
    $nama_pelanggan = $data['nama_pelanggan'];
    $metode_pembayaran = $data['metode_pembayaran'];

    // Query untuk mengupdate data pengembalian
    $query = "UPDATE pengembalian SET id_pengembalian_dana = '$id_pengembalian_dana', id_transaksi = '$id_transaksi',
              nama_pelanggan = '$nama_pelanggan', metode_pembayaran = '$metode_pembayaran' WHERE id = '$id_pengembalian'";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Data pengembalian berhasil diubah
        $response = array(
            'status' => 'success',
            'message' => 'Data pengembalian berhasil diubah.'
        );
    } else {
        // Error saat mengubah data pengembalian
        $response = array(
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat mengubah data pengembalian: ' . mysqli_error($conn)
        );
    }

    // Mengubah response menjadi format JSON
    echo json_encode($response);
}

// Menghapus data pengembalian
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Mendapatkan ID pengembalian dari URL
    $id_pengembalian = $_GET['id'];

    // Query untuk menghapus data pengembalian
    $query = "DELETE FROM pengembalian WHERE id = '$id_pengembalian'";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Data pengembalian berhasil dihapus
        $response = array(
            'status' => 'success',
            'message' => 'Data pengembalian berhasil dihapus.'
        );
    } else {
        // Error saat menghapus data pengembalian
        $response = array(
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat menghapus data pengembalian: ' . mysqli_error($conn)
        );
    }

    // Mengubah response menjadi format JSON
    echo json_encode($response);
}

// Menampilkan data pengembalian
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Panggil fungsi untuk mendapatkan data pengembalian
    $pengembalian = getPengembalian();

    // Mengubah response menjadi format JSON
    echo json_encode($pengembalian);
}

// Menutup koneksi ke database
mysqli_close($conn);
?>
