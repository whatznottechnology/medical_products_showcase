<?php
function getHeader($title = "ZEGNEN.COM - Healthcare Excellence, Hello ZEGNEN") {
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'yellow': {
                            300: '#fff3a0',
                            400: '#ffcc09',
                            500: '#ffcc09',
                            600: '#e6b008',
                            700: '#cc9c07',
                            800: '#b38806',
                            900: '#997505'
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-background {
            background-image: url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        .hero-overlay {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.1) 100%);
        }
        .typing-animation {
            border-right: 2px solid #ffcc09;
            animation: blink 0.8s infinite;
        }
        @keyframes blink {
            0%, 50% { border-right-color: #ffcc09; }
            51%, 100% { border-right-color: transparent; }
        }
    </style>
</head>
<body class="overflow-x-hidden hero-background">
<?php
    return ob_get_clean();
}
?>