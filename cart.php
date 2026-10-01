<?php
require_once __DIR__ . '/config/config.php';
$title='Your Bag';
$items=cart_details(); $subtotal=cart_total(); $shipping=$items?SHIPPING_FEE:0;
require __DIR__ . '/includes/header.php'; ?>
<section class="page-head"><p class="eyebrow">YOUR BAG</p><h1>Shopping bag</h1></section>
<section class="section cart-page">
<?php if (!$items): ?><div class="empty">Your bag is empty. <a href="shop.php">Continue shopping →</a></div>
<?php else: ?>
<div class="cart-items"><?php foreach($items as $p): ?><div class="cart-row">
<img src="<?= e(product_image($p['image'])) ?>" alt="">
<div><h3><?= e($p['name']) ?></h3><p><?= money((float)$p['price']) ?></p></div>
<input class="cart-qty" data-id="<?= (int)$p['id'] ?>" type="number" min="1" value="<?= (int)$p['qty'] ?>">
<strong><?= money((float)$p['line_total']) ?></strong>
<button class="remove" data-remove="<?= (int)$p['id'] ?>">×</button>
</div><?php endforeach; ?></div>
<aside class="summary"><h2>Summary</h2><div><span>Subtotal</span><strong><?= money($subtotal) ?></strong></div><div><span>Delivery</span><strong><?= money($shipping) ?></strong></div><hr><div><span>Total</span><strong><?= money($subtotal+$shipping) ?></strong></div><a class="btn btn-dark wide" href="checkout.php">Checkout</a></aside>
<?php endif; ?></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
