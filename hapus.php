<?php

session_start();
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    
    $query = "DELETE FROM kendaraan WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        
        mysqli_stmt_bind_param($stmt, "i", $id);
        
       
        if (mysqli_stmt_execute($stmt)) {
           
            header("Location: index.php?status=hapus_sukses");
            exit();
        } else {
           
            echo "Gagal menghapus data: " . mysqli_error($conn);
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