<?php

require_once 'vendor/autoload.php';

use CodeIgniter\Database\Config;

// Load database configuration
$config = new Config();
$db = $config->default;

try {
    $db->query("CREATE TABLE IF NOT EXISTS tbl_m_ukp (
        id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        kode_ukp VARCHAR(50) NOT NULL,
        nama_ukp VARCHAR(255) NOT NULL,
        deskripsi TEXT NULL,
        status ENUM('aktif','tidak_aktif') DEFAULT 'aktif',
        created_at DATETIME NULL,
        updated_at DATETIME NULL,
        PRIMARY KEY (id),
        UNIQUE KEY kode_ukp (kode_ukp)
    )");
    
    echo "Table tbl_m_ukp created successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
