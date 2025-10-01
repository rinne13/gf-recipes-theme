<?php get_header(); ?>

<div class="container">
    <h1 class="page-title"><?php esc_html_e('All Gluten-Free Recipes', 'gf-recipes-theme'); ?></h1>
    <p class="page-subtitle"><?php esc_html_e('Explore our collection of fabulous gluten-free recipes. You\'ll find plenty here to inspire you!', 'gf-recipes-theme'); ?></p>
    
    <?php if (have_posts()): ?>
        <div class="recipes-grid-jamie">
            <?php while (have_posts()): the_post(); ?>
                <article class="recipe-card-jamie">
                    <a href="<?php the_permalink(); ?>" class="recipe-link">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="recipe-image">
                                <?php the_post_thumbnail('large'); ?>
                                <div class="recipe-overlay">
                                    <h3 class="recipe-title"><?php the_title(); ?></h3>
                                    <?php
                                    $cook_time = get_post_meta(get_the_ID(), 'cook_time_minutes', true);
                                    if ($cook_time):
                                    ?>
                                        <span class="recipe-time-badge"><?php echo esc_html($cook_time); ?> mins</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="recipe-image recipe-no-image">
                                <div class="recipe-overlay">
                                    <h3 class="recipe-title"><?php the_title(); ?></h3>
                                    <?php
                                    $cook_time = get_post_meta(get_the_ID(), 'cook_time_minutes', true);
                                    if ($cook_time):
                                    ?>
                                        <span class="recipe-time-badge"><?php echo esc_html($cook_time); ?> mins</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
        
        <?php the_posts_pagination([
            'mid_size' => 2,
            'prev_text' => __('&larr; Previous', 'gf-recipes-theme'),
            'next_text' => __('Next &rarr;', 'gf-recipes-theme'),
        ]); ?>
    <?php else: ?>
        <p class="no-results"><?php esc_html_e('No recipes found.', 'gf-recipes-theme'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
