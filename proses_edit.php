<?php
// =============================================
// FILE: proses_edit.php - Memproses Update Data
// =============================================

include 'koneksi.php';

// Cek apakah form disubmit
if (isset($_POST['submit'])) {
    
    // Tangkap data dari form
    $id = $_POST['id'];
    $merk = trim($_POST['merk']);
    $plat = trim($_POST['plat']);
    $harga = trim($_POST['harga']);
    $kondisi = trim($_POST['kondisi']);
    
    // Validasi sederhana
    if (empty($merk) || empty($plat) || empty($harga) || empty($kondisi)) {
        header("Location: edit.php?id=$id&error=empty");
        exit();
    }
    
    // Query UPDATE dengan prepared statement
    $query = "UPDATE kendaraan SET 
              merk_kendaraan = ?, 
              plat_nomor = ?, 
              harga_sewa = ?, 
              kondisi_mesin = ? 
              WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        // Bind parameter (ssssi = string, string, string, string, integer)
        mysqli_stmt_bind_param($stmt, "ssssi", $merk, $plat, $harga, $kondisi, $id);
        
        // Eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, redirect ke index
            header("Location: index.php?status=edit_sukses");
            exit();
        } else {
            echo "Gagal mengupdate data: " . mysqli_error($conn);
            echo "<br><a href='edit.php?id=$id'>Kembali ke form edit</a>";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal mempersiapkan query: " . mysqli_error($conn);
    }
    
} else {
    // Jika akses langsung tanpa submit
    header("Location: index.php");
    exit();
}

mysqli_close($conn);
?>