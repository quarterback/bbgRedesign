<?php 
	// Add shortcode reference for the BBG mission
	function mission_shortcode( $atts ) {
	    $a = shortcode_atts( array(
	        'org' => 'Broadcasting Board of Governors',
	    ), $atts );

	    return "<p>The mission of the {$a['org']} is to inform, engage, and connect people around the world in support of freedom and democracy.</p>";
	}

	add_shortcode( 'mission', 'mission_shortcode' );

	// Add shortcode reference for BBG-wide audience numbers
	function audience_shortcode( $atts ) {
		// access site-wide variables
		global $post;

	    // set variables based on custom fields
	    $total = get_field('site_setting_unduplicated_audience','options','false');
		$tv = get_field('site_setting_tv_audience','options','false');
		$radio = get_field('site_setting_radio_audience','options','false');
		$internet = get_field('site_setting_internet_audience','options','false');
		// set a default audience variable
		$selectedAudienceType = 'total';
		// change audience variable if passed from shortcode
		if (isset($atts['type'])) {
			$selectedAudienceType = $atts['type'];
		}
	    // set shortcode attributes to custom field values
	    $split = shortcode_atts( array(
	        'total' => '226',
	        'tv' => '142',
	        'radio' => '102',
	        'internet' => '32',
	    ), array(
	        'total' => $total,
	        'tv' => $tv,
	        'radio' => $radio,
	        'internet' => $internet,
	    ), 'audience' );

	    return $split[$selectedAudienceType] . " million";
	}

	add_shortcode( 'audience', 'audience_shortcode' );


	// Add shortcode reference for the number of supported languages
	function languages_shortcode() {
		// access site-wide variables
		global $post;

		// set variables based on custom fields
	    $number_of_languages = get_field('site_setting_total_languages','options','false');

		// $number_of_languages = 61;
		return $number_of_languages . " languages";
	}
	add_shortcode('languages', 'languages_shortcode');

	// Add shortcode reference for the number of total countries
	function countries_shortcode() {
		// access site-wide variables
		global $post;

		// set variables based on custom fields
	    $number_of_countries = get_field('site_setting_total_countries','options','false');

		//$number_of_countries = 100;
		return $number_of_countries . " countries";
	}
	add_shortcode('countries', 'countries_shortcode');

?>