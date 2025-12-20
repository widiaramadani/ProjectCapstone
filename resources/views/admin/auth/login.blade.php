<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<!-- Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<script>
tailwind.config = {
  theme: {
    extend: {
      fontFamily: {
        inter: ['Inter', 'sans-serif'],
      },
      animation: {
        gradient: "gradient 10s ease infinite",
        fadeSlide: "fadeSlide .9s ease-out",
        glow: "glow 3s ease-in-out infinite",
      },
      keyframes: {
        gradient: {
          "0%, 100%": { backgroundPosition: "0% 50%" },
          "50%": { backgroundPosition: "100% 50%" },
        },
        fadeSlide: {
          "0%": { opacity: 0, transform: "translateY(40px) scale(.95)" },
          "100%": { opacity: 1, transform: "translateY(0) scale(1)" },
        },
        glow: {
          "0%, 100%": { boxShadow: "0 0 20px rgba(99,102,241,.35)" },
          "50%": { boxShadow: "0 0 35px rgba(168,85,247,.55)" },
        },
      },
    }
  }
}
</script>
</head>

<body class="font-inter min-h-screen flex items-center justify-center
bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900
bg-[length:400%_400%] animate-gradient relative overflow-hidden">

<!-- Decorative Blur -->
<div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-500/30 rounded-full blur-3xl"></div>
<div class="absolute -bottom-32 -right-32 w-96 h-96 bg-purple-500/30 rounded-full blur-3xl"></div>

<!-- Login Card -->
<div class="relative w-full max-w-md bg-white/10 backdrop-blur-2xl
border border-white/15 rounded-3xl shadow-2xl p-8 animate-fadeSlide">

    <!-- Header -->
    <div class="text-center mb-8">
        <div class="mx-auto mb-4 w-16 h-16 flex items-center justify-center
            rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600
            text-white text-2xl animate-glow">
            <i class="fa-solid fa-lock"></i>
        </div>

        <h2 class="text-2xl font-bold text-white">
            Admin Panel
        </h2>
        <p class="text-gray-300 text-sm mt-1">
            Silakan login untuk melanjutkan
        </p>
    </div>

    <!-- Error -->
    @if(session('status'))
    <div class="bg-red-500/20 border border-red-500/40 text-red-200
        px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-exclamation"></i>
        {{ session('status') }}
    </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('admin.login.store') }}" id="loginForm" class="space-y-5">
        @csrf

        <!-- Email -->
        <div class="relative">
            <input type="email" name="email" required autofocus
                class="peer w-full px-4 py-3 rounded-xl bg-white/20 text-white
                placeholder-transparent outline-none
                focus:ring-2 focus:ring-indigo-400/60 transition">

            <label class="absolute left-4 top-3 text-gray-300 text-sm
                peer-placeholder-shown:top-3.5
                peer-placeholder-shown:text-base
                peer-placeholder-shown:text-gray-400
                peer-focus:top-1 peer-focus:text-xs peer-focus:text-indigo-300 transition-all">
                Email
            </label>
        </div>

        <!-- Password -->
        <div class="relative">
            <input type="password" name="password" id="password" required
                class="peer w-full px-4 py-3 pr-12 rounded-xl bg-white/20 text-white
                placeholder-transparent outline-none
                focus:ring-2 focus:ring-indigo-400/60 transition">

            <label class="absolute left-4 top-3 text-gray-300 text-sm
                peer-placeholder-shown:top-3.5
                peer-placeholder-shown:text-base
                peer-placeholder-shown:text-gray-400
                peer-focus:top-1 peer-focus:text-xs peer-focus:text-indigo-300 transition-all">
                Password
            </label>

            <!-- Toggle Password -->
            <button type="button" onclick="togglePassword()"
                class="absolute right-4 top-3 text-gray-300 hover:text-white transition">
                <i class="fa-solid fa-eye" id="eyeIcon"></i>
            </button>
        </div>

        <!-- Button -->
        <button type="submit"
            class="w-full flex items-center justify-center gap-2
            bg-gradient-to-r from-indigo-500 to-purple-600
            text-white font-semibold py-3 rounded-xl
            hover:scale-[1.02] hover:shadow-xl
            active:scale-95 transition-all">

            <svg id="loadingSpinner" class="hidden animate-spin h-5 w-5 text-white"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8v4l3-3-3-3v4a12 12 0 00-12 12h4z"></path>
            </svg>

            <span id="loginText">Login</span>
        </button>
    </form>

    <!-- Footer -->
    <p class="text-center text-xs text-gray-300 mt-8">
        © {{ date('Y') }} Admin Dashboard
    </p>
</div>

<!-- Script -->
<script>
function togglePassword() {
    const pass = document.getElementById('password');
    const eye = document.getElementById('eyeIcon');
    if (pass.type === "password") {
        pass.type = "text";
        eye.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        pass.type = "password";
        eye.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

document.getElementById('loginForm').addEventListener('submit', function () {
    document.getElementById('loadingSpinner').classList.remove('hidden');
    document.getElementById('loginText').textContent = "Memproses...";
});
</script>

</body>
</html>
