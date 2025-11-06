<?php
if (defined('DATABASE_LOADED')) {
    return;
}
define('DATABASE_LOADED', true);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database Connection Class - Singleton Pattern
class Database {
    private $connection;
    private static $instance = null;

    private function __construct() {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($this->connection->connect_error) {
                throw new Exception("Connection Error: " . $this->connection->connect_error);
            }
            
            $this->connection->set_charset("utf8mb4");
            
            // Log successful connection
            error_log("Database connection successful at " . date('Y-m-d H:i:s'));
            
        } catch (Exception $e) {
            error_log("Database Connection Failed: " . $e->getMessage());
            if (DEVELOPMENT_MODE) {
                die("<h2>Database Connection Failed</h2><p>" . $e->getMessage() . "</p><p>Check that database '" . DB_NAME . "' exists and credentials are correct in config/config.php</p>");
            } else {
                die("Database connection error. Please try again later.");
            }
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare Error: " . $this->connection->error);
            }
            
            if (!empty($params)) {
                $types = '';
                foreach ($params as $param) {
                    if (is_int($param)) $types .= 'i';
                    elseif (is_float($param)) $types .= 'd';
                    else $types .= 's';
                }
                $stmt->bind_param($types, ...$params);
            }
            
            if (!$stmt->execute()) {
                throw new Exception("Execute Error: " . $stmt->error);
            }
            
            return $stmt;
        } catch (Exception $e) {
            error_log("Database Query Error: " . $e->getMessage());
            if (DEVELOPMENT_MODE) {
                throw $e;
            }
            return false;
        }
    }

    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
?>
