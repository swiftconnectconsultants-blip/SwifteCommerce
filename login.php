<?php
require_once __DIR__.'/../config/config.php';
if(!empty($_SESSION['admin'])) redirect('dashboard.php');
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){csrf_check($_POST['csrf']??null); if(hash_equals(ADMIN_USER,$_POST['user']??'') && hash_equals(ADMIN_PASSWORD,$_POST['pass']??'')){$_SESSION['admin']=true;redirect('dashboard.php');} $error='Invalid credentials.';}
$title='Admin Login'; require __DIR__.'/../includes/header.php'; ?>
<section class="auth"><h1>Admin login</h1><?php if($error): ?><div class="alert"><?=e($error)?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><label>Username<input name="user" required></label><label>Password<input type="password" name="pass" required></label><button class="btn btn-dark wide">Sign in</button></form></section>
<?php require __DIR__.'/../includes/footer.php'; ?>
