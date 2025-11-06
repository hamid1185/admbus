<?php
require_once __DIR__ . '/config/config.php';

// Create database if it doesn't exist
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if database exists
$result = $conn->query("SHOW DATABASES LIKE '" . DB_NAME . "'");
if ($result->num_rows == 0) {
    echo "Creating database " . DB_NAME . "...\n";
    if ($conn->query("CREATE DATABASE " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
        echo "Database created successfully!\n";
    } else {
        die("Error creating database: " . $conn->error);
    }
} else {
    echo "Database " . DB_NAME . " already exists.\n";
}

$conn->close();

// Now execute the schema
require_once __DIR__ . '/config/database.php';
$db = Database::getInstance();

// Read and execute schema file
$schema = file_get_contents(__DIR__ . '/database/schema.sql');
$statements = explode(';', $schema);

echo "Setting up database tables...\n";

foreach ($statements as $statement) {
    $statement = trim($statement);
    if (empty($statement) || strpos($statement, '--') === 0) {
        continue;
    }

    // Skip USE and DROP DATABASE statements
    if (stripos($statement, 'USE ') === 0 || stripos($statement, 'DROP DATABASE') === 0 || stripos($statement, 'CREATE DATABASE') === 0) {
        continue;
    }

    try {
        $db->getConnection()->query($statement);
    } catch (Exception $e) {
        echo "Warning: " . $e->getMessage() . "\n";
    }
}

// Create default admin user
$admin_password = 'admin123';
$hashed_password = Security::hashPassword($admin_password);

$check = $db->query("SELECT id FROM admin_users WHERE username = 'admin'");
if ($check->get_result()->num_rows == 0) {
    $db->query(
        "INSERT INTO admin_users (username, email, password_hash, role, full_name, is_active) VALUES (?, ?, ?, ?, ?, ?)",
        ['admin', 'admin@admissionbus.com', $hashed_password, 'super_admin', 'System Admin', 1]
    );
    echo "\nDefault admin user created!\n";
    echo "Username: admin\n";
    echo "Password: admin123\n";
    echo "\nPlease change the password after first login!\n";
} else {
    echo "\nAdmin user already exists.\n";
}

echo "\nDatabase setup completed successfully!\n";
echo "You can now access the application.\n";
?>
