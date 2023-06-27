<!DOCTYPE html>
<html>
<head>
    <title>Data Pengembalian</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Data Pengembalian</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Pengembalian</th>
                <th>ID Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Metode Pembayaran</th>
            </tr>
        </thead>
        <tbody id="pengembalianData"></tbody>
    </table>

    <script>
        // Mengambil data pengembalian dari API
        fetch('http://localhost:8080/TUBESEAIKEL5/pengembalian.php')
            .then(response => response.json())
            .then(data => {
                const pengembalianData = document.getElementById('pengembalianData');

                // Mengisi tabel dengan data pengembalian
                data.data.forEach(pengembalian => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${pengembalian.id}</td>
                        <td>${pengembalian.id_transaksi}</td>
                        <td>${pengembalian.nama_pelanggan}</td>
                        <td>${pengembalian.metode_pembayaran}</td>
                    `;
                    pengembalianData.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    </script>
</body>
</html>
