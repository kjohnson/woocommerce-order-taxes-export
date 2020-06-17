<?php

add_action( 'admin_menu', function() {
    add_submenu_page(
        'woocommerce',
        'Order Taxes',
        'Order Taxes',
        'manage_options',
        'yarnell-taxes',
        function() {           
            include 'views/submenu.php';
        },
        $position = null
    );
});