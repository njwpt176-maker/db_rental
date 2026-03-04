<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Data Kendaraan</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .data-table th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            text-align: left;
            width: 40%;
        }
        .data-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        .data-table tr:hover {
            background-color: #f5f5f5;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #45a049;
        }
        .button-danger {
            background-color: #dc3545;
        }
        .button-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 PROSES TAMBAH DATA</h1>
        
        <?php
        // =============================================
        // KONEKSI KE DATABASE
        // =============================================
        include 'koneksi.php';
        
        // =============================================
        // CEK APAKAH FORM DISUBMIT
        // =============================================
        if (isset($_POST['submit'])) {
            
            // Tangkap data dari form dan bersihkan dengan trim
            $merk = isset($_POST['merk']) ? trim($_POST['merk']) : '';
            $plat = isset($_POST['plat']) ? trim($_POST['plat']) : '';
            $harga = isset($_POST['harga']) ? trim($_POST['harga']) : '';
            $kondisi = isset($_POST['kondisi']) ? trim($_POST['kondisi']) : '';
            
            // =============================================
            // VALIDASI DATA KOSONG
            // =============================================
            if (empty($merk) || empty($plat) || empty($harga) || empty($kondisi)) {
                // Tampilkan pesan error
                echo '<div class="error">';
                echo '<h3>❌ Error: Semua kolom wajib diisi!</h3>';
                echo '<ul>';
                if (empty($merk)) echo '<li>Merk kendaraan belum diisi</li>';
                if (empty($plat)) echo '<li>Plat nomor belum diisi</li>';
                if (empty($harga)) echo '<li>Harga sewa belum diisi</li>';
                if (empty($kondisi)) echo '<li>Kondisi mesin belum dipilih</li>';
                echo '</ul>';
                echo '<a href="tambah_data.php" class="button">⬅️ Kembali ke Form</a>';
                echo '</div>';
            } else {
                // =============================================
                // QUERY INSERT MENGGUNAKAN PREPARED STATEMENT
                // =============================================
                
                // Query dengan tanda tanya (?) untuk values
                $query = "INSERT INTO kendaraan (merk_kendaraan, plat_nomor, harga_sewa, kondisi_mesin) 
                          VALUES (?, ?, ?, ?)";
                
                // Prepare statement
                $stmt = mysqli_prepare($conn, $query);
                
                if ($stmt) {
                    // Bind parameter ke prepared statement
                    // "ssss" = string, string, string, string
                    // (harga sebenarnya integer, tapi kita bind sebagai string dulu)
                    mysqli_stmt_bind_param($stmt, "ssss", $merk, $plat, $harga, $kondisi);
                    
                    // Eksekusi query
                    if (mysqli_stmt_execute($stmt)) {
                        // Jika berhasil, redirect ke index.php
                        header("Location: index.php?status=sukses");
                        exit(); // Penting: hentikan eksekusi setelah redirect
                    } else {
                        // Jika gagal, tampilkan error
                        echo '<div class="error">';
                        echo '<h3>❌ Gagal menyimpan data!</h3>';
                        echo '<p>Error: ' . mysqli_error($conn) . '</p>';
                        echo '<a href="tambah_data.php" class="button">⬅️ Kembali ke Form</a>';
                        echo '</div>';
                    }
                    
                    // Tutup statement
                    mysqli_stmt_close($stmt);
                } else {
                    // Jika prepare gagal
                    echo '<div class="error">';
                    echo '<h3>❌ Gagal mempersiapkan query!</h3>';
                    echo '<p>Error: ' . mysqli_error($conn) . '</p>';
                    echo '<a href="tambah_data.php" class="button">⬅️ Kembali ke Form</a>';
                    echo '</div>';
                }
            }
        } else {
            // Jika langsung akses file ini tanpa submit form
            echo '<div class="error">';
            echo '<h3>⚠️ Akses Tidak Sah!</h3>';
            echo '<p>Anda tidak boleh mengakses halaman ini secara langsung.</p>';
            echo '<p>Silahkan isi form terlebih dahulu.</p>';
            echo '<a href="tambah_data.php" class="button">⬅️ Kembali ke Form</a>';
            echo '</div>';
        }
        
        // Tutup koneksi database
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>