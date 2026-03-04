<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Kendaraan - Database</title>
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
        
        /* Style untuk form pencarian */
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
        
        /* Style untuk info pencarian */
        .search-info {
            background-color: #e7f3ff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #2196F3;
        }
        
        /* Style untuk tabel */
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
        
        /* Style untuk pesan data tidak ditemukan */
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
        <h1>🚗 RENTAL KENDARAAN NAJWA</h1>
        
        <!-- Header dengan tombol tambah data -->
        <div class="header-actions">
            <div></div>
            <a href="tambah_data.php" class="btn-tambah">➕ Tambah Data Baru</a>
        </div>
        
        <?php
        // =============================================
        // KONEKSI KE DATABASE
        // =============================================
        include 'koneksi.php';
        
        // =============================================
        // LOGIKA PENCARIAN
        // =============================================
        $keyword = '';
        $is_searching = false;
        
        // Cek apakah ada parameter GET 'keyword'
        if (isset($_GET['keyword']) && !empty(trim($_GET['keyword']))) {
            $is_searching = true;
            $keyword = trim($_GET['keyword']);
            
            // Query dengan pencarian (gunakan LIKE untuk mencari sebagai)
            $keyword_like = "%$keyword%";
            $query = "SELECT * FROM kendaraan 
                      WHERE merk_kendaraan LIKE ? 
                      OR plat_nomor LIKE ?
                      ORDER BY id ASC";
            
            // Prepare statement untuk keamanan
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ss", $keyword_like, $keyword_like);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            // Query semua data
            $query = "SELECT * FROM kendaraan ORDER BY id ASC";
            $result = mysqli_query($conn, $query);
        }
        
        // Hitung jumlah data
        $jumlah_data = mysqli_num_rows($result);
        ?>
        
        <!-- Form Pencarian -->
        <form method="GET" action="index.php" class="search-form">
            <input type="text" 
                   name="keyword" 
                   placeholder="🔍 Cari berdasarkan merk atau plat nomor..." 
                   value="<?php echo htmlspecialchars($keyword); ?>"
                   autofocus>
            <button type="submit">Cari</button>
        </form>
        
        <!-- Tombol Reset Pencarian -->
        <?php if ($is_searching): ?>
        <div style="text-align: right; margin-bottom: 10px;">
            <a href="index.php" class="btn-reset">↺ Reset Pencarian</a>
        </div>
        <?php endif; ?>
        
        <!-- Info pencarian -->
        <?php if ($is_searching): ?>
        <div class="search-info">
            <strong>🔍 Hasil pencarian untuk:</strong> "<?php echo htmlspecialchars($keyword); ?>"<br>
            <strong>📊 Ditemukan:</strong> <?php echo $jumlah_data; ?> kendaraan
        </div>
        <?php endif; ?>
        
        <!-- Tabel Data Kendaraan -->
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
                // Cek apakah ada data
                if ($jumlah_data > 0):
                    // Looping data dari database dengan mysqli_fetch_assoc
                    while ($row = mysqli_fetch_assoc($result)):
                        // Format harga
                        $harga_format = "Rp " . number_format($row['harga_sewa'], 0, ',', '.');
                        
                        // Tentukan status berdasarkan kondisi mesin
                        if ($row['kondisi_mesin'] == 'Service') {
                            $status = '<span class="tidak-tersedia">❌ Tidak Tersedia - Sedang di Bengkel</span>';
                        } else {
                            $status = '<span class="tersedia">✅ Siap Disewa</span>';
                        }
                        
                        // Tampilkan baris tabel
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['merk_kendaraan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['plat_nomor']) . "</td>";
                        echo "<td>" . $harga_format . "</td>";
                        echo "<td>" . $row['kondisi_mesin'] . "</td>";
                        echo "<td>" . $status . "</td>";
                        echo "</tr>";
                    endwhile;
                else:
                    // Tampilkan pesan jika data tidak ditemukan
                    echo '<tr><td colspan="6" class="not-found">';
                    echo '<i>🔍</i>';
                    echo '<h3>Data Tidak Ditemukan</h3>';
                    if ($is_searching) {
                        echo '<p>Maaf, kendaraan dengan kata kunci "' . htmlspecialchars($keyword) . '" tidak ditemukan.</p>';
                    } else {
                        echo '<p>Belum ada data kendaraan di database.</p>';
                    }
                    echo '<p><a href="tambah_data.php" style="color: #4CAF50;">Tambah data sekarang</a></p>';
                    echo '</td></tr>';
                endif;
                
                // Bebaskan memory
                mysqli_free_result($result);
                ?>
            </tbody>
        </table>
        
        <!-- Footer -->
        <div class="footer-actions">
            <small>Total Data: <?php echo $jumlah_data; ?> kendaraan</small>
        </div>
        
        <!-- Keterangan -->
        <div style="text-align: center; margin-top: 30px; padding: 15px; background-color: #f9f9f9; border-radius: 5px;">
            <p><strong>Keterangan:</strong></p>
            <p><span style="color: green;">✅ Siap Disewa</span> (Kondisi Mesin Bagus)</p>
            <p><span style="color: red;">❌ Tidak Tersedia - Sedang di Bengkel</span> (Kondisi Mesin Service)</p>
        </div>
    </div>
</body>
</html>