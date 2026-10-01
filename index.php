<?php
require_once __DIR__ . '/config/config.php';
$title = 'NOIRTHREAD — Modern Essentials';
$featured = db()->query("SELECT * FROM products WHERE status='active' AND featured=1 ORDER BY created_at DESC LIMIT 8")->fetchAll();
if (!$featured) $featured = db()->query("SELECT * FROM products WHERE status='active' ORDER BY created_at DESC LIMIT 8")->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="hero-copy">
    <p class="eyebrow">NEW SEASON / 2026</p>
    <h1>EVERYDAY<br><span>ESSENTIALS.</span></h1>
    <p>Clean silhouettes, monochrome energy and pieces made for daily movement.</p>
    <a class="btn btn-dark" href="shop.php">Shop collection</a>
  </div>
</section>
<section class="section">
  <div class="section-head"><h2>Featured</h2><a href="shop.php">View all →</a></div>
  <div class="grid products">
  <?php foreach ($featured as $p): ?>
    <article class="card">
      <a href="product.php?id=<?= (int)$p['id'] ?>">
        <div class="product-image"><img src="<?= e(product_image($p['image'])) ?>" alt="<?= e($p['name']) ?>"></div>
        <div class="card-body"><h3><?= e($p['name']) ?></h3><p><?= money((float)$p['price']) ?></p></div>
      </a>
      <button class="quick-add" data-add="<?= (int)$p['id'] ?>">Add to bag</button>
    </article>
  <?php endforeach; ?>
  </div>
</section>
<section class="split-banner"><div><p class="eyebrow">THE MONOCHROME EDIT</p><h2>Less noise.<br>More style.</h2></div><a class="btn btn-light" href="shop.php">Explore</a></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
