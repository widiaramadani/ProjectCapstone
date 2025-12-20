<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="flex">

    <!-- SIDEBAR (tetap / fixed) -->
    <aside class="w-64 h-screen bg-white shadow-md fixed left-0 top-0 overflow-y-auto">
        <div class="p-6 border-b">
            <h1 class="text-xl font-bold text-gray-700">
                Halo Admin Ganteng
            </h1>
        </div>

        <ul class="p-4 space-y-2">

            <li>
                <a href="{{ route('admin.dashboardadmin') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-100 text-gray-700">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('admin.produkadmin') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-100 text-gray-700">
                    Produk
                </a>
            </li>

            <li>
                <a href="{{ route('admin.transaksiadmin') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-100 text-gray-700">
                    Transaksi
                </a>
            </li>

            <li>
                <a href="{{ route('admin.laporanadmin') }}"
                    class="block px-4 py-2 rounded hover:bg-gray-100 text-gray-700">
                    Laporan
                </a>
            </li>

            <li>
                <a href="{{ route('admin.logout') }}"
                    class="block px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600 text-center">
                    Logout
                </a>
            </li>

        </ul>
    </aside>


    <!-- MAIN CONTENT -->
    <!-- Tambah margin-left agar tidak ketimpa sidebar -->
    <main class="flex-1 ml-64 p-6 overflow-y-auto h-screen">
        @yield('content')
    </main>

</body>

</html>
