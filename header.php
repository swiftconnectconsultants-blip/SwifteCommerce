<?php require_once __DIR__ . '/../config/config.php'; ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? APP_NAME) ?></title>
<link rel="stylesheet" href="<?= e(BASE_URL) ?>/assets/css/style.css">
</head>
<body>
<header class="site-header">
  <a class="brand" href="<?= e(BASE_URL) ?>/index.php">NOIRTHREAD</a>
  <nav>
    <a href="<?= e(BASE_URL) ?>/shop.php">Shop</a>
    <a href="<?= e(BASE_URL) ?>/shop.php?category=T-Shirts">T-Shirts</a>
    <a href="<?= e(BASE_URL) ?>/shop.php?category=Shorts">Shorts</a>
    <a href="<?= e(BASE_URL) ?>/shop.php?category=Caps">Caps</a>
  </nav>
  <a class="cart-link" href="<?= e(BASE_URL) ?>/cart.php">Bag <span id="cartCount"><?= cart_count() ?></span></a>
</header>
<main>
