<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e('Skip to content', 'gf-recipes-theme'); ?></a>

<header class="site-header">
    <div class="container">
        <h1 class="site-title">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <?php bloginfo('name'); ?>
            </a>
        </h1>

         <!-- Burger button -->
    <button class="nav-toggle"
            aria-label="<?php esc_attr_e('Toggle menu','gf-recipes-theme'); ?>"
            aria-expanded="false">
      <span class="nav-toggle__bar" aria-hidden="true"></span>
    </button>

</button>

        <nav class="main-navigation">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'fallback_cb'    => function() {
                    echo '<ul>';
                    echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'gf-recipes-theme') . '</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/recipes/')) . '">' . esc_html__('Recipes', 'gf-recipes-theme') . '</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/fridge/')) . '">' . esc_html__('What\'s in my Fridge?', 'gf-recipes-theme') . '</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/add-your-own-recipe/')) . '">' . esc_html__('Add Own Recipe', 'gf-recipes-theme') . '</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/events/')) . '">' . esc_html__('Events', 'gf-recipes-theme') . '</a></li>';
                    echo '</ul>';
                },
            ]);
            ?>
        </nav>
    </div>
</header>

<main id="main-content">
