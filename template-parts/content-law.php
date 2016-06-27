<?php
/**
 * Template part for displaying laws in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bbginnovate
 */


//Experimenting with adding the social share code to Pages
//the title/headline field, followed by the URL and the author's twitter handle
$twitterText = "";
$twitterText .= html_entity_decode( get_the_title() );
$twitterHandle = get_the_author_meta( 'twitterHandle' );
$twitterHandle = str_replace( "@", "", $twitterHandle );
if ( $twitterHandle && $twitterHandle != '' ) {
	$twitterText .= " by @" . $twitterHandle;
} else {
	$authorDisplayName = get_the_author();
	if ( $authorDisplayName && $authorDisplayName!='' ) {
		$twitterText .= " by " . $authorDisplayName;
	}
}
$twitterText .= " " . get_permalink();
$hashtags="";
//$hashtags="testhashtag1,testhashtag2";

///$twitterURL="//twitter.com/intent/tweet?url=" . urlencode(get_permalink()) . "&text=" . urlencode($ogDescription) . "&hashtags=" . urlencode($hashtags);
$twitterURL="//twitter.com/intent/tweet?text=" . rawurlencode( $twitterText );
$fbUrl="//www.facebook.com/sharer/sharer.php?u=" . urlencode( get_permalink() );



/*** Sidebar content ***/
$includeSidebar = get_post_meta( get_the_ID(), 'sidebar_include', true );

if ( $includeSidebar ) {
	// check if the flexible content field has rows of data
	$sidebar = "";
	$s = "";

	if ( have_rows('sidebar_items') ):
		$sidebarTitle = get_post_meta( get_the_ID(), 'sidebar_title', true );
		$sidebarContent = get_post_meta( get_the_ID(), 'sidebar_description', true );

		if ( $sidebarTitle != "" ) {
			$s = "<h5 class='bbg__label small bbg__sidebar__download__label'>" . $sidebarTitle ."</h5>";
		}

		if ( $sidebarContent != "" ) {
			$sidebarContent = apply_filters('the_content', $sidebarContent);
   			$sidebarContent = str_replace(']]>', ']]&gt;', $sidebarContent);
			$s .= $sidebarContent;
		}

		while ( have_rows('sidebar_items') ) : the_row();

			if ( get_row_layout() == 'sidebar_download_file' ) {

				$sidebarDownloadTitle = get_sub_field( 'sidebar_download_title' );
				$sidebarDownloadThumbnail = get_sub_field( 'sidebar_download_thumbnail' );
				$sidebarDownloadLink = get_sub_field( 'sidebar_download_link' );
				$sidebarDownloadDescription = get_sub_field( 'sidebar_download_description', false);

				$sidebarImage = "";
				if ($sidebarDownloadThumbnail && $sidebarDownloadThumbnail != "") {
					$sidebarImage = "<img src='" . $sidebarDownloadThumbnail . "' class='bbg__sidebar__download__thumbnail' alt='Thumbnail image for download' />";
				}

				$sidebarDescription = "";
				if ($sidebarDownloadDescription && $sidebarDownloadDescription != "") {
					$sidebarDescription = "<p class='bbg__sidebar__download__description'>" . $sidebarDownloadDescription . "</p>";
				}

				$sidebarDownload = "";
				$sidebarDownload = "<a href='" . $sidebarDownloadLink . "'>" . $sidebarImage . "</a><h5 class='bbg__sidebar__download__title'><a href='" . $sidebarDownloadLink . "'>" . $sidebarDownloadTitle . "</a></h5>" . $sidebarDescription;

				$s .= "<div class='bbg__sidebar__download'>" . $sidebarDownload . "</div>";
			} elseif (get_row_layout() == 'sidebar_quote'){

				$sidebarQuotationText = get_sub_field( 'sidebar_quotation_text', false);
				$sidebarQuotationSpeaker = get_sub_field( 'sidebar_quotation_speaker' );
				$sidebarQuotationSpeakerTitle = get_sub_field( 'sidebar_quotation_speaker_title' );

				$s .= '<div><h5>"' . $sidebarQuotationText . '"</h5><p>' . $sidebarQuotationSpeaker . ', ' . $sidebarQuotationSpeakerTitle ."</p></div>";
			} else if (get_row_layout() == 'sidebar_external_link'){

				$sidebarLinkTitle = get_sub_field( 'sidebar_link_title', false);
				$sidebarLinkLink = get_sub_field( 'sidebar_link_link' );
				$sidebarLinkDescription = get_sub_field( 'sidebar_link_description', false);

				$sidebarDescription = "";
				if ($sidebarLinkDescription && $sidebarLinkDescription != ""){
					$sidebarDescription = "<p class=''>" . $sidebarLinkDescription . "</p>";
				}

				$s .= '<div class=""><h5 class=""><a href="' . $sidebarLinkLink . '">' . $sidebarLinkTitle . '</a></h5>' . $sidebarDescription . '</div>';
			} else if (get_row_layout() == 'sidebar_internal_link') {

				$sidebarInternalTitle = get_sub_field( 'sidebar_internal_title', false);
				$sidebarInternalLocation = get_sub_field( 'sidebar_internal_location' );
				$sidebarInternalDescription = get_sub_field( 'sidebar_internal_description', false);

				// get data out of WP object
				$url = get_permalink( $sidebarInternalLocation->ID ); // Use WP object ID to get permalink for link
				$title = $sidebarInternalLocation->post_title; // WP object title

				$sidebarSectionTitle = "";
				// Set text for the internal link
				if ($sidebarInternalTitle && $sidebarInternalTitle != "") {
					// User-defined title
					$sidebarSectionTitle = "<p>" . $sidebarInternalTitle . "</p>";
				} else {
					// WP object title (set above)
					$sidebarSectionTitle = "<p>" . $title . "</p>";
				}

				$sidebarDescription = "";
				// Set text for description beneath link
				if ($sidebarInternalDescription && $sidebarInternalDescription != "") {
					// User-defined description
					$sidebarDescription = "<p>" . $sidebarInternalDescription . "</p>";
				}

				$s .= '<div class=""><h5 class=""><a href="' . $url . '">' . $sidebarSectionTitle . '</a></h5>' . $sidebarDescription . '</div>';
			}
		endwhile;

		$sidebar .= $s;
	endif;
} ?>

<article id="post-<?php the_ID(); ?>">
	<div class="usa-grid">
		<?php echo bbginnovate_post_categories(); ?>

		<!-- .bbg__label -->
		<header class="entry-header">
			<?php if($post->post_parent) {
				//borrowed from: https://wordpress.org/support/topic/link-to-parent-page
				$parent = $wpdb->get_row("SELECT post_title FROM $wpdb->posts WHERE ID = $post->post_parent");
				$parent_link = get_permalink($post->post_parent);
				?>
				<h5 class="bbg__label"><a href="<?php echo $parent_link; ?>"><?php echo $parent->post_title; ?></a></h5>
			<?php } ?>

			<?php the_title( '<h1 class="entry-title bbg__article-header__title">', '</h1>' ); ?>
		</header><!-- .entry-header -->


		<div class="usa-grid-full">
			<div class="bbg__article-sidebar--left">
				<h3 class="bbg__sidebar-label bbg__contact-label">Share </h3>
				<ul class="bbg__article-share">
					<li class="bbg__article-share__link facebook">
						<a href="<?php echo $fbUrl; ?>">
							<span class="bbg__article-share__icon facebook"></span>
						</a>
					</li>
					<li class="bbg__article-share__link twitter">
						<a href="<?php echo $twitterURL; ?>">
							<span class="bbg__article-share__icon twitter"></span>
						</a>
					</li>
				</ul>
			</div><!-- .bbg__article-sidebar--left -->

			<div class="entry-content bbg__article-content <?php echo $featuredImageClass; ?>">

				<?php
					$pageHeadline = get_field('headline');

					if ( $pageHeadline ) {
						echo "<h2 class='act-title'>" . $pageHeadline . "</h2>";
					}
					echo "<section class='usa-grid-full'>";
						the_content();
					echo "</section>";


				?>
			</div><!-- .entry-content -->
			<?php
			// Right sidebar
			echo "<div class='bbg__article-sidebar'>";
				echo "<!-- Sidebar content -->";
					if ( $includeSidebar && $sidebarTitle != "" ) {
						echo $sidebar;
					}
			echo "</div><!-- .bbg__article-sidebar -->";
			?>
		</div>

		<footer class="entry-footer bbg-post-footer 1234">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'bbginnovate' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	</div><!-- .usa-grid -->
</article><!-- #post-## -->
