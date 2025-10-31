<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #FEF3C7 0%, #FEFCE8 100%);
            min-height: 100vh;
        }
        .error-icon {
            font-size: 6rem;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .countdown {
            font-weight: bold;
            color: #1f2937;
            font-size: 1.25rem;
        }
    </style>
</head>
<body>
    <main class="flex items-center justify-center min-h-screen px-4">
        <div class="text-center max-w-md">
            <div class="error-icon mb-6">⚠️</div>
            <h1 class="text-6xl font-bold text-gray-900 mb-2">404</h1>
            <h2 class="text-3xl font-semibold text-gray-800 mb-4">Page Not Found</h2>
            
            <p class="text-lg text-gray-700 mb-4">Sorry, the page you are looking for does not exist or has been moved.</p>
            
            <div class="bg-white bg-opacity-50 p-4 rounded-lg mb-6 border-2 border-yellow-300">
                <p class="text-md text-gray-600">
                    Redirecting to home page in <span id="countdown" class="countdown">5</span> seconds...
                </p>
            </div>
            
            <a href="index.php" class="inline-block px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                ← Go Home Now
            </a>
        </div>
    </main>

    <script>
        let countdown = 5;
        const countdownElement = document.getElementById('countdown');
        const interval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = 'index.php';
            }
        }, 1000);
    </script>
</body>
</html>