<?php
// Mendapatkan data dpengaduan dengan INNER JOIN
function getDpengaduan()
{
    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "eaiitubes");

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mendapatkan data dpengaduan dengan INNER JOIN
    $query = "SELECT dp.*, t.nama_pelanggan, t.metode_pembayaran FROM dpengaduan dp INNER JOIN transaksi t ON dp.id_transaksi = t.id_transaksi";

    // Eksekusi query
    $result = $conn->query($query);

    // Periksa hasil query
    if ($result->num_rows > 0) {
        $dpengaduan = array();
        while ($row = $result->fetch_assoc()) {
            $dpengaduan[] = $row;
        }
        return $dpengaduan;
    } else {
        return array();
    }

    // Tutup koneksi
    $conn->close();
}

// Menambahkan data dpengaduan
function addDpengaduan($id_dokumen, $id_transaksi, $id_penukaran, $nama_pelanggan, $metode_pembayaran)
{
    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "eaiitubes");

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk menambahkan data dpengaduan
    $query = "INSERT INTO dpengaduan (id_dokumen, id_transaksi, id_penukaran, nama_pelanggan, metode_pembayaran) VALUES ('$id_dokumen', '$id_transaksi', '$id_penukaran', '$nama_pelanggan', '$metode_pembayaran')";

    // Eksekusi query
    if ($conn->query($query) === TRUE) {
        $response = array(
            "status" => "success",
            "message" => "Data dpengaduan berhasil ditambahkan.",
            "data" => null
        );
    } else {
        $response = array(
            "status" => "error",
            "message" => "Terjadi kesalahan saat menambahkan data dpengaduan: " . $conn->error,
            "data" => null
        );
    }

    // Tutup koneksi
    $conn->close();

    return $response;
}

// Mengubah data dpengaduan
function updateDpengaduan($id, $id_dokumen, $id_transaksi, $id_penukaran, $nama_pelanggan, $metode_pembayaran)
{
    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "eaiitubes");

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mengubah data dpengaduan
    $query = "UPDATE dpengaduan SET id_dokumen = '$id_dokumen', id_transaksi = '$id_transaksi', id_penukaran = '$id_penukaran', nama_pelanggan = '$nama_pelanggan', metode_pembayaran = '$metode_pembayaran' WHERE id = '$id'";

    // Eksekusi query
    if ($conn->query($query) === TRUE) {
        $response = array(
            "status" => "success",
            "message" => "Data dpengaduan berhasil diperbarui.",
            "data" => null
        );
    } else {
        $response = array(
            "status" => "error",
            "message" => "Terjadi kesalahan saat memperbarui data dpengaduan: " . $conn->error,
            "data" => null
        );
    }

    // Tutup koneksi
    $conn->close();

    return $response;
}

// Menghapus data dpengaduan
function deleteDpengaduan($id)
{
    // Koneksi ke database
    $conn = new mysqli("localhost", "root", "", "eaiitubes");

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk menghapus data dpengaduan
    $query = "DELETE FROM dpengaduan WHERE id = '$id'";

    // Eksekusi query
    if ($conn->query($query) === TRUE) {
        $response = array(
            "status" => "success",
            "message" => "Data dpengaduan berhasil dihapus.",
            "data" => null
        );
    } else {
        $response = array(
            "status" => "error",
            "message" => "Terjadi kesalahan saat menghapus data dpengaduan: " . $conn->error,
            "data" => null
        );
    }

    // Tutup koneksi
    $conn->close();

    return $response;
}

// Menangani permintaan GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $dpengaduan = getDpengaduan();

    if (!empty($dpengaduan)) {
        // Mengirimkan response dengan format JSON
        header('Content-Type: application/json');
        echo json_encode(array(
            "status" => "success",
            "message" => "Data dpengaduan ditemukan.",
            "data" => $dpengaduan
        ));
    } else {
        // Mengirimkan response dengan format JSON
        header('Content-Type: application/json');
        echo json_encode(array(
            "status" => "error",
            "message" => "Data dpengaduan tidak ditemukan.",
            "data" => null
        ));
    }
}

// Menangani permintaan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_dokumen = $_POST['id_dokumen'];
    $id_transaksi = $_POST['id_transaksi'];
    $id_penukaran = $_POST['id_penukaran'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    $response = addDpengaduan($id_dokumen, $id_transaksi, $id_penukaran, $nama_pelanggan, $metode_pembayaran);

    // Mengirimkan response dengan format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Menangani permintaan PUT
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Menerima data JSON dari body request
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'];
    $id_dokumen = $data['id_dokumen'];
    $id_transaksi = $data['id_transaksi'];
    $id_penukaran = $data['id_penukaran'];
    $nama_pelanggan = $data['nama_pelanggan'];
    $metode_pembayaran = $data['metode_pembayaran'];

    $response = updateDpengaduan($id, $id_dokumen, $id_transaksi, $id_penukaran, $nama_pelanggan, $metode_pembayaran);

    // Mengirimkan response dengan format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Menangani permintaan DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Menerima data JSON dari body request
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id_transaksi'];

    $response = deleteDpengaduan($id);

    // Mengirimkan response dengan format JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
