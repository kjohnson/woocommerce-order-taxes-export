<?php

/**
 * Handle a custom 'customvar' query var to get orders with the 'customvar' meta.
 * 
 * @link https://github.com/woocommerce/woocommerce/wiki/wc_get_orders-and-WC_Order_Query#adding-custom-parameter-support
 * 
 * @param array $query - Args for WP_Query.
 * @param array $query_vars - Query vars from WC_Order_Query.
 * @return array modified $query
 */
function handle_custom_query_var( $query, $query_vars ) {
	if ( ! empty( $query['_has_tax'] ) && $query['_has_tax'] ) {
		$query['meta_query'][] = array(
			'key' => '_order_tax',
            'value' => 0,
            'compare' => '>',
		);
	}

	return $query;
}
add_filter( 'woocommerce_order_data_store_cpt_get_orders_query', 'handle_custom_query_var', 10, 2 );