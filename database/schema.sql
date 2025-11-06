-- Admission Bus Database Schema
DROP DATABASE IF EXISTS admission_bus;
CREATE DATABASE admission_bus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE admission_bus;

-- Universities Table
CREATE TABLE universities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    english_name VARCHAR(100),
    division VARCHAR(50) NOT NULL,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_university (name, division),
    INDEX idx_division (division)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Routes Table
CREATE TABLE routes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    university_id INT NOT NULL,
    departure_point VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    total_seats INT DEFAULT 50,
    available_seats INT DEFAULT 50,
    departure_time TIME,
    arrival_time TIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (university_id) REFERENCES universities(id) ON DELETE CASCADE,
    INDEX idx_available_seats (available_seats),
    INDEX idx_university (university_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20) UNIQUE NOT NULL,
    nid VARCHAR(20) UNIQUE NOT NULL,
    password_hash VARCHAR(255),
    is_verified TINYINT DEFAULT 0,
    verification_token VARCHAR(255),
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_phone (phone),
    INDEX idx_nid (nid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bookings Table
CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    invoice_number VARCHAR(50) UNIQUE NOT NULL,
    user_id INT,
    route_id INT NOT NULL,
    num_seats INT NOT NULL DEFAULT 1,
    journey_date DATE NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    processing_fee DECIMAL(10, 2) DEFAULT 50.00,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    payment_status ENUM('pending', 'success', 'failed') DEFAULT 'pending',
    payment_method VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (route_id) REFERENCES routes(id),
    INDEX idx_invoice (invoice_number),
    INDEX idx_user (user_id),
    INDEX idx_status (status),
    INDEX idx_journey_date (journey_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Payments Table
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    booking_id INT NOT NULL,
    transaction_id VARCHAR(100),
    amount DECIMAL(10, 2) NOT NULL,
    method VARCHAR(50) NOT NULL,
    gateway_response VARCHAR(50),
    status ENUM('pending', 'success', 'failed', 'refunded') DEFAULT 'pending',
    reference_number VARCHAR(100),
    response_data JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_transaction (transaction_id),
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    INDEX idx_transaction (transaction_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin Users Table
CREATE TABLE admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('super_admin', 'admin', 'operator') DEFAULT 'admin',
    full_name VARCHAR(100),
    is_active TINYINT DEFAULT 1,
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- System Logs Table
CREATE TABLE system_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT,
    action VARCHAR(100) NOT NULL,
    entity_type VARCHAR(50),
    entity_id INT,
    details JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admin_users(id) ON DELETE SET NULL,
    INDEX idx_admin (admin_id),
    INDEX idx_created (created_at),
    INDEX idx_action (action)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Settings Table
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value LONGTEXT,
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Universities Data
INSERT INTO universities (name, english_name, division, address) VALUES
('ঢাকা বিশ্ববিদ্যালয়', 'Dhaka University', 'ঢাকা', 'ঢাকা, বাংলাদেশ'),
('বাংলাদেশ প্রকৌশল বিশ্ববিদ্যালয়', 'BUET', 'ঢাকা', 'ঢাকা, বাংলাদেশ'),
('জাহাঙ্গীরনগর বিশ্ববিদ্যালয়', 'Jahangirnagar University', 'ঢাকা', 'সাভার, ঢাকা'),
('চট্টগ্রাম বিশ্ববিদ্যালয়', 'Chittagong University', 'চট্টগ্রাম', 'চট্টগ্রাম, বাংলাদেশ'),
('খুলনা বিশ্ববিদ্যালয়', 'Khulna University', 'খুলনা', 'খুলনা, বাংলাদেশ'),
('রাজশাহী বিশ্ববিদ্যালয়', 'Rajshahi University', 'রাজশাহী', 'রাজশাহী, বাংলাদেশ'),
('শাহজালাল বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়', 'SUST', 'সিলেট', 'সিলেট, বাংলাদেশ'),
('বঙ্গবন্ধু শেখ মুজিবুর রহমান বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়', 'BSMRSTU', 'পটুয়াখালী', 'পটুয়াখালী, বাংলাদেশ');

-- Insert Routes Data
INSERT INTO routes (university_id, departure_point, destination, price, total_seats, available_seats, departure_time, arrival_time) VALUES
(1, 'ঢাকা এক্সপ্রেস টার্মিনাল', 'ঢাকা বিশ্ববিদ্যালয়', 250.00, 50, 45, '06:00:00', '07:30:00'),
(2, 'ঢাকা এক্সপ্রেস টার্মিনাল', 'BUET', 250.00, 45, 30, '06:30:00', '08:00:00'),
(3, 'ঢাকা এক্সপ্রেস টার্মিনাল', 'জাহাঙ্গীরনগর বিশ্ববিদ্যালয়', 200.00, 40, 25, '05:30:00', '07:00:00'),
(4, 'ঢাকা এক্সপ্রেস টার্মিনাল', 'চট্টগ্রাম বিশ্ববিদ্যালয়', 400.00, 50, 40, '23:00:00', '05:00:00'),
(5, 'ঢাকা এক্সপ্রেস টার্মিনাল', 'খুলনা বিশ্ববিদ্যালয়', 350.00, 45, 20, '08:00:00', '14:00:00'),
(6, 'ঢাকা এক্সপ্রেস টার্মিনাল', 'রাজশাহী বিশ্ববিদ্যালয়', 300.00, 50, 35, '07:00:00', '13:00:00'),
(7, 'ঢাকা এক্সপ্রেস টার্মিনাল', 'শাহজালাল বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়', 450.00, 40, 15, '22:00:00', '06:00:00'),
(8, 'ঢাকা এক্সপ্রেস টার্মিনাল', 'বঙ্গবন্ধু শেখ মুজিবুর রহমান বিজ্ঞান ও প্রযুক্তি বিশ্ববিদ্যালয়', 500.00, 35, 20, '23:30:00', '07:30:00');

-- Insert Admin User
INSERT INTO admin_users (username, email, password_hash, role, full_name, is_active) VALUES
('admin', 'admin@admissionbus.com', '$2y$12$abc123defghijklmnopqrstuvwxyz123456', 'super_admin', 'সিস্টেম অ্যাডমিন', 1),
('operator', 'operator@admissionbus.com', '$2y$12$abc123defghijklmnopqrstuvwxyz123456', 'operator', 'অপারেটর', 1);

-- Insert Settings
INSERT INTO settings (setting_key, setting_value, description) VALUES
('site_name', 'এডমিশন বাস', 'সাইটের নাম'),
('support_email', 'support@admissionbus.com', 'সাপোর্ট ইমেইল'),
('support_phone', '01700000000', 'সাপোর্ট ফোন নম্বর'),
('bkash_enabled', '1', 'bKash পেমেন্ট সক্ষম'),
('nagad_enabled', '1', 'Nagad পেমেন্ট সক্ষম'),
('min_booking_time', '3', 'ক্যান্সেলেশনের জন্য কমপক্ষে ঘন্টা');
