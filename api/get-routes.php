<?php
define('BASE_PATH', dirname(dirname(__FILE__)) . '/');
require_once BASE_PATH . 'config/config.php';
require_once BASE_PATH . 'config/database.php';
require_once BASE_PATH . 'includes/helpers.php';

header('Content-Type: application/json');

try {
    $division = isset($_GET['division']) ? htmlspecialchars($_GET['division']) : '';
    
    $db = Database::getInstance();
    $query = "SELECT r.*, u.name as university_name FROM routes r JOIN universities u ON r.university_id = u.id";
    $params = [];

    if (!empty($division)) {
        $query .= " WHERE u.division = ?";
        $params[] = $division;
    }

    $query .= " ORDER BY u.name";

    $stmt = $db->query($query, $params);
    $routes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $routes
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
