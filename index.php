<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Kendaraan</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #add;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4caf50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .tersedia {
            color: green;
            font-weight: bold;
        }
        .tidak-tersedia {
            color: red;
            font-weight: bold;
        }
        h1 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>

    <div style="text-align: right; margin-bottom: 20px;">
    <a href="tambah_data.php" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">➕ Tambah Data Baru</a>
</div>
    <h1>Daftar Kendaraan Rental</h1>

    <?php

    $kendaraan = [
        [
            'id' => 1,
            'merk_kendaraan' => 'Toyota Avanza',
            'plat_nomor' => 'B 1234 ABC',
            'harga_sewa' => 350000,
            'kondisi_mesin' => 'Bagus'
        ],
        [
            'id' => 2,
            'merk_kendaraan' => 'Honda Brio',
            'plat_nomor' => 'B 5678 XYZ',
            'harga_sewa' => 300000,
            'kondisi_mesin' => 'Service'
        ],
        [
            'id' => 3,
            'merk_kendaraan' => 'Suzuki Ertiga',
            'plat_nomor' => 'D 9012 DEF',
            'harga_sewa' => 375000,
            'kondisi_mesin' => 'Bagus'
        ],
        [
            'id' => 4,
            'merk_kendaraan' => 'Daihatsu Xenia',
            'plat_nomor' => 'B 3456 GHI',
            'harga_sewa' => 325000,
            'kondisi_mesin' => 'Service'
        ],
        [
            'id' => 5,
            'merk_kendaraan' => 'Mitsubishi Xpander',
            'plat_nomor' => 'F 7890 JKL',
            'harga_sewa' => 400000,
            'kondisi_mesin' => 'Bagus'
        ]
    ];
    ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Merk Kendaraan</th>
                <th>Plat Nomor</th>
                <th>Harga Sewa</th>
                <th>Kondisi Mesin</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($kendaraan as $data) {
                $harga_format = "Rp " . number_format($data['harga_sewa'], 0, ',', '.');

                if ($data['kondisi_mesin'] == 'Service') {
                    $status = '<span class="tidak-tersedia">Tidak-tersedia - Sedang di Bengkel</span>';

                } else {
                    $status = '<span class="tersedia">Siap Disewa</span>';
                }

                echo "<tr>";
                echo "<td>" . $data['id'] . "</td>";
                echo "<td>" . $data['merk_kendaraan'] . "</td>";
                echo "<td>" . $data['plat_nomor'] . "</td>";
                echo "<td>" . $harga_format . "</td>";
                echo "<td>" . $data['kondisi_mesin'] . "</td>";
                echo "<td>" . $status . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

   <div style="text-align: center; margin-top: 20px;">
    <p><strong>Keterangan:</strong></p>
    <p><span style="color: green;">● Siap Disewa</span> (Kondisi Mesin Bagus)</p>
    <p><span style="color: red;">● Tidak Tersedia - Sedang di Bengkel</span> (Kondisi Mesin Service)</p>
</div>
</body>
</html>