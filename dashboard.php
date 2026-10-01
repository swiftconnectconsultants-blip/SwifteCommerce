<?php
require_once __DIR__.'/../config/config.php'; admin_required();
$title='Admin Dashboard';
$stats=[
'products'=>(int)db()->query("SELECT COUNT(*) FROM products")->fetchColumn(),
'orders'=>(int)db()->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
'sales'=>(float)db()->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status IN ('paid','processing','shipped','delivered')")->fetchColumn(),
'customers'=>(int)db()->query("SELECT COUNT(DISTINCT email) FROM orders")->fetchColumn()
];
$recent=db()->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 10")->fetchAll();
require __DIR__.'/admin_header.php'; ?>
<div class="admin-cards"><div><small>PRODUCTS</small><b><?=$stats['products']?></b></div><div><small>ORDERS</small><b><?=$stats['orders']?></b></div><div><small>SALES</small><b><?=money($stats['sales'])?></b></div><div><small>CUSTOMERS</small><b><?=$stats['customers']?></b></div></div>
<div class="admin-panel"><div class="section-head"><h2>Recent orders</h2><a href="orders.php">View all</a></div><table><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th></tr><?php foreach($recent as $o): ?><tr><td><?=e($o['order_number'])?></td><td><?=e($o['customer_name'])?></td><td><?=money((float)$o['total'])?></td><td><?=e($o['status'])?></td></tr><?php endforeach;?></table></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
