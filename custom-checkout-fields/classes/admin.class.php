<?php
class CCF_admin {

    public function __construct() {

        add_action( 'init', array($this, 'cptui_register_my_cpts_checkout_forms') );

    }

    function cptui_register_my_cpts_checkout_forms() {

        /**
         * Post Type: Checkout forms.
         */
    
        $labels = [
            "name" => esc_html__( "Checkout forms", "neve" ),
            "singular_name" => esc_html__( "Checkout form", "neve" ),
        ];
    
        $args = [
            "label" => esc_html__( "Checkout forms", "neve" ),
            "labels" => $labels,
            "description" => "",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "rest_namespace" => "wp/v2",
            "has_archive" => false,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "can_export" => false,
            "rewrite" => [ "slug" => "checkout_forms", "with_front" => true ],
            "query_var" => true,
            "supports" => [ "title", "editor", "thumbnail" ],
            "show_in_graphql" => false,
        ];
    
        register_post_type( "checkout_forms", $args );
    }

}

new CCF_admin();