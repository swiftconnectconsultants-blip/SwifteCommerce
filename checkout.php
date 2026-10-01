<?php
require_once __DIR__ . '/config/config.php';
$items=cart_details(); if(!$items) redirect('cart.php');
$title='Checkout';
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
  csrf_check($_POST['csrf']??null);
  $required=['name','email','phone','address','city','province','postal_code','payment'];
  foreach($required as $k) if(trim($_POST[$k]??'')==='') $errors[]="$k is required.";
  if(!filter_var($_POST['email']??'',FILTER_VALIDATE_EMAIL)) $errors[]='Valid email required.';
  if(!in_array($_POST['payment']??'', ['payfast','ozow'],true)) $errors[]='Select a payment method.';
  if(!$errors){
    $pdo=db(); $pdo->beginTransaction();
    try{
      $subtotal=cart_total(); $shipping=SHIPPING_FEE; $total=$subtotal+$shipping;
      $st=$pdo->prepare("INSERT INTO orders (order_number,customer_name,email,phone,address,city,province,postal_code,payment_method,status,subtotal,shipping,total) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $num='NT-'.date('YmdHis').'-'.random_int(100,999);
      $st->execute([$num,$_POST['name'],$_POST['email'],$_POST['phone'],$_POST['address'],$_POST['city'],$_POST['province'],$_POST['postal_code'],$_POST['payment'],'pending',$subtotal,$shipping,$total]);
      $oid=(int)$pdo->lastInsertId();
      $it=$pdo->prepare("INSERT INTO order_items (order_id,product_id,sku,name,qty,unit_price,total) VALUES (?,?,?,?,?,?,?)");
      foreach($items as $p){$it->execute([$oid,$p['id'],$p['sku'],$p['name'],$p['qty'],$p['price'],$p['line_total']]);}
      $pdo->commit(); $_SESSION['cart']=[];
      if($_POST['payment']==='payfast') redirect('payments/payfast/start.php?order='.$oid);
      redirect('payments/ozow/start.php?order='.$oid);
    }catch(Throwable $e){$pdo->rollBack();$errors[]='Could not create order.';}
  }
}
require __DIR__.'/includes/header.php';
?>
<section class="page-head"><p class="eyebrow">CHECKOUT</p><h1>Complete your order</h1></section>
<section class="checkout-grid"><form method="post" class="checkout-form"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<?php if($errors): ?><div class="alert"><?= e(implode(' ',$errors)) ?></div><?php endif; ?>
<h2>Delivery details</h2>
<div class="form-grid"><?php foreach(['name'=>'Full name','email'=>'Email','phone'=>'Phone','address'=>'Street address','city'=>'City','province'=>'Province','postal_code'=>'Postal code'] as $k=>$label): ?><label><?= e($label) ?><input name="<?= $k ?>" value="<?= e($_POST[$k]??'') ?>" required></label><?php endforeach; ?></div>
<h2>Payment</h2><label class="payment-option"><input type="radio" name="payment" value="payfast" required> PayFast</label><label class="payment-option"><input type="radio" name="payment" value="ozow"> Ozow</label>
<button class="btn btn-dark wide">Place order & pay</button></form>
<aside class="summary"><h2>Order summary</h2><?php foreach($items as $p): ?><div><span><?= e($p['name']) ?> × <?= (int)$p['qty'] ?></span><strong><?= money((float)$p['line_total']) ?></strong></div><?php endforeach; ?><hr><div><span>Total</span><strong><?= money(cart_total()+SHIPPING_FEE) ?></strong></div></aside></section>
<?php require __DIR__.'/includes/footer.php'; ?>
