<?php
// Inisialisasi untuk semua halaman admin.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/functions/functions.php';

ensure_schema();

// Folder gambar (dipakai bersama dengan halaman toko)
define('PRODUCT_IMG_DIR', __DIR__ . '/../../assets/images/product_images/');
define('CUSTOMER_IMG_DIR', __DIR__ . '/../../assets/images/customers/');

/**
 * Hanya admin yang sudah login yang boleh membuka halaman admin.
 * Session admin dipisah dari session pelanggan ('adminName' vs 'customerName').
 */
function require_admin($login_url)
{
    if (empty($_SESSION['adminName'])) {
        redirect($login_url);
    }
}
