<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'aqua': '#00D4FF',
                        'adminbg': '#0e2e36',
                        'adminsidebar': '#1e4d56',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen flex">
    <!-- Sidebar Modern -->
    <x-admin-sidebar />
    <!-- Main Content -->
    <main class="flex-1 min-h-screen p-8">
        @yield('content')
    </main>
</body>
</html> 