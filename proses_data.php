<?php
// Mulai session
session_start();

// Proteksi halaman - cek apakah user sudah login
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Include koneksi database
include 'koneksi.php';
?>

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
        
        include 'koneksi.php';
        
       
        if (isset($_POST['submit'])) {
            
            $merk = isset($_POST['merk']) ? trim($_POST['merk']) : '';
            $plat = isset($_POST['plat']) ? trim($_POST['plat']) : '';
            $harga = isset($_POST['harga']) ? trim($_POST['harga']) : '';
            $kondisi = isset($_POST['kondisi']) ? trim($_POST['kondisi']) : '';
            
            
            if (empty($merk) || empty($plat) || empty($harga) || empty($kondisi)) {
                
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
                
                
                $query = "INSERT INTO kendaraan (merk_kendaraan, plat_nomor, harga_sewa, kondisi_mesin) 
                          VALUES (?, ?, ?, ?)";
                
                $stmt = mysqli_prepare($conn, $query);
                
                if ($stmt) {
                    
                    mysqli_stmt_bind_param($stmt, "ssss", $merk, $plat, $harga, $kondisi);
                    
                   
                    if (mysqli_stmt_execute($stmt)) {
                       
                        header("Location: index.php?status=sukses");
                        exit(); 
                    } else {
                        
                        echo '<div class="error">';
                        echo '<h3>❌ Gagal menyimpan data!</h3>';
                        echo '<p>Error: ' . mysqli_error($conn) . '</p>';
                        echo '<a href="tambah_data.php" class="button">⬅️ Kembali ke Form</a>';
                        echo '</div>';
                    }
                    
                    mysqli_stmt_close($stmt);
                } else {
                    
                    echo '<div class="error">';
                    echo '<h3>❌ Gagal mempersiapkan query!</h3>';
                    echo '<p>Error: ' . mysqli_error($conn) . '</p>';
                    echo '<a href="tambah_data.php" class="button">⬅️ Kembali ke Form</a>';
                    echo '</div>';
                }
            }
        } else {
           
            echo '<div class="error">';
            echo '<h3>⚠️ Akses Tidak Sah!</h3>';
            echo '<p>Anda tidak boleh mengakses halaman ini secara langsung.</p>';
            echo '<p>Silahkan isi form terlebih dahulu.</p>';
            echo '<a href="tambah_data.php" class="button">⬅️ Kembali ke Form</a>';
            echo '</div>';
        }
        
        mysqli_close($conn);
        ?>
    </div>
</body>
</html>