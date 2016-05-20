<?php
/**
 * Template part for displaying a multicolumn child pages in About pages
 * 3 columns without byline or date
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bbginnovate
 */


global $includePortfolioDescription;
global $gridClass;
global $headline;

$includeDescription = TRUE;
if ( isset ( $includePortfolioDescription ) && $includePortfolioDescription == FALSE ) {
	$includeDescription = FALSE;
}

if ( ! isset ($gridClass) ) {
	$gridClass = "bbg-grid--1-2-2";
}
$classNames = "bbg__about__excerpt " . $gridClass;

$postPermalink = esc_url( get_permalink() );
if ( isset( $_GET['category_id'] ) ) {
	$postPermalink = add_query_arg('category_id', $_GET['category_id'], $postPermalink);
}

?>


<article id="post-<?php the_ID(); ?>" <?php post_class($classNames); ?>>
	<header class="entry-header bbg__about__excerpt-header">

	<?php
		$link = sprintf( '<a href="%s" rel="bookmark">', $postPermalink );
		$linkImage = sprintf( '<a href="%s" rel="bookmark" tabindex="-1">', $postPermalink );
		$linkLabel = '<h6 class="bbg-label">' . $link;
		// $linkH3 = '<h3 class="entry-title bbg__about__excerpt-title">' . $link;
	?>
		<div class="single-post-thumbnail clear bbg__excerpt-header__thumbnail--medium">
			<?php
				echo $linkImage;

				/* Set a default thumbnail image in case one isn't set */
				$thumbnail = '<img src="' . get_template_directory_uri() . '/img/portfolio-project-default.png" alt="This is a default image." />';

				if ( has_post_thumbnail() ) {
					$thumbnail = the_post_thumbnail('medium-thumb');
				}
				echo $thumbnail;
			?>
			</a>
		</div>
		<?php the_title( sprintf( $linkLabel, $postPermalink ), '</a></h6>' ); ?>

		<h3><?php echo $headline; ?></h3>

		<?php if ( 'post' === get_post_type() ) : ?>
			<!--
		<div class="entry-meta bbg__article-meta">
			<?php bbginnovate_posted_on(); ?>
		</div>-->
		<?php endif; ?>

	</header><!-- .entry-header -->


	<?php if ($includeDescription) { ?>

	<div class="entry-content bbg__about__excerpt-content bbg-blog__excerpt-content">
		<?php the_excerpt(); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bbginnovate' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .bbg__about__excerpt-title -->
	<?php } ?>

</article><!-- .bbg__about__excerpt -->