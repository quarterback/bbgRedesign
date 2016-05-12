<?php
/**
 * The custom home page for the Broadcasting Board of Governors.
 * It includes the mission, a portfolio of recent projects, recent blog posts and staff.
 *
 * template name: About
 *
 * @author Gigi Frias <gfrias@bbg.gov>
 * @package bbgRedesign
 */

$templateName = "about";

get_header();

?>

<div id="main" class="site-main">

	<div id="primary" class="content-area">
		<main id="bbg-home" class="site-content bbg-home-main" role="main">
			<?php
				$data = get_theme_mod('header_image_data');
				$attachment_id = is_object($data) && isset($data->attachment_id) ? $data->attachment_id : false;

				if ($attachment_id) {
					$tempSources = bbgredesign_get_image_size_links($attachment_id);
					//sources aren't automatically in numeric order.  ksort does the trick.

					ksort($tempSources);
					$counter = 0;
					$prevWidth = 0;

					// Let's prevent any images with width > 1200px from being an output as part of responsive post cover
					foreach ( $tempSources as $key => $tempSource ) {
						if ($key > 1900) {
							unset($tempSources[$key]);
						}
					}
					echo "<style>";

					foreach ( $tempSources as $key => $tempSourceObj ) {
						$counter++;
						$tempSource = $tempSourceObj['src'];
						if ($counter == 1) {
							echo "\t.bbg-banner { background-image: url($tempSource) !important; }\n";
						} elseif ($counter < count($tempSources)) {
							echo "\t@media (min-width: " . ($prevWidth+1) . "px) and (max-width: " . $key . "px) {\n";
							echo "\t\t.bbg-banner { background-image: url($tempSource) !important; }\n";
							echo "\t}\n";
						} else {
							echo "\t@media (min-width: " . ($prevWidth+1) . "px) {\n";
							echo "\t\t.bbg-banner { background-image: url($tempSource) !important; }\n";
							echo "\t}\n";
						}
						$prevWidth = $key;
					}

					echo "</style>";
				}
			?>
			<section class="bbg-banner">
				<div class="usa-grid bbg-banner__container">
					<a href="<?php echo site_url(); ?>">
						<img class="bbg-banner__site-logo" src="<?php echo get_template_directory_uri() ?>/img/logo-agency-square.png" alt="BBG logo">
					</a>
					<div class="bbg-banner-box">
						<h1 class="bbg-banner-site-title"><?php echo bbginnovate_site_name_html(); ?></h1>
					</div>

					<div class="bbg-social__container">
						<div class="bbg-social">
						</div>
					</div>
				</div>
			</section>

			<!-- Page header -->
			<div class="usa-grid">
				<!-- Parent title -->
				<?php if ($post->post_parent) {
					$parent = $wpdb->get_row("SELECT post_title FROM $wpdb->posts WHERE ID = $post->post_parent");
					$parent_link = get_permalink($post->post_parent);
				?>
					<h5 class="entry-category bbg-label"><a href="<?php echo $parent_link; ?>"><?php echo $parent->post_title; ?></a></h5>
				<?php } ?>

				<!-- Page title -->
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header>
			</div>

			<!-- Query the about pages by parent title -->
			<?php
				// Set variables for page title and id
				$currentPageTitle = get_the_title();
				$currentPageID = get_the_ID();

				$qParams = array(
					'sort_column' => 'menu_order',
					'hierarchical' => 1,
					'meta_key' => 'show_in_parent_page',
					'meta_value' => '1',
					'child_of' => $currentPageID,
					'post_type' => 'page',
					'post_status' => 'publish'
				);

				$pages = get_pages($qParams);

				/*foreach( $pages as $page ) {
					echo "<p>" . $page->post_title . "<br/>";
					echo $page->introduction . "</p>";
				}
				// echo count($pages);
				die();*/
			?>

			<!-- Page introduction -->
			<section id="page-intro" class="usa-section usa-grid">
				<?php
					// Loop through the child pages
					foreach( $pages as $page ) {
						$introSection = $page->introduction;

						if ($introSection) {
							$introContent = $page->post_content;
							$introContent = apply_filters('the_content', $introContent);
							$introContent = str_replace(']]>', ']]&gt;', $introContent);
						?>

						<div class="">
							<?php echo $introContent; ?>
						</div>
						<?php
						}
					}
				?>
			</section>

			<!-- Child pages content -->
			<section id="page-children" class="usa-section bbg-staff">
				<div class="usa-grid usa-grid-full">

					<?php
						// Loop through the child pages
						foreach( $pages as $page ) {
							$introSection = $page->introduction;

							if (!$introSection) {
								$excerpt = $page->post_excerpt;
								$excerpt = apply_filters( 'the_content', $excerpt );
								$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
							?>
								<article class="bbg__entity">
									<div>
										<!-- Child page title -->
										<h6 class="bbg-label">
											<a href="<?php echo get_page_link( $page->ID ); ?>">
												<?php echo $page->post_title; ?>
											</a>
										</h6>
										<!-- Child page excerpt -->
										<div class="usa-intro bbg__broadcasters__intro">
											<h3 class="usa-font-lead">
												<?php echo $excerpt; ?>
											</h3>
										</div>
									</div>
								</article>
						<?php
							}
						}
					?>

					<?php wp_reset_postdata(); ?>
				</div>
			</section>

		</main>
	</div><!-- #primary .content-area -->
	<div id="secondary" class="widget-area" role="complementary">
	</div><!-- #secondary .widget-area -->
</div><!-- #main .site-main -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
