<?php
// Save the value of the extra_fields meta field when the order is updated
add_action('save_post_shop_order', 'save_custom_order_meta');
function save_custom_order_meta($post_id) {
    if (isset($_POST['extra_fields'])) {
        update_post_meta($post_id, 'extra_fields', sanitize_text_field($_POST['extra_fields']));
    }
}


add_action( 'woocommerce_admin_order_data_after_order_details', 'misha_editable_order_meta_general' );
function misha_editable_order_meta_general( $order ){

	?>
		<br class="clear" />
		<h3>Extra fields</h3>
		<?php
        $extra = json_decode( $order->get_meta( 'extra_fields' ), true);

        if( is_array($extra) && count($extra) > 0 ) {  
		?>
            <div class="address">
                <?php
                    foreach( $extra as $name=>$value ) {
                        if(filter_var($value, FILTER_VALIDATE_URL)) {
                            $filename = basename($value);
                            $value = "<a target='_blank' href='{$value}'>{$filename}</a>";
                        }    
                    ?>
                        <p><strong><?php echo $name; ?>:</strong> <?php echo $value; ?></p>
                    <?php
                    }
                ?>
            </div>
        <?php
        }
        ?>

	<?php 
}

