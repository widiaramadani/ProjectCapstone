<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 h-screen bg-white shadow-md">
        <div class="p-6 border-b">
            <h1 class="text-xl font-bold">Halo Admin Ganteng</h1>
        </div>

        <ul class="p-4 space-y-2">

            <li>
                <a href="{{ route('admin.dashboardadmin') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('admin.produkadmin') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100">
                    Produk
                </a>
            </li>

            <li>
                <a href="{{ route('admin.transaksiadmin') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100">
                    Transaksi
                </a>
            </li>

            <li>
                <a href="{{ route('admin.laporanadmin') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100">
                    Laporan
                </a>
            </li>

            <li>
                <a href="{{ route('admin.logout') }}"
                   class="block px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">
                    Logout
                </a>
            </li>

        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 overflow-y-auto p-6">
        @yield('content')
    </main>

</body>

</html>
