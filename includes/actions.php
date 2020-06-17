<?php

use League\Csv\Writer;

add_action( 'admin_post_yarnell_woocommerce_tax_report', function() {

    $beginDate = sanitize_text_field( $_POST[ 'beginDate' ] );
    $endDate = sanitize_text_field( $_POST[ 'endDate' ] );

    if( ! $beginDate || ! $endDate ) {
        wp_die( 'Both the begin date and end date are required.' );
    }


    try {
        $beginDate = (new \DateTime( $beginDate ))->format( 'Y-m-d');
        // Increment end date by 1 day to include the end date in the range.
        $endDate = (new \DateTime( $endDate ))->modify('+1 day')->format( 'Y-m-d');
    } catch( \Exception $e ) {
        wp_die( $e->getMessage() );
    }

    // Query orders with custom flag: '_has_tax'.
    // @link https://github.com/woocommerce/woocommerce/wiki/wc_get_orders-and-WC_Order_Query
    $orders = wc_get_orders( array(
        'limit' => -1,
        '_has_tax' => true,
        'date_paid' => "$beginDate...$endDate",
    ) );

    // Create the CSV into memory
    $csv = Writer::createFromFileObject(new SplTempFileObject());

    // Insert the CSV header
    $csv->insertOne( [ 'order_number', 'customer_id', 'customer_first_name', 'customer_last_name', 'billing_city', 'billing_state', 'billing_zip', 'billing_country', 'total_tax' ] );

    foreach( $orders as $order ) {

        $billing_address = $order->get_address( 'billing' );

        $csv->insertOne([
            $order->get_order_number(),
            $order->get_report_customer_id(),
            $order->get_customer_first_name(),
            $order->get_customer_last_name(),
            $billing_address[ 'city' ],
            $billing_address[ 'state' ],
            $billing_address[ 'postcode' ],
            $billing_address[ 'country' ],
            $order->get_total_tax(),
        ]);
    }

    // Because you are providing the filename you don't have to
    // set the HTTP headers Writer::output can
    // directly set them for you
    // The file is downloadable
    $csv->output('orders.csv');
    die;
});