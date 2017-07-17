<?php
/**
 * The template for displaying Author bios.
 *
 * @package bbgRedesign
 */
?>

<?php

	$curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) );

	/**** BEGIN PREPARING AUTHOR vars ****/
	$theAuthorID = $curauth -> ID;
	$authorName = $curauth -> display_name;
	$website = "";//$website = $curauth->user_url;

	$authorEmail = "";
	if ( $curauth -> isActive == "on" ) {
		//$authorEmail = '<a href="mailto:'. $curauth->user_email .'">'. $curauth->user_email .'</a>';
	}
	$addSeparator = FALSE;

	// Set author profile photo
	$avatar = get_avatar( $theAuthorID , apply_filters( 'change_avatar_css', 100 ) );

	$m = get_user_meta( $theAuthorID );

	// Set author Twitter handle
	$twitterHandle = "";
	$twitterLink = "";
	if ( isset( $m['twitterHandle'] ) ) {
		$twitterHandle = $m['twitterHandle'][0];
	}

	// Set author occupation
	$occupation = "";
	if ( isset( $m['occupation'] ) ) {
		$occupation = $m['occupation'][0];
	}

	// Set author short bio
	// Now hidden for new template (July 2017/GF)
	/*$description = "";
	if ( isset( $m['description'] ) ) {
		$description = $m['description'][0];
	}*/
	/**** DONE PREPARING AUTHOR vars ****/

	/**** BEGIN QUERYING POSTS AUTHORED BY THIS USER ****/
	$qParams = array(
		'post_type' => array( 'post' ),
		'orderby' => 'post_date',
		'order' => 'desc',
		'cat' => get_cat_id( 'Project' ),
		'posts_per_page' => -1
	);
	query_posts( $qParams );

	$projects = array();

	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			$usersInProjectStr = get_post_meta( get_the_ID(), 'users_in_project', true );
			$usersInProject = array_map( 'trim', explode( ',', $usersInProjectStr ) );  //get rid of whitespace and turn it into array

			array_walk( $usersInProject, 'intval' );
			//echo "project " . get_the_ID() . " has users " . $usersInProjectStr;

			if ( in_array( $theAuthorID, $usersInProject ) ) {
				$oneProjectPost = get_post( get_the_id() );
				array_push( $projects, $oneProjectPost );
			}
		endwhile;
	endif;

	wp_reset_query();

	/**** DONE QUERYING POSTS AUTHORED BY THIS USER ****/
	?>

	<div class="usa-section">
		<div class="usa-grid clearAll bbg__page-header" >

			<header class="page-header usa-width-two-thirds">
				<!-- Display author profile photo -->
				<div class="bbg__avatar__container bbg__team__icon">
					<?php echo $avatar; ?>
				</div>

				<div class="bbg__staff__author__text">
					<!-- Author's full name -->
					<h1 class="bbg__staff__author-name"><?php echo $authorName; ?></h1>

					<div class="bbg__staff__author-description">

						<?php
							// Author's occupation
							echo '<div class="bbg__staff__author-occupation">' . $occupation . '</div>';

							// Author's URL
							if ( $website && $website != '' ) {
								$website = '<span class="sep"> | </span><a href="' . $website . '">' . $website . '</a>';
							}

							// Author's Twitter handle
							if ( $twitterHandle && $twitterHandle != '' ) {
								$twitterHandle = str_replace( "@", "", $twitterHandle );
								$twitterLink = '<a href="//www.twitter.com/' . $twitterHandle . '">@' . $twitterHandle . '</a> ';

								if ( $addSeparator ) {
									$twitterLink = '<span class="u--seperator"></span> ' . $twitterLink;
								}
							}
						?>

						<!-- Author's email and Twitter handle -->
						<div class="bbg__staff__author-contact">
							<?php echo $authorEmail . $twitterLink; ?>
						</div>

						<!-- Author's short bio -->
						<!-- <div class="bbg__staff__author-bio">
							<?php echo $description; ?>
						</div> -->

					</div><!-- .author-description -->
				</div><!-- .bbg__staff__author-text -->
			</header><!-- .bbg__page-header -->
		<?php

			if ( count( $projects ) ) {
				$maxProjectsToShow=3;
				echo '<div class="usa-width-one-third bbg__staff__author-projects">';
					echo '<h6 class="bbg__label small">Recent projects</h2>';
					echo '<ul class="bbg__staff__author-projects__list">';
						for ( $i = 0; $i < min( $maxProjectsToShow, count( $projects ) ); $i++ ) {
							$p = $projects[$i];
							echo '<li><a href="' . get_permalink( $p ) . '">' . $p -> post_title . '</a></li>';
						}
					echo '</ul>';
				echo '</div>';
			}
		?>
	</div><!-- .usa-grid -->
</div>
