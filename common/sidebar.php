<?php
// quick_kart/common/sidebar.php

// Check if included in admin panel (to hide admin links from user side)
$is_admin = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;

// If on user panel, check user session
$is_logged_in = isset($_SESSION['user_id']);

// Fetch ONLY Active Categories WITH Active Products
$categories_query = "
    SELECT 
        c.id, c.name
    FROM 
        categories c
    INNER JOIN 
        products p ON c.id = p.cat_id AND p.is_active = 1
    WHERE 
        c.is_active = 1
    GROUP BY 
        c.id, c.name
    HAVING 
        COUNT(p.id) > 0
    ORDER BY 
        c.name ASC
    LIMIT 8
";
$categories = $conn->query($categories_query);

// Calculate cart count for display
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

?>

<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"></div>

<div id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-white z-50 transform -translate-x-full shadow-2xl transition-transform duration-300 overflow-y-auto">
    
    <div class="p-4 border-b border-gray-100 bg-emerald-600 text-white">
        <h2 class="text-2xl font-bold">Quick Kart</h2>
        <?php if ($is_logged_in): ?>
            <p class="text-sm">Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></p>
        <?php else: ?>
            <p class="text-sm">Guest Mode</p>
        <?php endif; ?>
    </div>

    <nav class="p-4 space-y-2">
        <a href="index.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
            <i class="fas fa-home w-5 text-emerald-500"></i>
            <span>Home</span>
        </a>
        <a href="product.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
            <i class="fas fa-box w-5 text-blue-500"></i>
            <span>All Products</span>
        </a>
        
        <?php if ($categories->num_rows > 0): ?>
            <!-- Collapsible Categories Section -->
            <div class="pt-2 border-t border-gray-100">
                <button id="categories-toggle" class="flex items-center justify-between w-full p-3 rounded-lg text-gray-700 hover:bg-gray-100 font-medium transition-colors">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-tags w-5 text-purple-500"></i>
                        <span>Categories</span>
                    </div>
                    <i id="categories-arrow" class="fas fa-chevron-down text-gray-400 text-sm transition-transform duration-300"></i>
                </button>
                
                <div id="categories-content" class="mt-1 pl-8 space-y-1 hidden transition-all duration-300">
                    <?php while($cat = $categories->fetch_assoc()): ?>
                        <a href="product.php?cat_id=<?php echo $cat['id']; ?>" class="flex items-center space-x-3 p-2 rounded-lg text-gray-600 hover:bg-gray-100 font-medium text-sm transition-colors">
                            <i class="fas fa-tag w-4 text-gray-400"></i>
                            <span class="truncate"><?php echo htmlspecialchars($cat['name']); ?></span>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if ($is_logged_in): ?>
            <div class="pt-2 border-t border-gray-100 space-y-2">
                <a href="order.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
                    <i class="fas fa-shipping-fast w-5 text-purple-500"></i>
                    <span>My Orders</span>
                </a>
                <!-- ADDED: My Cart Menu Item -->
                <a href="cart.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
                    <i class="fas fa-shopping-cart w-5 text-emerald-500"></i>
                    <span class="flex-1">My Cart</span>
                    <?php if ($cart_count > 0): ?>
                        <span class="bg-red-500 text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full"><?php echo $cart_count; ?></span>
                    <?php endif; ?>
                </a>
                <a href="profile.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
                    <i class="fas fa-user-cog w-5 text-orange-500"></i>
                    <span>Profile & Settings</span>
                </a>
            </div>
            <a href="logout.php" class="flex items-center space-x-3 p-3 rounded-lg text-red-600 hover:bg-red-50 font-medium border-t border-gray-100">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span>Logout</span>
            </a>
        <?php else: ?>
            <a href="login.php" class="flex items-center space-x-3 p-3 rounded-lg text-blue-600 hover:bg-blue-50 font-medium border-t border-gray-100">
                <i class="fas fa-sign-in-alt w-5"></i>
                <span>Login / Sign Up</span>
            </a>
        <?php endif; ?>

        <?php if (!$is_admin && isset($_SESSION['admin_logged'])): ?>
            <div class="pt-4 border-t border-gray-100">
                <a href="admin/index.php" class="flex items-center space-x-3 p-3 rounded-lg text-purple-600 hover:bg-purple-50 font-bold">
                    <i class="fas fa-shield-alt w-5"></i>
                    <span>Admin Panel</span>
                </a>
            </div>
        <?php endif; ?>
        
    </nav>
    
    <div class="p-4 text-center text-xs text-gray-400 border-t border-gray-100">
        &copy; <?php echo date('Y'); ?> Quick Kart
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    const openSidebar = () => {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
    };

    const closeSidebar = () => {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
    };

    sidebarToggle.addEventListener('click', openSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);

    // Categories Collapsible Functionality
    const categoriesToggle = document.getElementById('categories-toggle');
    const categoriesContent = document.getElementById('categories-content');
    const categoriesArrow = document.getElementById('categories-arrow');

    if (categoriesToggle && categoriesContent) {
        // Check if we should start with categories open (based on URL or preference)
        const urlParams = new URLSearchParams(window.location.search);
        const hasCategoryParam = urlParams.has('cat_id') || urlParams.has('cat_ids');
        
        // Start with categories open if on a category page or if previously expanded
        const shouldExpand = hasCategoryParam || localStorage.getItem('categoriesExpanded') === 'true';
        
        if (shouldExpand) {
            categoriesContent.classList.remove('hidden');
            categoriesArrow.classList.remove('fa-chevron-down');
            categoriesArrow.classList.add('fa-chevron-up');
        }

        categoriesToggle.addEventListener('click', (e) => {
            e.preventDefault();
            categoriesContent.classList.toggle('hidden');
            
            // Rotate arrow
            categoriesArrow.classList.toggle('fa-chevron-down');
            categoriesArrow.classList.toggle('fa-chevron-up');
            
            // Save state to localStorage
            const isExpanded = !categoriesContent.classList.contains('hidden');
            localStorage.setItem('categoriesExpanded', isExpanded);
        });
    }
});
</script>

<style>
/* Smooth transitions for collapsible content */
#categories-content {
    transition: all 0.3s ease;
    overflow: hidden;
}

/* Ensure all main menu items have same styling */
nav a.font-medium {
    font-weight: 500;
    font-size: 0.9375rem; /* Same as default medium text */
}

/* Categories toggle button matches other menu items */
#categories-toggle {
    font-weight: 500;
    font-size: 0.9375rem;
}

/* Sub-category items slightly indented */
#categories-content a {
    padding-left: 1rem;
}

/* Hover effects consistent with other menu items */
#categories-content a:hover {
    background-color: #f3f4f6;
}
</style>