<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'eaiitubes';

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Mendapatkan data dpengaduan dengan INNER JOIN ke tabel transaksi
function getDataDpengaduan()
{
    global $koneksi;

    $query = "SELECT dpengaduan.id, dpengaduan.id_dokumen, dpengaduan.id_transaksi, dpengaduan.id_penukaran, transaksi.nama_pelanggan, transaksi.metode_pembayaran 
              FROM dpengaduan 
              INNER JOIN transaksi ON dpengaduan.id_transaksi = transaksi.id_transaksi";

    $result = mysqli_query($koneksi, $query);

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

// Menambahkan data dpengaduan
function addDataDpengaduan($id_dokumen, $id_transaksi, $id_penukaran)
{
    global $koneksi;

    $query = "INSERT INTO dpengaduan (id_dokumen, id_transaksi, id_penukaran) 
              VALUES ('$id_dokumen', '$id_transaksi', '$id_penukaran')";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Memperbarui data dpengaduan
function updateDataDpengaduan($id, $id_dokumen, $id_transaksi, $id_penukaran)
{
    global $koneksi;

    $query = "UPDATE dpengaduan 
              SET id_dokumen = '$id_dokumen', id_transaksi = '$id_transaksi', id_penukaran = '$id_penukaran' 
              WHERE id = '$id'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Menghapus data dpengaduan
function deleteDataDpengaduan($id)
{
    global $koneksi;

    $query = "DELETE FROM dpengaduan WHERE id = '$id'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Mendapatkan data dpengaduan (Metode GET)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $dataDpengaduan = getDataDpengaduan();
    header('Content-Type: application/json');
    echo json_encode($dataDpengaduan);
}

// Menambahkan data dpengaduan (Metode POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_dokumen = $_POST['id_dokumen'];
    $id_transaksi = $_POST['id_transaksi'];
    $id_penukaran = $_POST['id_penukaran'];

    if (addDataDpengaduan($id_dokumen, $id_transaksi, $id_penukaran)) {
        $response = array('message' => 'Data dpengaduan berhasil ditambahkan');
    } else {
        $response = array('message' => 'Data dpengaduan gagal ditambahkan');
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

// Memperbarui data dpengaduan (Metode PUT)
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents('php://input'), $put_vars);
    $id = $put_vars['id'];
    $id_dokumen = $put_vars['id_dokumen'];
    $id_transaksi = $put_vars['id_transaksi'];
    $id_penukaran = $put_vars['id_penukaran'];

    if (updateDataDpengaduan($id, $id_dokumen, $id_transaksi, $id_penukaran)) {
        $response = array('message' => 'Data dpengaduan berhasil diperbarui');
    } else {
        $response = array('message' => 'Data dpengaduan gagal diperbarui');
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

// Menghapus data dpengaduan (Metode DELETE)
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents('php://input'), $delete_vars);
    $id = $delete_vars['id'];

    if (deleteDataDpengaduan($id)) {
        $response = array('message' => 'Data dpengaduan berhasil dihapus');
    } else {
        $response = array('message' => 'Data dpengaduan gagal dihapus');
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
