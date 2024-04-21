<?php
class CCF_helper {

    private $cart;

    public function __contruct() {

        $this->cart = $this->get_cart();

    }

    public function get_extra_form() {

        global $woocommerce;
        $cart_items = $woocommerce->cart->get_cart();

        $tags = $this->retrieve_tags( $cart_items );

        $forms = [];
        foreach( $tags as $tag ) {

            $form = $this->get_form_by_tag( $tag );
            if( $form ) {
                $forms[] = $form;
            }
  
        }

        $forms = $this->sort_by_count($forms);

        return $forms[0]['fields'];

        echo "<pre>";
        print_r($forms);
        echo "</pre>";
        die();

        return $fields;

    }

    private function retrieve_tags( $cart_items ) {

        foreach( $cart_items as $item => $values ) {

            $product_id = $values['data']->get_id();
            $tags_ids = $values['data']->get_tag_ids();
            foreach( $tags_ids as $tag ) {
                $tags[] = get_term( $tag )->name;
            }

        }

        return $tags;

    }

    private function get_form_by_tag( $tag ) {

        $args = array(
            'post_type'      => 'checkout_forms',
            'posts_per_page' => -1,
            'meta_key'       => 'tag',
            'meta_value'     => $tag,
        );
        $query = new WP_Query($args);

        $post = $query->posts[0];

        if( !isset($post->ID) ) { return false; }

        $fields = get_field('fields', $post->ID, true); // ACF function

        if( is_countable($fields) ) {

            foreach( $fields as $key=>$field ) {

                $values = [];
                if( $field['type'] == 'select' ) {
                    foreach( $field['select_values'] as $val ) {
                        $values[ $val['value'] ] = $val['value'];
                    }
                }

                $fields[$key]['select_values'] = $values;

            }

            return array(
                "name" => $post->post_title,
                "count" => count($fields),
                "fields" => $fields
            );

        }

        /*
        echo "<pre>";
        print_r($fields);
        echo "</pre>";
        */

        return $fields;        

    }

    private function get_cart() {

        return $items;

    }

    private function sort_by_count($array) {

        $compare = function ($a, $b) {
            return $b['count'] - $a['count'];
        };
    
        usort($array, $compare);
    
        return $array;
    }

}