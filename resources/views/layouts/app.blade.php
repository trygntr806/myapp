<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CMS Contact Form</title>
    
    <!-- Correct Tailwind CSS CDN Link -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Optional: Include Alpine.js for interactivity if needed -->
    <!-- <script src="//unpkg.com/alpinejs" defer></script> -->
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="flex-1 container mx-auto p-4">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Scripts -->
    <!-- No need for app.js since we're using CDN for Tailwind -->
</body>
</html>
