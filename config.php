<?php
declare(strict_types=1);

define('APP_NAME', 'NOIRTHREAD');
define('BASE_URL', 'http://localhost/fashion_store');

define('DB_HOST', 'mysql6008.site4now.net');
define('DB_NAME', 'db_acd491_ecommcdropshipping');
define('DB_USER', 'acd491_ecommcdropshipping');
define('DB_PASS', 'Pass@Vinc3');

define('CURRENCY', 'ZAR');
define('SHIPPING_FEE', 79.00);

define('ADMIN_USER', 'admin');
// Change this password after installation.
define('ADMIN_PASSWORD', 'ChangeMe123!');

define('PAYFAST_MERCHANT_ID', '');
define('PAYFAST_MERCHANT_KEY', '');
define('PAYFAST_PASSPHRASE', '');
define('PAYFAST_SANDBOX', true);

define('OZOW_SITE_CODE', '');
define('OZOW_PRIVATE_KEY', '');
define('OZOW_API_KEY', '');
define('OZOW_SANDBOX', true);

date_default_timezone_set('Africa/Johannesburg');

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../includes/functions.php';
