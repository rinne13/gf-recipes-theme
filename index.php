<?php
/**
 * Fallback template: lists posts on blog/archives, shows full content on singular.
 * Theme: GF Recipes Theme
 */
get_header();
?>

<main id="primary" class="site-main" style="max-width: 920px; margin: 40px auto; padding: 0 16px;">
  <div class="container">
    <?php
    // Заголовок для блога/архивов
    if ( is_home() || is_archive() || is_search() ) : ?>
      <header class="page-header">
        <h1>
          <?php
            if ( is_home() ) {
              esc_html_e( 'Blog', 'gf-recipes-theme' );
            } elseif ( is_search() ) {
              printf(
                esc_html__( 'Search results for: %s', 'gf-recipes-theme' ),
                esc_html( get_search_query() )
              );
            } else {
              the_archive_title();
            }
          ?>
        </h1>
        <?php the_archive_description('<div class="archive-description">','</div>'); ?>
      </header>

      <?php if ( have_posts() ) : ?>
        <div class="blog-posts">
          <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class('blog-post'); ?> aria-labelledby="post-<?php the_ID(); ?>-title">
              <h2 id="post-<?php the_ID(); ?>-title" class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h2>
              <div class="post-meta">
                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                  <?php echo esc_html( get_the_date() ); ?>
                </time>
                <span class="sep">·</span>
                <span class="byline">
                  <?php esc_html_e( 'by', 'gf-recipes-theme' ); ?>
                  <?php the_author(); ?>
                </span>
                <?php if ( has_category() ) : ?>
                  <span class="sep">·</span>
                  <span class="cats"><?php the_category(', '); ?></span>
                <?php endif; ?>
              </div>

              <?php if ( has_post_thumbnail() ) : ?>
                <a class="thumb" href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail( 'large', ['loading' => 'lazy', 'alt' => esc_attr( get_the_title() )] ); ?>
                </a>
              <?php endif; ?>

              <div class="entry-excerpt">
                <?php the_excerpt(); ?>
              </div>

              <p>
                <a class="read-more" href="<?php the_permalink(); ?>">
                  <?php esc_html_e( 'Read more', 'gf-recipes-theme' ); ?>
                </a>
              </p>
            </article>
          <?php endwhile; ?>
        </div>

        <nav class="pagination" aria-label="<?php esc_attr_e('Posts', 'gf-recipes-theme'); ?>">
          <?php the_posts_pagination( [
            'mid_size'  => 1,
            'prev_text' => __('« Prev', 'gf-recipes-theme'),
            'next_text' => __('Next »', 'gf-recipes-theme'),
          ] ); ?>
        </nav>

      <?php else : ?>
        <p><?php esc_html_e( 'No posts found.', 'gf-recipes-theme' ); ?></p>
      <?php endif; ?>

    <?php

else :
      if ( have_posts() ) :
        while ( have_posts() ) : the_post(); ?>
          <article <?php post_class('singular'); ?>>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="entry-content">
              <?php the_content(); ?>
            </div>
            <?php

if ( is_single() ) {
                the_post_navigation([
                  'prev_text' => __('« Previous', 'gf-recipes-theme'),
                  'next_text' => __('Next »', 'gf-recipes-theme'),
                ]);
              }

              if ( comments_open() || get_comments_number() ) {
                comments_template();
              }
            ?>
          </article>
        <?php endwhile;
      else : ?>
        <p><?php esc_html_e( 'Nothing found.', 'gf-recipes-theme' ); ?></p>
      <?php endif;
    endif; ?>
  </div>
</main>

<?php get_footer(); ?>
