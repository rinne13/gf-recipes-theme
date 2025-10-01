<?php
defined('ABSPATH') || exit;

/**
 * Theme setup: supports, menus, image sizes
 */

function gf_recipes_enqueue_fonts() {
    wp_enqueue_style(
        'gf-fonts',
        'https://fonts.googleapis.com/css2?family=Bitcount+Grid+Double+Ink:wght@100..900&family=Bitcount+Prop+Single+Ink:wght@100..900&family=Ephesis&display=swap',
        [],
        null
    );
}
add_action('wp_enqueue_scripts', 'gf_recipes_enqueue_fonts');



function gf_recipes_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('automatic-feed-links');

    register_nav_menus([
        'primary' => __('Primary Menu', 'gf-recipes-theme'),
    ]);

    // Custom sizes of hero and grid
    add_image_size('recipe-thumbnail', 400, 300, true); // карточки рецептов
    add_image_size('recipe-hero', 1200, 600, true);     // фон hero на главной
}
add_action('after_setup_theme', 'gf_recipes_theme_setup');

/**
 * Style of themes
 */
function gf_recipes_theme_scripts() {
    wp_enqueue_style('gf-recipes-theme-style', get_stylesheet_uri(), [], '1.0.0');
}
add_action('wp_enqueue_scripts', 'gf_recipes_theme_scripts');

/**
 * Sidebar
 */
function gf_recipes_theme_widgets_init() {
    register_sidebar([
        'name'          => __('Sidebar', 'gf-recipes-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'gf-recipes-theme'),
        'before_widget' => '<div class="sidebar widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);
}
add_action('widgets_init', 'gf_recipes_theme_widgets_init');

/**
 * Top-tags
 */
class GF_Recipes_Top_Tags_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'gf_top_tags',
            __('Top Gluten-Free Tags', 'gf-recipes-theme'),
            ['description' => __('Display most used recipe tags', 'gf-recipes-theme')]
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo $args['before_title'] . __('Top Gluten-Free Tags', 'gf-recipes-theme') . $args['after_title'];

        $tags = get_terms([
            'taxonomy' => 'recipe_tag',
            'orderby'  => 'count',
            'order'    => 'DESC',
            'number'   => 10,
        ]);

        if ($tags && !is_wp_error($tags)) {
            echo '<ul>';
            foreach ($tags as $tag) {
                echo '<li><a href="' . esc_url(get_term_link($tag)) . '">' . esc_html($tag->name) . ' (' . intval($tag->count) . ')</a></li>';
            }
            echo '</ul>';
        }

        echo $args['after_widget'];
    }
}

/**
 * Widget: last recepies
 */
class GF_Recipes_Recent_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'gf_recent_recipes',
            __('Recent Recipes', 'gf-recipes-theme'),
            ['description' => __('Display recent recipes', 'gf-recipes-theme')]
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo $args['before_title'] . __('Recent Recipes', 'gf-recipes-theme') . $args['after_title'];

        $recipes = new WP_Query([
            'post_type'      => 'recipe',
            'posts_per_page' => 5,
            'post_status'    => 'publish',
        ]);

        if ($recipes->have_posts()) {
            echo '<ul>';
            while ($recipes->have_posts()) {
                $recipes->the_post();
                echo '<li><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></li>';
            }
            echo '</ul>';
            wp_reset_postdata();
        }

        echo $args['after_widget'];
    }
}

function gf_recipes_register_widgets() {
    register_widget('GF_Recipes_Top_Tags_Widget');
    register_widget('GF_Recipes_Recent_Widget');
}
add_action('widgets_init', 'gf_recipes_register_widgets');


function gf_recipes_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'gf_recipes_excerpt_length');

/**
 * ===== IMAGES =====
 */

function gf_theme_asset($rel_path) {
    return trailingslashit(get_stylesheet_directory_uri()) . 'assets/' . ltrim($rel_path, '/');
}

function gf_fallback_image_url() {
    return gf_theme_asset('placeholder.jpg'); 
}


function gf_default_hero_url() {
    return get_stylesheet_directory_uri() . '/assets/images/hero.jpg';
}


function gf_get_hero_url($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();
    $thumb_id = $post_id ? get_post_thumbnail_id($post_id) : 0;
    if ($thumb_id) {
        $url = wp_get_attachment_image_url($thumb_id, 'recipe-hero');
        if ($url) return $url;
    }
    return gf_default_hero_url();
}


function gf_recipes_image_sizes_ui($sizes) {
    return array_merge($sizes, [
        'recipe-thumbnail' => __('Recipe Card (400×300, crop)', 'gf-recipes-theme'),
        'recipe-hero'      => __('Hero (1200×600, crop)', 'gf-recipes-theme'),
    ]);
}
add_filter('image_size_names_choose', 'gf_recipes_image_sizes_ui');


add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('gf-recipes-theme-style', get_stylesheet_uri(), [], '1.0.0');

  wp_enqueue_script(
    'gf-nav-toggle',
    get_template_directory_uri() . '/assets/js/nav-toggle.js',
    [],
    '1.0.0',
    true 
  );
});
