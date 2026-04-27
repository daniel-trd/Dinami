<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">

    <div class="min-h-screen flex items-center justify-center">

        <div class="w-full max-w-md">

            <!-- Logo -->
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-emerald-500">Dinami</h1>
                <p class="text-gray-500 text-sm">Acesse sua conta</p>
            </div>

            <!-- Card -->
            <div class="bg-white p-8 rounded-2xl shadow">

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Email</label>
                        <input type="email" name="email"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-400 focus:outline-none"
                            placeholder="seu@email.com">
                    </div>

                    <!-- Senha -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Senha</label>
                        <input type="password" name="password"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-400 focus:outline-none"
                            placeholder="••••••••">
                    </div>

                    <!-- Lembrar -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="rounded">
                            Lembrar-me
                        </label>

                        <a href="#" class="text-emerald-500 hover:underline">
                            Esqueceu a senha?
                        </a>
                    </div>

                    <!-- Botão -->
                    <button
                        class="w-full bg-emerald-500 text-white py-2 rounded-lg hover:bg-emerald-600 transition font-semibold">
                        Entrar
                    </button>

                </form>

            </div>

        </div>

    </div>

</body>

</html>