<?php
add_action( 'woocommerce_before_checkout_billing_form', 'ccf_extra_fields', 100, 1 );
function ccf_extra_fields( $checkout ){
	
	$tt = new CCF_helper;
    $fields = $tt->get_extra_form();

	if( count($fields) == 0 ) { return false; }

	/*
	echo "<pre>";
	print_r($fields);
	echo "</pre>";
	*/

	echo "<h5>Extra fields</h5>";
	
	foreach( $fields as $field ) {
	
		if( $field['type'] == 'image' ) {

			echo '
				<p class="form-row form-row-wide validate-required" id="extra_fields['.$field['name'].']_field">
					<label for="extra_fields[License]" class="misha-label">
						'.$field['name'].' *:
						<abbr class="required" title="required"></abbr>
					</label>
					<span class="woocommerce-input-wrapper">
						<input type="file" class="input-text add-file-ajax" name="extra_fields[License]" />
						<input type="hidden" class="uploaded-file" name="extra_fields['.$field['name'].']" value="" />
						<span class="filename"></span>
					</span>
				</p>
			';

		}

		woocommerce_form_field( 
			'extra_fields['.$field['name'].']', 
			array(
				'type'          => $field['type'], // text, textarea, select, radio, checkbox, password, about custom validation a little later
				'required'	=> true, // actually this parameter just adds "*" to the field
				'class'         => array( 'form-row-wide' ), // array only, read more about classes and styling in the previous step
				'label'         => $field['name'],
				'label_class'   => '', // sometimes you need to customize labels, both string and arrays are supported
				'options'	=> $field['select_values'], 
			),	
		);
	

	}

	echo "
		<style>
			.form-row select {
				height: 50px;
    			font-size: 16px;
				padding-left: 10px;
			}
		</style>";

	?>
	
	<script>
	jQuery(document).ready(function($) {

		jQuery('.add-file-ajax').on('change', function() {

			var file_data = jQuery('.add-file-ajax').prop('files')[0];
			var form_data = new FormData();
			form_data.append('file', file_data);
			form_data.append('action', 'handle_file_upload');

			var res = jQuery(this).parent().find('.uploaded-file');
			var file_name = jQuery(this).parent().find('.filename');

			jQuery.ajax({
				url: '<?php echo admin_url("admin-ajax.php"); ?>',
				type: 'POST',
				data: form_data,
				contentType: false,
				accepts: 'application/json',
				processData: false,
				success: function(response) {
					if( response != '' ) {
						res.val( response );
						//res.file_name.text( 'File is uploaded' );
					}
					
				}
			});

		});

	});
	</script>
	

	<?php
	
	
}


// Custom checkout fields validation
add_action( 'woocommerce_checkout_process', 'ccf_checkout_field_process' );
function ccf_checkout_field_process() {

	$tt = new CCF_helper;
    $fields = $tt->get_extra_form();

	foreach( $fields as $field ) {

		if ( isset($_POST['extra_fields'][ $field['name'] ]) && empty($_POST['extra_fields'][ $field['name'] ]) )
        	wc_add_notice( __( 'Please fill in "'.$field['name'].'".' ), 'error' );

	}

    
}

// Save custom checkout fields the data to the order
add_action( 'woocommerce_checkout_create_order', 'ccf_checkout_field_update_meta', 10, 2 );
function ccf_checkout_field_update_meta( $order, $data ){
    //if( isset($_POST['extra_fields']) && ! empty($_POST['extra_fields']) )
        $order->update_meta_data( 'extra_fields', json_encode($_POST['extra_fields']) );
}

// Save the value of the extra_fields meta field when the order is updated
add_action('save_post_shop_order', 'save_ccf_order_meta');
function save_ccf_order_meta($post_id) {
    if (isset($_POST['extra_fields'])) {
        update_post_meta($post_id, 'extra_fields', sanitize_text_field($_POST['extra_fields']));
    }
}








