<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Business Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #06b6d4;
            --primary-light: #0ea5e9;
            --dark: #0f172a;
            --darker: #020617;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, var(--darker), var(--dark));
            background-size: 400% 400%;
            animation: gradientFlow 12s ease infinite;
            color: white;
            min-height: 100vh;
        }

        @keyframes gradientFlow {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Glass effect */
        .glass {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-left: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Logo styles */
        .logo-main {
            font-size: 3.5rem;
            font-weight: 900;
            color: #06b6d4;
            text-shadow: 0 0 15px rgba(6, 182, 212, 0.7);
            letter-spacing: -1px;
            margin-bottom: 0.5rem;
            display: inline-block;
        }

        /* Form inputs */
        input[type="email"],
        input[type="password"] {
            transition: all 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.3);
        }

        /* Add other common styles from your welcome page here */
    </style>
</head>

<body>
    <div class="min-h-screen">
        @include('partials.navigation')

        <main class="container mx-auto py-6 px-4">
            @yield('content')
        </main>
    </div>

    @include('partials.footer')
</body>

</html>