<?php get_header(); ?>

<div class="container">
    <?php while (have_posts()): the_post(); ?>
        <article class="recipe-single">
            <header class="recipe-hero">
                <h1><?php the_title(); ?></h1>
                
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('recipe-hero'); ?>
                <?php endif; ?>
                
                <div class="recipe-meta">
                    <?php
                    $cook_time = get_post_meta(get_the_ID(), 'cook_time_minutes', true);
                    if ($cook_time):
                    ?>
                        <div class="recipe-meta-item">
                            <span>⏱</span>
                            <div>
                                <strong><?php esc_html_e('Cook Time:', 'gf-recipes-theme'); ?></strong>
                                <?php echo esc_html($cook_time); ?> <?php esc_html_e('minutes', 'gf-recipes-theme'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php
                    $difficulty = get_post_meta(get_the_ID(), 'difficulty', true);
                    if ($difficulty):
                    ?>
                        <div class="recipe-meta-item">
                            <span>📊</span>
                            <div>
                                <strong><?php esc_html_e('Difficulty:', 'gf-recipes-theme'); ?></strong>
                                <?php echo esc_html(ucfirst($difficulty)); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php
                    $servings = get_post_meta(get_the_ID(), 'servings', true);
                    if ($servings):
                    ?>
                        <div class="recipe-meta-item">
                            <span>🍽</span>
                            <div>
                                <strong><?php esc_html_e('Servings:', 'gf-recipes-theme'); ?></strong>
                                <?php echo esc_html($servings); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="recipe-badges">
                    <?php
                    $diet_types = wp_get_post_terms(get_the_ID(), 'diet_type');
                    foreach ($diet_types as $diet):
                    ?>
                        <span class="badge diet"><?php echo esc_html($diet->name); ?></span>
                    <?php endforeach; ?>
                    
                    <?php
                    $tags = wp_get_post_terms(get_the_ID(), 'recipe_tag');
                    foreach ($tags as $tag):
                    ?>
                        <span class="badge"><?php echo esc_html($tag->name); ?></span>
                    <?php endforeach; ?>
                </div>
            </header>
            
            <div class="recipe-description">
                <?php the_content(); ?>
            </div>
            
            <?php
            $ingredients = get_post_meta(get_the_ID(), 'ingredients', true);
            if (!empty($ingredients)):
            ?>
                <section class="ingredients-section">
                    <h2><?php esc_html_e('Ingredients', 'gf-recipes-theme'); ?></h2>
                    <ul class="ingredients-list">
                        <?php foreach ($ingredients as $ingredient): ?>
                            <li><?php echo esc_html($ingredient); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>
            
            <?php
            $steps = get_post_meta(get_the_ID(), 'steps', true);
            if (!empty($steps)):
            ?>
                <section class="steps-section">
                    <h2><?php esc_html_e('Instructions', 'gf-recipes-theme'); ?></h2>
                    <ol class="steps-list">
                        <?php foreach ($steps as $step): ?>
                            <li><?php echo wp_kses_post($step); ?></li>
                        <?php endforeach; ?>
                    </ol>
                </section>
            <?php endif; ?>
            
            <?php
            $allergens = get_post_meta(get_the_ID(), 'allergens', true);
            if (!empty($allergens)):
            ?>
                <section class="allergens-section">
                    <h2><?php esc_html_e('Allergen Information', 'gf-recipes-theme'); ?></h2>
                    <p><?php esc_html_e('Contains:', 'gf-recipes-theme'); ?> <?php echo esc_html(implode(', ', $allergens)); ?></p>
                    <p><em><?php esc_html_e('(Gluten-free by design)', 'gf-recipes-theme'); ?></em></p>
                </section>
            <?php endif; ?>
            
            <?php
            if (comments_open() || get_comments_number()):
                comments_template();
            endif;
            ?>
        </article>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
