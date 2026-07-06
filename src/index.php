<?php
$dbHost = getenv('DB_HOST') ?: 'db';
$dbName = getenv('DB_NAME') ?: 'hola_mundo_db';
$dbUser = getenv('DB_USER') ?: 'appuser';
$dbPassword = getenv('DB_PASSWORD') ?: 'apppass';

$message = '';
$status = 'ok';
$visitCount = 0;
$mysqlVersion = '';

try {
    $dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS visitas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            mensaje VARCHAR(100) NOT NULL,
            fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $stmt = $pdo->prepare("INSERT INTO visitas (mensaje) VALUES (:mensaje)");
    $stmt->execute(['mensaje' => 'Hola mundo desde PHP y MySQL']);

    $visitCount = (int) $pdo->query("SELECT COUNT(*) AS total FROM visitas")->fetch()['total'];
    $mysqlVersion = $pdo->query("SELECT VERSION() AS version")->fetch()['version'];
    $message = 'Conexion exitosa a la base de datos MySQL.';
} catch (Throwable $error) {
    $status = 'error';
    $message = 'No se pudo conectar a MySQL: ' . $error->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hola Mundo con MySQL</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #172033;
        }

        main {
            width: min(90%, 640px);
            padding: 32px;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0 12px 35px rgba(25, 35, 60, 0.12);
        }

        h1 {
            margin-top: 0;
            color: #1957c2;
        }

        .badge {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            font-weight: bold;
            background: <?= $status === 'ok' ? '#dff7e8' : '#ffe2e2' ?>;
            color: <?= $status === 'ok' ? '#166534' : '#b42318' ?>;
        }

        .info {
            margin-top: 24px;
            line-height: 1.7;
        }
    </style>
</head>
<body>
    <main>
        <span class="badge"><?= htmlspecialchars(strtoupper($status)) ?></span>
        <h1>Hola mundo desde Docker Compose</h1>
        <p><?= htmlspecialchars($message) ?></p>

        <?php if ($status === 'ok'): ?>
            <div class="info">
                <strong>Base de datos:</strong> <?= htmlspecialchars($dbName) ?><br>
                <strong>Servidor MySQL:</strong> <?= htmlspecialchars($dbHost) ?><br>
                <strong>Version de MySQL:</strong> <?= htmlspecialchars($mysqlVersion) ?><br>
                <strong>Visitas registradas:</strong> <?= $visitCount ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
