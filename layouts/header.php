<?php
// Header/Navigation Layout - English code, Bengali UI text only
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admission Bus - Safe and easy way to reach admission exam centers">
    <meta name="keywords" content="admission, bus, ticket, booking, university, Bangladesh">
    <meta name="theme-color" content="#00A651">
    <title><?php echo isset($page_title) ? $page_title . ' - Admission Bus' : 'Admission Bus | Online Bus Ticket Booking'; ?></title>
    
    <!-- Fixed asset paths to not include SITE_URL -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 no-underline">
                    <div class="bg-green-600 text-white p-2 rounded-lg font-bold text-xl">AB</div>
                    <div>
                        <h1 class="text-gray-900 font-bold text-lg">Admission Bus</h1>
                        <p class="text-gray-500 text-xs">Safe Journey to Dreams</p>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex gap-8 items-center">
                    <a href="/?page=home" class="text-gray-700 hover:text-green-600 font-medium transition">বাড়ি</a>
                    <a href="/?page=gallery" class="text-gray-700 hover:text-green-600 font-medium transition">গ্যালারি</a>
                    <a href="/?page=blog" class="text-gray-700 hover:text-green-600 font-medium transition">ব্লগ</a>
                    <a href="/?page=conditions" class="text-gray-700 hover:text-green-600 font-medium transition">শর্তাবলী</a>
                    <a href="/?page=find-invoice" class="text-gray-700 hover:text-green-600 font-medium transition">ইনভয়েস খুঁজুন</a>
                </nav>

                <!-- Admin Login Button -->
                <a href="/admin/login.php" class="hidden md:inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                    Admin Login
                </a>

                <!-- Mobile Menu Toggle -->
                <button id="menuToggle" class="md:hidden text-gray-700 text-3xl">☰</button>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 border-t">
                <a href="/?page=home" class="block py-2 text-gray-700 hover:text-green-600">বাড়ি</a>
                <a href="/?page=gallery" class="block py-2 text-gray-700 hover:text-green-600">গ্যালারি</a>
                <a href="/?page=blog" class="block py-2 text-gray-700 hover:text-green-600">ব্লগ</a>
                <a href="/?page=conditions" class="block py-2 text-gray-700 hover:text-green-600">শর্তাবলী</a>
                <a href="/?page=find-invoice" class="block py-2 text-gray-700 hover:text-green-600">ইনভয়েস খুঁজুন</a>
                <a href="/admin/login.php" class="block mt-4 bg-green-600 text-white px-4 py-2 rounded-lg font-semibold text-center">Admin Login</a>
            </div>
        </div>
    </header>

    <script>
        document.getElementById('menuToggle')?.addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobileMenu').classList.add('hidden');
            });
        });
    </script>
