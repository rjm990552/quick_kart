<?php
// quick_kart/common/bottom.php

// Calculate cart item count (simple count of unique product IDs)
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$is_logged_in = isset($_SESSION['user_id']);

// Get current page to highlight active icon
$current_page = basename($_SERVER['PHP_SELF']);

?>
</main>

<footer class="fixed bottom-0 left-0 right-0 z-30 bg-white border-t border-gray-200 shadow-xl h-16">
    <nav class="flex justify-around items-center h-full max-w-lg mx-auto">
        
        <a href="index.php" class="flex flex-col items-center justify-center p-2 text-center w-full transition-colors duration-200 
            <?php echo $current_page === 'index.php' ? 'text-emerald-600' : 'text-gray-500 hover:text-emerald-600'; ?>">
            <i class="fas fa-home text-xl mb-1"></i>
            <span class="text-xs font-medium">Home</span>
        </a>

        <a href="order.php" class="flex flex-col items-center justify-center p-2 text-center w-full transition-colors duration-200 
            <?php echo $current_page === 'order.php' ? 'text-emerald-600' : 'text-gray-500 hover:text-emerald-600'; ?>">
            <i class="fas fa-box-open text-xl mb-1"></i>
            <span class="text-xs font-medium">Orders</span>
        </a>

        <a href="cart.php" class="relative flex flex-col items-center justify-center p-2 text-center w-full transition-colors duration-200 
            <?php echo $current_page === 'cart.php' ? 'text-emerald-600' : 'text-gray-500 hover:text-emerald-600'; ?>">
            <i class="fas fa-shopping-cart text-xl mb-1"></i>
            <span class="text-xs font-medium">Cart</span>
            <?php if ($cart_count > 0): ?>
                <span class="absolute top-0 right-6 bg-red-600 text-white text-xs font-bold w-4 h-4 flex items-center justify-center rounded-full border border-white"><?php echo $cart_count; ?></span>
            <?php endif; ?>
        </a>

        <a href="profile.php" class="flex flex-col items-center justify-center p-2 text-center w-full transition-colors duration-200 
            <?php echo $current_page === 'profile.php' ? 'text-emerald-600' : 'text-gray-500 hover:text-emerald-600'; ?>">
            <i class="fas fa-user-circle text-xl mb-1"></i>
            <span class="text-xs font-medium"><?php echo $is_logged_in ? 'Profile' : 'Account'; ?></span>
        </a>
        
    </nav>
</footer>

</body>
</html>