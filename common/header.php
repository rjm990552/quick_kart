<?php
// quick_kart/common/header.php

// Ensure session is started and access global search term if available
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$search_term = $_GET['search'] ?? ''; 
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="hi" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Quick Kart | स्वास्थ्य पहला, खुशी पहली</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600&family=Poppins:wght@300;400;600&display=swap');
        
        body { 
            -webkit-user-select: none; user-select: none;
            touch-action: manipulation;
            overflow-x: hidden;
            background-color: #f9fafb;
            font-family: 'Poppins', sans-serif;
        }
        
        .hindi-font { font-family: 'Hind Siliguri', 'Noto Sans Devanagari', sans-serif; }
        
        main { padding-top: 100px; padding-bottom: 64px; }
        .h-full-screen { min-height: 100vh; }
        
        @media (max-width: 639px) { main { padding-top: 140px; } }
        
        .blissful-header {
            background: linear-gradient(135deg, rgba(240, 253, 244, 0.98) 0%, rgba(220, 252, 231, 0.95) 50%, rgba(187, 247, 208, 0.92) 100%);
            height: 100px;
            position: relative;
            overflow: hidden;
            border-bottom: 3px solid transparent;
            border-image: linear-gradient(90deg, #10b981, #34d399, #10b981) 1;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.15);
        }

        /* SPINNING ANIMATION FOR THE MAIN LEAF */
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-leaf {
            animation: spin-slow 8s linear infinite;
            display: inline-block;
        }
        
        .floating-leaves {
            position: absolute; width: 100%; height: 100%; top: 0; left: 0; pointer-events: none; opacity: 0.4;
        }
        
        .leaf {
            position: absolute; width: 24px; height: 24px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2310b981'%3E%3Cpath d='M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l.71-1.78C8.82 17.5 11.92 15 17 15c.9 0 1.78.07 2.65.2l1.8-1.8C19.24 8.4 17.74 8 17 8z'/%3E%3Cpath fill='none' d='M0 0h24v24H0z'/%3E%3C/svg%3E") no-repeat center;
            animation: float 20s infinite linear;
        }
        
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); opacity: 0; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }
        
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .heartbeat-text { animation: heartbeat 3s ease-in-out infinite; }
        
        .wisdom-card {
            position: absolute; top: 100%; left: 50%; transform: translateX(-50%);
            width: 280px; background: white; border-radius: 16px; padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); z-index: 1000;
            opacity: 0; visibility: hidden; transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border-top: 5px solid #10b981;
        }
        
        .wisdom-card.show { opacity: 1; visibility: visible; top: calc(100% + 15px); }
        
        .glowing-search {
            background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
            border-radius: 50px; padding: 6px 25px; box-shadow: 0 5px 15px rgba(16, 185, 129, 0.2);
        }
    </style>
</head>
<body class="h-full-screen overflow-x-hidden select-none">

    <header class="fixed top-0 left-0 right-0 z-40 blissful-header p-4">
        <div class="floating-leaves" id="floatingLeaves"></div>
        
        <div class="flex items-center justify-between h-full relative z-10">
            
            <div class="flex items-start relative">
                <button id="sidebar-toggle" class="text-emerald-700 hover:text-emerald-800 transition duration-300 mr-3">
                    <i class="fas fa-seedling text-2xl animate-spin-leaf"></i>
                </button>
                
                <div class="cursor-pointer" id="wisdomTrigger">
                    <div class="text-2xl font-bold text-emerald-800 tracking-tight">Quick Kart</div>
                    <div class="mt-[-4px]">
                        <div class="heartbeat-text hindi-font text-lg text-amber-800 font-semibold italic leading-tight">
                            पहला सुख निरोगी काया
                        </div>
                        <div class="text-[11px] text-gray-600 mt-[4px] flex items-center absolute left-0 whitespace-nowrap">
                            <i class="fas fa-hand-point-up text-emerald-500 animate-bounce mr-2"></i>
                            <span>Tap to discover wisdom</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex-grow max-w-[350px] mx-4 hidden sm:block">
                <div class="glowing-search">
                    <form action="product.php" method="GET" class="flex items-center">
                        <i class="fas fa-search text-emerald-500 mr-3"></i>
                        <input type="search" name="search" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Search fresh vegetables..." class="w-full bg-transparent border-none focus:ring-0 focus:outline-none">
                    </form>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="cart.php" class="relative">
                        <div class="bg-white p-3 rounded-full shadow-lg">
                            <i class="fas fa-shopping-basket text-2xl text-emerald-600"></i>
                            <?php if ($cart_count > 0): ?>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full border-2 border-white shadow-lg">
                                    <?php echo $cart_count; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php else: ?>
                    <a href="login.php" class="text-sm font-semibold bg-emerald-500 text-white px-5 py-2.5 rounded-full shadow-lg">Begin Wellness</a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="wisdom-card" id="wisdomCard">
            <div class="text-center">
                <div class="text-emerald-600 text-4xl mb-3"><i class="fas fa-heart-circle-check"></i></div>
                <h3 class="text-xl font-bold text-gray-800 mb-2 hindi-font">पहला सुख निरोगी काया</h3>
                <p class="text-gray-600 mb-4">"The first happiness is a disease-free body."</p>
                <button id="closeWisdom" class="mt-4 text-sm text-emerald-600"><i class="fas fa-times mr-1"></i> Close</button>
            </div>
        </div>
    </header>

    <script>
        // Floating background leaves
        function createLeaves() {
            const container = document.getElementById('floatingLeaves');
            for(let i = 0; i < 15; i++) {
                const leaf = document.createElement('div');
                leaf.className = 'leaf';
                leaf.style.left = Math.random() * 100 + '%';
                leaf.style.animationDelay = Math.random() * 20 + 's';
                container.appendChild(leaf);
            }
        }
        
        const wisdomTrigger = document.getElementById('wisdomTrigger');
        const wisdomCard = document.getElementById('wisdomCard');
        const closeWisdom = document.getElementById('closeWisdom');
        
        wisdomTrigger.addEventListener('click', () => wisdomCard.classList.add('show'));
        closeWisdom.addEventListener('click', () => wisdomCard.classList.remove('show'));
        
        document.addEventListener('DOMContentLoaded', createLeaves);
    </script>

    <?php include('sidebar.php'); ?>
    <main class="h-full-screen overflow-y-auto">