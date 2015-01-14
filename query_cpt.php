<?php
/**
 *  abstract class query_cpt
 * 
 *  used to query any custom post type
 *
 *  @package Sim Track Manager
 */
   
abstract class query_cpt {

    /*
     *  queries a custom post type to returns an array of arrays of key value pairs
     *  of data selected by the parameters entered. The switch statement needs to be
     *  expanded to take different parameters.
     *
     *  @param {string} $cpt - slug of custom post type
     *  @param {array} $parameters - array of parameters to query for
     *  @param {string} $order - query order paramater - default = 'ASC'
     *
     *  @return {array} $report_type
     */

    public static function get_cpt_array( $cpt, array $parameters, array $custom_fields = null, $order = 'ASC' ) {

        $args = array( 'post_type' => $cpt, 'order' => $order );

        $stm_report_types = new WP_Query( $args );

        $report_type = array();

        while ( $stm_report_types->have_posts() ) : $stm_report_types->the_post();

            global $post;

            $inner_array = array();

            foreach ( $parameters as $parameter ) {

                switch ( $parameter ) {

                    case 'title' :
                        $inner_array['title'] = get_the_title();
                        break;

                    case 'slug' :
                        $inner_array['slug'] = $post->post_name;
                        break;

                    case 'ID' :
                        $inner_array['ID'] = $post->ID;
                        break;

                    case 'content' :
                        $inner_array['content'] = get_the_content();
                        break;
                }
            }

            if ( $custom_fields ) {

                foreach ( $custom_fields as $field ) {

                    $inner_array[$field] = get_field( $field, null, false );
                }
            }

            $report_type[] = $inner_array;

        endwhile;

        return $report_type;
    }


}