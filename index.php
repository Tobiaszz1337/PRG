<?php
$host = "localhost";
$port = 8889;        
$db   = "test_db";    
$user = "root";
$pass = "root";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;port=$port;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, 
    ]);
    $pdo->exec("USE `$db`");

} catch (PDOException $e) {
    die("Chyba připojení: " . htmlspecialchars($e->getMessage()));
}

$stmt = $pdo->query("SELECT id, name, email FROM students ORDER BY id DESC");

$rows = $stmt->fetchAll();
?>
<!doctype html>
<html lang="cs">
<head>
  <meta charset="utf-8">
  <title>PDO úkol</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f6f7fb; padding:24px; }
    .wrap { max-width: 900px; margin: 0 auto; }
    table { width:100%; border-collapse: collapse; background:#fff; border-radius:10px; overflow:hidden; }
    th, td { padding:12px 14px; border-bottom:1px solid #eee; text-align:left; }
    th { background:#111827; color:#fff; }
    tr:hover td { background:#f9fafb; }
  </style>
</head>
<body>
<div class="wrap">
  <h1>Výpis z DB (PDO)</h1>

  <?php if (count($rows) === 0): ?>
    <p>Žádná data v tabulce.</p>
  <?php else: ?>
    <table>
      <thead><tr><th>ID</th><th>Jméno</th><th>Email</th></tr></thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r->id) ?></td>
            <td><?= htmlspecialchars($r->name) ?></td>
            <td><?= htmlspecialchars($r->email) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
</body>
</html>