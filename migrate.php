<?php
$config = require __DIR__ . '/config/database.php';

$host = $config['host'];
$port = $config['port'];
$user = $config['user'];
$password = $config['password'];
$dbname = $config['dbname'];

echo "Connecting to PostgreSQL to create database...\n";

try {
    // Connect to the default 'postgres' database first to create the new one
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=postgres", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if database exists
    $stmt = $pdo->query("SELECT 1 FROM pg_database WHERE datname = '$dbname'");
    if (!$stmt->fetch()) {
        $pdo->exec("CREATE DATABASE $dbname");
        echo "Database '$dbname' created successfully.\n";
    } else {
        echo "Database '$dbname' already exists.\n";
    }
} catch (PDOException $e) {
    echo "Warning: Could not connect to default database to create it. " . $e->getMessage() . "\n";
    echo "If the database 'benhub' already exists, this is fine. Continuing...\n";
}

echo "Connecting to '$dbname' to run schema...\n";

try {
    // Now connect to the actual database
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Read and execute the SQL file
    $sql = file_get_contents(__DIR__ . '/benhub_postgres.sql');
    
    // We can just execute the whole block
    $pdo->exec($sql);
    echo "Schema imported successfully.\n";

    // Set the specific admin credentials requested by the user
    // First clear existing admin data
    $pdo->exec("TRUNCATE TABLE admin_info");
    
    // Insert new admin
    $stmt = $pdo->prepare("INSERT INTO admin_info (ad_username, ad_password, ad_name) VALUES (:user, :pass, :name)");
    $stmt->execute([
        ':user' => 'admin',
        ':pass' => password_hash('admin123', PASSWORD_DEFAULT),
        ':name' => 'Administrator'
    ]);
    
    echo "Admin credentials (admin / admin123) successfully set!\n";
    echo "\nMigration complete! You can now log in at http://localhost:8000/admin/login\n";
    
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage() . "\nMake sure your credentials in config/database.php are correct and PostgreSQL is running.");
}
