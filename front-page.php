<?php
get_header();

// Hero image helper (uses page featured image or fallback)
$hero_url = function_exists('gf_get_hero_url') ? gf_get_hero_url() : '';
if (!$hero_url && function_exists('gf_fallback_image_url')) {
  $hero_url = gf_fallback_image_url();
}
?>
<div class="hero-section">
  <div class="hero-bg" aria-hidden="true"
       style="background-image:url('<?php echo esc_url($hero_url); ?>')"></div>
  <div class="hero-content">
    <h1><?php echo esc_html( get_bloginfo('name') ); ?></h1>
    <p class="hero-subtitle-content"><?php echo esc_html( text: "Cook, share, and connect.") ?></p>
    <p class="hero-subtitle">
      <?php esc_html_e("Explore gluten-free recipes, submit yours, see what’s possible with what’s in your fridge, and join our events to meet like-minded foodies!", 'gf-recipes-theme'); ?>
    </p>
  </div>
</div>

<div class="container">

  <!-- ===== Latest Recipes (3) ===== -->
  <section class="home-section">
    <header class="home-section__header">
      <h2 class="home-section__title"><?php esc_html_e('Latest Recipes', 'gf-recipes-theme'); ?></h2>
      <a class="home-section__link" href="<?php echo esc_url(get_post_type_archive_link('recipe')); ?>">
        <?php esc_html_e('View all', 'gf-recipes-theme'); ?> →
      </a>
    </header>

    <?php
    $recipes = new WP_Query([
      'post_type'      => 'recipe',
      'posts_per_page' => 3,
      'orderby'        => 'date',
      'order'          => 'DESC',
      'no_found_rows'  => true,
    ]);
    ?>

    <?php if ($recipes->have_posts()) : ?>
      <div class="recipes-grid-jamie">
        <?php while ($recipes->have_posts()) : $recipes->the_post(); ?>
          <article class="recipe-card-jamie">
            <a href="<?php the_permalink(); ?>" class="recipe-link">
              <div class="recipe-image">
                <?php
                if ( has_post_thumbnail() ) {
                  the_post_thumbnail('recipe-thumbnail', [
                    'loading'=>'lazy',
                    'alt'=>esc_attr(get_the_title())
                  ]);
                } else {
                  echo '<img src="'.esc_url(function_exists('gf_fallback_image_url') ? gf_fallback_image_url() : '').'" alt="'.esc_attr(get_the_title()).'" loading="lazy" />';
                }
                ?>
                <div class="recipe-overlay">
                  <h3 class="recipe-title"><?php the_title(); ?></h3>
                  <?php if ($time = get_post_meta(get_the_ID(),'cook_time_minutes',true)) : ?>
                    <span class="recipe-time-badge"><?php echo esc_html($time); ?> mins</span>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php else : ?>
      <p class="no-results"><?php esc_html_e('No recipes found. Start adding recipes!', 'gf-recipes-theme'); ?></p>
    <?php endif; ?>
  </section>

  <!-- ===== Our Events (2) ===== -->
  <section class="home-section">
    <header class="home-section__header">
      <h2 class="home-section__title"><?php esc_html_e('Our Events', 'gf-recipes-theme'); ?></h2>
      <a class="home-section__link" href="<?php echo esc_url(get_post_type_archive_link('event')); ?>">
        <?php esc_html_e('All events', 'gf-recipes-theme'); ?> →
      </a>
    </header>

    <?php
    $events_q = new WP_Query([
      'post_type'      => 'event',
      'posts_per_page' => 2,
      'orderby'        => 'date',
      'order'          => 'DESC',
      'no_found_rows'  => true,
    ]);
    ?>

    <?php if ($events_q->have_posts()) : ?>
      <div class="events-row">
        <?php while ($events_q->have_posts()) : $events_q->the_post(); ?>
          <?php
            // Safe date bits
            $raw_date = get_post_meta(get_the_ID(), '_event_date', true);
            $ts = $raw_date ? strtotime($raw_date) : false;
            $day = $ts ? date_i18n('d', $ts) : '';
            $mon = $ts ? date_i18n('M', $ts) : '';
          ?>
          <article class="event-card">
            <div class="event-card__date" aria-hidden="true">
              <div class="event-card__day"><?php echo esc_html($day); ?></div>
              <div class="event-card__mon"><?php echo esc_html($mon); ?></div>
            </div>
            <div class="event-card__body">
              <h3 class="event-card__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h3>
              <p class="event-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
              <a class="event-card__btn" href="<?php the_permalink(); ?>"><?php esc_html_e('Details', 'gf-recipes-theme'); ?></a>
            </div>
          </article>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php else : ?>
      <p class="no-results"><?php esc_html_e('No events yet. Stay tuned!', 'gf-recipes-theme'); ?></p>
    <?php endif; ?>
  </section>

</div>

<?php get_footer(); ?>
