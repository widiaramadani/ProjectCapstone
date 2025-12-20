<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>@yield('title','Admin Dashboard')</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<!-- Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<script>
tailwind.config = {
  theme: {
    extend: {
      fontFamily: {
        inter: ['Inter', 'sans-serif'],
      }
    }
  }
}
</script>
</head>

<body class="font-inter min-h-screen
bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900 text-white">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white/10 backdrop-blur-xl border-r border-white/10 p-6">
        <h1 class="text-2xl font-bold mb-10 text-indigo-300">
            🍪 Admin Nopia
        </h1>

        <nav class="flex flex-col gap-2 text-sm">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl
               hover:bg-indigo-500/20 transition">
                <i class="fa-solid fa-gauge"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl
               hover:bg-indigo-500/20 transition">
                <i class="fa-solid fa-cart-shopping"></i>
                Pembelian
            </a>

            <a href="{{ route('admin.inbox.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
            hover:bg-indigo-500/20 transition">
                <i class="fa-solid fa-inbox"></i>
                Inbox
            </a>


            <a href="{{ route('admin.reports') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl
               hover:bg-indigo-500/20 transition">
                <i class="fa-solid fa-file-lines"></i>
                Laporan
            </a>

            <!-- Divider -->
            <hr class="my-6 border-white/10">

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                    bg-red-500/20 text-red-300
                    hover:bg-red-500 hover:text-white transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>

        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">

        <!-- Page Header -->
        <div class="mb-6">
            <h2 class="text-3xl font-semibold">
                @yield('page-title')
            </h2>
            <p class="text-sm text-gray-300 mt-1">
                Selamat datang di Admin Dashboard
            </p>
        </div>

        <!-- Content Card -->
        <div class="bg-white/10 backdrop-blur-xl border border-white/10
            rounded-2xl p-6 shadow-xl">
            @yield('content')
        </div>

    </main>

</div>

</body>
</html>
