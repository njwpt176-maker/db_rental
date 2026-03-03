<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Kendaraan</title>
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
            border-color: #4caf50;
            box-shadow: 0 0 5px rgba(76,175,80,0.3);
        }
        button {
            background-color: #4caf50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #666;
            text-decoration: none;
        }
        .back-link:hover {
            color: #4CAF50;
        }
        .note {
            background-color: #e8f5e9;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 14px;
            color: #2e7d32;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚗 TAMBAH DATA KENDARAAN</h1>

        <form method="POST" action="proses_data.php">
            <div class="form-group">
                <label for="merk">Merk Kendaraan:</label>
                <input type="text" id="merk" name="merk" placeholder="Contoh: Toyota Avanza" required>
            </div>

            <div class="form-group">
                <label for="plat">Plat Nomor:</label>
                <input type="text" id="plat" name="plat" placeholder="Contoh: B 1234 ABC" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga Sewa per Hari (Rp):</label>
                <input type="number" id="harga" name="harga" placeholder="Contoh: 350000" min="0" step="1000" required>
            </div>

            <div class="form-group">
                <label for="kondisi">Kondisi Mesin:</label>
                <select id="kondisi" name="kondisi" required>
                    <option value="">-- Pilih Kondisi --</option>
                    <option value="Bagus">Bagus</option>
                    <option value="Service">Service</option>
                </select>
            </div>

            <button type="submit" name="submit">TAMBAH DATA</button>
        </form>

         <a href="index.php" class="back-link">← Lihat Daftar Kendaraan</a>

        <div class="note">
            <strong>Catatan:</strong> Data yang diisi akan diproses dan ditampilkan di halaman berikutnya.
        </div>
    </div>
</body>
</html>        