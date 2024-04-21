<?php
function handle_file_upload() {
    
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = wp_upload_dir();
        $file_name = basename($_FILES['file']['name']);
        $upload_path = $upload_dir['path'] . '/' . $file_name;

        move_uploaded_file($_FILES['file']['tmp_name'], $upload_path);

        $file_url = $upload_dir['url'] . '/' . $file_name;

        echo $file_url;

        /*
        $response = array(
            'url' => $file_url,
            'name' => $file_name
        );

        echo json_encode($response);
        */
    } else {
        echo json_encode(array('error' => 'Error uploading file.'));
    }

    die();
}

add_action('wp_ajax_handle_file_upload', 'handle_file_upload');
add_action('wp_ajax_nopriv_handle_file_upload', 'handle_file_upload');



function localize_script() {
    wp_localize_script('your-script-handle', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'localize_script');