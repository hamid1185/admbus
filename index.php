<?php
// Main Entry Point - Admission Bus Platform

// Load configuration and includes (require_once prevents duplicate loading)
require_once __DIR__ . '/config/config.php';
require_once BASE_PATH . 'config/database.php';
require_once BASE_PATH . 'includes/security.php';
require_once BASE_PATH . 'includes/helpers.php';

try {
    // Initialize database connection
    $db = Database::getInstance();
    
    // Get current page from query parameter
    $page = isset($_GET['page']) ? Security::sanitize($_GET['page']) : 'home';
    
    // List of valid pages
    $valid_pages = [
        'home', 'routes', 'booking', 'payment', 
        'confirmation', 'find-invoice', 'conditions', 
        'gallery', 'blog', 'contact'
    ];
    
    // Validate and set page
    if (!in_array($page, $valid_pages)) {
        $page = 'home';
    }
    
    // Page titles - English in code, Bengali only displayed in UI
    $page_titles = [
        'home' => 'Admission Bus - Book Your Tickets',
        'routes' => 'Select Route',
        'booking' => 'Book Ticket',
        'payment' => 'Payment',
        'confirmation' => 'Booking Confirmation',
        'find-invoice' => 'Find Invoice',
        'conditions' => 'Terms and Conditions',
        'gallery' => 'Gallery',
        'blog' => 'Blog',
        'contact' => 'Contact Us'
    ];
    
    $page_title = $page_titles[$page] ?? 'Admission Bus';
    
    // Load and include the page file
    $page_file = BASE_PATH . 'app/pages/' . $page . '.php';
    
    if (file_exists($page_file)) {
        include $page_file;
    } else {
        error_log("Page file not found: " . $page_file);
        include BASE_PATH . 'app/pages/home.php';
    }
    
} catch (Exception $e) {
    error_log("Application Error: " . $e->getMessage());
    if (DEVELOPMENT_MODE) {
        echo "<h2>Application Error</h2>";
        echo "<p>" . $e->getMessage() . "</p>";
        echo "<p><pre>" . $e->getTraceAsString() . "</pre></p>";
    } else {
        echo "<h2>An error occurred</h2>";
        echo "<p>Please try again later.</p>";
    }
}
?>
