<?php
// Mulai session untuk menampilkan pesan error/sukses
session_start();

// Include koneksi database
include 'koneksi.php';

// Proses registrasi jika form disubmit
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validasi input
    $error = [];
    
    if (empty($username)) {
        $error[] = "Username tidak boleh kosong";
    }
    
    if (empty($password)) {
        $error[] = "Password tidak boleh kosong";
    }
    
    if ($password != $confirm_password) {
        $error[] = "Password dan konfirmasi password tidak cocok";
    }
    
    if (strlen($password) < 6) {
        $error[] = "Password minimal 6 karakter";
    }
    
    // Cek apakah username sudah ada
    if (empty($error)) {
        $check_query = "SELECT * FROM user WHERE username = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $username);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error[] = "Username sudah digunakan, silakan pilih username lain";
        }
        mysqli_stmt_close($check_stmt);
    }
    
    // Jika tidak ada error, simpan ke database
    if (empty($error)) {
        // Hash password menggunakan password_hash()
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Query INSERT dengan prepared statement
        $query = "INSERT INTO user (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
        
        if (mysqli_stmt_execute($stmt)) {
            // Registrasi berhasil, redirect ke login
            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
            header("Location: login.php");
            exit();
        } else {
            $error[] = "Gagal registrasi: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Rental Kendaraan</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102,126,234,0.3);
        }
        button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: opacity 0.3s;
        }
        button:hover {
            opacity: 0.9;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .error ul {
            margin: 5px 0;
            padding-left: 20px;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            color: #667eea;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 REGISTRASI AKUN</h1>
        
        <?php if (!empty($error)): ?>
            <div class="error">
                <strong>Error:</strong>
                <ul>
                    <?php foreach ($error as $err): ?>
                        <li><?= $err ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" 
                       value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="password">Password (min. 6 karakter):</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" name="register">REGISTER</button>
        </form>
        
        <div class="login-link">
            Sudah punya akun? <a href="login.php">Login disini</a>
        </div>
    </div>
</body>
</html>