<?php
require_once __DIR__.'/../config/config.php'; admin_required();
if(isset($_GET['delete'])){db()->prepare("UPDATE products SET status='archived' WHERE id=?")->execute([(int)$_GET['delete']]);redirect('products.php');}
$products=db()->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll(); $title='Products'; require __DIR__.'/admin_header.php'; ?>
<div class="section-head"><h1>Products</h1><a class="btn btn-dark" href="product-form.php">Add product</a></div><div class="admin-panel"><table><tr><th>SKU</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th></th></tr><?php foreach($products as $p): ?><tr><td><?=e($p['sku'])?></td><td><?=e($p['name'])?></td><td><?=e($p['category'])?></td><td><?=money((float)$p['price'])?></td><td><?=$p['stock']?></td><td><?=e($p['status'])?></td><td><a href="product-form.php?id=<?=$p['id']?>">Edit</a> · <a href="?delete=<?=$p['id']?>" onclick="return confirm('Archive product?')">Archive</a></td></tr><?php endforeach;?></table></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
