<?php
add_action( 'woocommerce_admin_order_data_after_order_details', 'ccf_order_extra_fields' );
function ccf_order_extra_fields( $order ){

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
                        if( strpos($value, 'http') !== false ) {
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

