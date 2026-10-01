<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

function e(?string $v): string {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
function money(float $v): string {
    return 'R ' . number_format($v, 2);
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_check(?string $token): void {
    if (!$token || !hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(419); exit('Invalid CSRF token.');
    }
}
function redirect(string $url): never { header('Location: ' . $url); exit; }
function admin_required(): void {
    if (empty($_SESSION['admin'])) redirect('login.php');
}
function cart(): array { return $_SESSION['cart'] ?? []; }
function cart_count(): int { return array_sum(array_map('intval', cart())); }

function cart_details(): array {
    $ids = array_keys(cart());
    if (!$ids) return [];
    $marks = implode(',', array_fill(0, count($ids), '?'));
    $st = db()->prepare("SELECT * FROM products WHERE id IN ($marks) AND status='active'");
    $st->execute($ids);
    $rows = [];
    foreach ($st->fetchAll() as $p) {
        $qty = max(1, (int)($_SESSION['cart'][$p['id']] ?? 1));
        $p['qty'] = $qty;
        $p['line_total'] = $qty * (float)$p['price'];
        $rows[] = $p;
    }
    return $rows;
}
function cart_total(): float {
    return array_sum(array_map(fn($p) => (float)$p['line_total'], cart_details()));
}
function product_image(?string $image): string {
    return $image ?: 'assets/images/placeholder.svg';
}
function json_response(array $data, int $status=200): never {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}
