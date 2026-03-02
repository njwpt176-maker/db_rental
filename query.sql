CREATE DATABASE db_rental;
USE db_rental;
CREATE TABLE kendaraan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    merk_kendaraan VARCHAR(100) NOT NULL,
    plat_nomor VARCHAR(15) UNIQUE NOT NULL,
    harga_sewa DECIMAL(10,2) NOT NULL,
    kondisi_mesin ENUM('Bagus', 'Service') NOT NULL
);

INSERT INTO kendaraan (merk_kendaraan, plat_nomor, harga_sewa, kondisi_mesin) VALUES
('Toyota Avanza', 'B 1234 ABC', 350000, 'Bagus'),
('Honda Brio', 'B 5678 XYZ', 300000, 'Service'),
('Suzuki Ertiga', 'D 9012 DEF', 375000, 'Bagus'),
('Daihatsu Xenia', 'B 3456 GHI', 325000, 'Service'),
('Mitsubishi Xpander', 'F 7890 JKL', 400000, 'Bagus');
SELECT * FROM kendaraan;