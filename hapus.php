<?php
// =============================================
// FILE: hapus.php - Menghapus Data Kendaraan
// =============================================

// Include koneksi database
include 'koneksi.php';

// Cek apakah ada ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Query DELETE dengan prepared statement
    $query = "DELETE FROM kendaraan WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        // Bind parameter (i = integer)
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        // Eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, redirect ke index.php
            header("Location: index.php?status=hapus_sukses");
            exit();
        } else {
            // Jika gagal
            echo "Gagal menghapus data: " . mysqli_error($conn);
        }
        
        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal mempersiapkan query: " . mysqli_error($conn);
    }
} else {
    // Jika tidak ada ID, redirect ke index
    header("Location: index.php");
    exit();
}

// Tutup koneksi
mysqli_close($conn);
?>