<?php
/**
 * Plugin Name: Monolith Testimonials
 * Description: Built by BigSpring for use with the Monolith theme
 * Version: 1.0.0
 * Author: Paddy O'Harigan-Murphy
 */
 
 
 add_action( 'init', 'cptui_register_my_cpts' );
function cptui_register_my_cpts() {
    $labels = array(
        'name' => 'Testimonials',
        'singular_name' => 'Testimonial',
    );

    $args = array(
        'labels' => $labels,
        'description' => '',
        'public' => false,
        'show_ui' => true,
        'has_archive' => false,
        'show_in_menu' => true,
        'exclude_from_search' => false,
        'capability_type' => 'post',
        'menu_icon' => 'dashicons-format-status',
        'menu_position' => 5,
        'map_meta_cap' => true,
        'hierarchical' => false,
        'rewrite' => array( 'slug' => 'testimonial', 'with_front' => true ),
        'query_var' => true,
        );
    register_post_type( 'testimonial', $args );

}

add_action('widgets_init', function() {
    register_widget('MonolithTestimonialsWidget');
});

class MonolithTestimonialsWidget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        // widget actual processes
        parent::__construct(
            'monolith_testimonials_widget',
            __('Monolith Testimonials', 'accu-translations'),
            array('description' => __('Display related testimonials (with random fallback).', 'accu-translations'), )
        );
    }

    /**
     * Front-end display of widget.
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        // outputs the content of the widget

        // get tags for current post
        $current_tags = get_the_terms(get_the_ID(), 'post_tag');

        // define WP query parameters
        $params = array(
            'posts_per_page' => 1,
            'post_type' => 'testimonial',
            'orderby' => 'rand'
        );

        // add OR-type tag search to query
        if ($current_tags) {
            $params['tag__in'] = array();
            foreach ($current_tags as $tag) {
                $params['tag__in'][] = $tag->term_id;
            }
        }

        $query = new WP_Query($params);

        echo $args['before_widget'];

        ?>

            <div class="widget">
                <div class="testimonials">
                    <?php if ( $query->have_posts() ) : ?>
                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                            <div class="testimonial-item">
                                <p class="testimonial-quote"><?= get_the_content(); ?></p>
                                <p class="testimonial-source text-muted"><?php the_title(); ?></p>
                            </div>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
            </div>

        <?php

        echo $args['after_widget'];
    }
}
