<?php
session_start();
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kendaraan</title>
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
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #2196F3;
            box-shadow: 0 0 5px rgba(33,150,243,0.3);
        }
        button {
            background-color: #2196F3;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #1976D2;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #666;
            text-decoration: none;
        }
        .back-link:hover {
            color: #2196F3;
        }
        .info {
            background-color: #e3f2fd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            color: #0d47a1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ EDIT DATA KENDARAAN</h1>
        
        <?php
       
        include 'koneksi.php';
        
       
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            
            $query = "SELECT * FROM kendaraan WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
           
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            } else {
                echo "<div class='info'>Data tidak ditemukan!</div>";
                echo "<a href='index.php' class='back-link'>← Kembali ke Daftar</a>";
                exit();
            }
        } else {
            header("Location: index.php");
            exit();
        }
        ?>
        
        
        <form method="POST" action="proses_edit.php">
           
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            
            <div class="form-group">
                <label for="merk">Merk Kendaraan:</label>
                <input type="text" id="merk" name="merk" 
                       value="<?= htmlspecialchars($row['merk_kendaraan']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="plat">Plat Nomor:</label>
                <input type="text" id="plat" name="plat" 
                       value="<?= htmlspecialchars($row['plat_nomor']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="harga">Harga Sewa per Hari (Rp):</label>
                <input type="number" id="harga" name="harga" 
                       value="<?= $row['harga_sewa'] ?>" min="0" step="1000" required>
            </div>
            
            <div class="form-group">
                <label for="kondisi">Kondisi Mesin:</label>
                <select id="kondisi" name="kondisi" required>
                    <option value="">-- Pilih Kondisi --</option>
                    <option value="Bagus" <?= ($row['kondisi_mesin'] == 'Bagus') ? 'selected' : '' ?>>Bagus</option>
                    <option value="Service" <?= ($row['kondisi_mesin'] == 'Service') ? 'selected' : '' ?>>Service</option>
                </select>
            </div>
            
            <button type="submit" name="submit">UPDATE DATA</button>
        </form>
        
        <a href="index.php" class="back-link">← Kembali ke Daftar Kendaraan</a>
    </div>
</body>
</html>