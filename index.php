<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Kendaraan - Pencarian</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .btn-tambah {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn-tambah:hover {
            background-color: #45a049;
        }
        
        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .search-form input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .search-form input[type="text"]:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76,175,80,0.3);
        }
        .search-form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .search-form button:hover {
            background-color: #45a049;
        }
        .btn-reset {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .btn-reset:hover {
            background-color: #5a6268;
        }
        
        .search-info {
            background-color: #e7f3ff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #2196F3;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9e9e9;
        }
        .tersedia {
            color: green;
            font-weight: bold;
        }
        .tidak-tersedia {
            color: red;
            font-weight: bold;
        }
        
        .not-found {
            text-align: center;
            padding: 40px;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 5px;
            color: #856404;
            margin: 20px 0;
        }
        .not-found i {
            font-size: 48px;
            display: block;
            margin-bottom: 10px;
        }
        
        .footer-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚗 RENTAL KENDARAAN</h1>
        
        <div class="header-actions">
            <div></div> 
            <a href="tambah_data.php" class="btn-tambah">➕ Tambah Data Baru</a>
        </div>
        
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
        
    
        $keyword = ''; 
        $hasil_pencarian = []; 
        $is_searching = false; 
        
        if (isset($_GET['keyword']) && !empty(trim($_GET['keyword']))) {
            $is_searching = true;
            $keyword = trim($_GET['keyword']); 
            
            foreach ($kendaraan as $item) {
               
                $keyword_lower = strtolower($keyword);
                $merk_lower = strtolower($item['merk_kendaraan']);
                $plat_lower = strtolower($item['plat_nomor']);
                
                
                if (str_contains($merk_lower, $keyword_lower) || str_contains($plat_lower, $keyword_lower)) {
                    $hasil_pencarian[] = $item; 
                }
            }
        }
        
        if ($is_searching) {
            $data_tampil = $hasil_pencarian;
            $jumlah_data = count($data_tampil);
        } else {
            $data_tampil = $kendaraan;
            $jumlah_data = count($data_tampil);
        }
        ?>
        
        <form method="GET" action="index.php" class="search-form">
            <input type="text" 
                   name="keyword" 
                   placeholder="🔍 Cari berdasarkan merk atau plat nomor..." 
                   value="<?php echo htmlspecialchars($keyword); ?>"
                   autofocus>
            <button type="submit">Cari</button>
        </form>
        
        <?php if ($is_searching): ?>
        <div style="text-align: right; margin-bottom: 10px;">
            <a href="index.php" class="btn-reset">↺ Reset Pencarian</a>
        </div>
        <?php endif; ?>
        
        <?php if ($is_searching): ?>
        <div class="search-info">
            <strong>🔍 Hasil pencarian untuk:</strong> "<?php echo htmlspecialchars($keyword); ?>"<br>
            <strong>📊 Ditemukan:</strong> <?php echo $jumlah_data; ?> kendaraan
        </div>
        <?php endif; ?>
        
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
            
                if ($jumlah_data > 0):
                   
                    foreach ($data_tampil as $data):
                        
                        $harga_format = "Rp " . number_format($data['harga_sewa'], 0, ',', '.');
                        
                        if ($data['kondisi_mesin'] == 'Service') {
                            $status = '<span class="tidak-tersedia">❌ Tidak Tersedia - Sedang di Bengkel</span>';
                        } else {
                            $status = '<span class="tersedia">✅ Siap Disewa</span>';
                        }
                        
                        echo "<tr>";
                        echo "<td>" . $data['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($data['merk_kendaraan']) . "</td>";
                        echo "<td>" . htmlspecialchars($data['plat_nomor']) . "</td>";
                        echo "<td>" . $harga_format . "</td>";
                        echo "<td>" . $data['kondisi_mesin'] . "</td>";
                        echo "<td>" . $status . "</td>";
                        echo "</tr>";
                    endforeach;
                else:
                   
                    echo '<tr><td colspan="6" class="not-found">';
                    echo '<i>🔍</i>';
                    echo '<h3>Data Tidak Ditemukan</h3>';
                    echo '<p>Maaf, kendaraan dengan kata kunci "' . htmlspecialchars($keyword) . '" tidak ditemukan.</p>';
                    echo '<p>Silakan coba dengan kata kunci lain atau ';
                    echo '<a href="index.php" style="color: #4CAF50;">reset pencarian</a>.</p>';
                    echo '</td></tr>';
                endif;
                ?>
            </tbody>
        </table>
        
        <div class="footer-actions">
            <small>Total Data: <?php echo count($kendaraan); ?> kendaraan</small>
            <?php if ($is_searching): ?>
            <small> | Hasil Pencarian: <?php echo $jumlah_data; ?> kendaraan</small>
            <?php endif; ?>
        </div>
        
        <div style="text-align: center; margin-top: 30px; padding: 15px; background-color: #f9f9f9; border-radius: 5px;">
            <p><strong>Keterangan:</strong></p>
            <p><span style="color: green;">✅ Siap Disewa</span> (Kondisi Mesin Bagus)</p>
            <p><span style="color: red;">❌ Tidak Tersedia - Sedang di Bengkel</span> (Kondisi Mesin Service)</p>
        </div>
    </div>
</body>
</html>