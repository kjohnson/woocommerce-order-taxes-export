<div class="wrap">

    <h1>Order Taxes</h1>

    <form method="POST" action="<?php echo add_query_arg( 'action', 'yarnell_woocommerce_tax_report' , admin_url( 'admin-post.php' ) ); ?>">
        <table class="form-table">
            <tbody>
            
                <!-- Begin Date -->
                <tr>
                    <th scope="row"><label for="beginDate">Begin Date</label></th>
                    <td><input required name="beginDate" type="date" id="beginDate" class="regular-text"></td>
                </tr>

                <!-- End Date -->
                <tr>
                    <th scope="row"><label for="endDate">End Date</label></th>
                    <td><input required name="endDate" type="date" id="endDate" class="regular-text"></td>
                </tr>
            
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" class="button button-primary" value="Export">
        </p>
    </form>

</div>