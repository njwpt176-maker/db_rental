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
include 'koneksi.php';


if (isset($_POST['submit'])) {
    
    
    $id = $_POST['id'];
    $merk = trim($_POST['merk']);
    $plat = trim($_POST['plat']);
    $harga = trim($_POST['harga']);
    $kondisi = trim($_POST['kondisi']);
    
   
    if (empty($merk) || empty($plat) || empty($harga) || empty($kondisi)) {
        header("Location: edit.php?id=$id&error=empty");
        exit();
    }
    

    $query = "UPDATE kendaraan SET 
              merk_kendaraan = ?, 
              plat_nomor = ?, 
              harga_sewa = ?, 
              kondisi_mesin = ? 
              WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        
        mysqli_stmt_bind_param($stmt, "ssssi", $merk, $plat, $harga, $kondisi, $id);
        
       
        if (mysqli_stmt_execute($stmt)) {
           
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
    
    header("Location: index.php");
    exit();
}

mysqli_close($conn);
?>