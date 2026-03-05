<?php
// Mulai session
session_start();

// Jika sudah login, redirect ke index
if (isset($_SESSION['is_logged_in'])) {
    header("Location: index.php");
    exit();
}

// Include koneksi database
include 'koneksi.php';

// Proses login jika form disubmit
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Validasi input
    $error = [];
    
    if (empty($username)) {
        $error[] = "Username tidak boleh kosong";
    }
    
    if (empty($password)) {
        $error[] = "Password tidak boleh kosong";
    }
    
    // Jika validasi lolos, cek ke database
    if (empty($error)) {
        // Query SELECT username
        $query = "SELECT * FROM user WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Verifikasi password dengan password_verify()
            if (password_verify($password, $user['password'])) {
                // Password cocok, buat session
                $_SESSION['is_logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                // Redirect ke index.php
                header("Location: index.php");
                exit();
            } else {
                $error[] = "Password salah!";
            }
        } else {
            $error[] = "Username tidak ditemukan!";
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
    <title>Login - Rental Kendaraan</title>
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
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #c3e6cb;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
        .register-link a {
            color: #667eea;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 LOGIN RENTAL KENDARAAN</h1>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success">
                <?= $_SESSION['success'] ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
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
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" name="login">LOGIN</button>
        </form>
        
        <div class="register-link">
            Belum punya akun? <a href="register.php">Register disini</a>
        </div>
    </div>
</body>
</html>