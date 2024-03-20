<?php
// Database configuration
$dbHost = getenv('DB_HOST');
$dbName = getenv('DB_NAME');
$dbUsername = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');


// Try to connect to the database
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the app_status table exists and has been initialized
    $stmt = $pdo->query("SELECT status FROM {$dbName}.app_status LIMIT 1");
    $result = $stmt->fetchColumn();

    if ($result === false) {
        // The table is empty, which means initialization hasn't completed
        http_response_code(500);
        echo 'Application not ready: app_status table is empty';
    } else {
        // The table has data, so the application is considered initialized and ready
        http_response_code(200);
        echo 'Application is live and ready';
    }
} catch (PDOException $e) {
    // Could not connect to the database or query failed
    http_response_code(500);
    echo 'Liveness or readiness check failed: ' . $e->getMessage();
}
