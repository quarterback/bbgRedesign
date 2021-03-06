<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * Note that we're leveraging a repeater custom field in the footer.  It's in the 'homepage options'
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * US Web Design Standards (alpha) includes 3 footers alternatives.
 * @link https://playbook.cio.gov/designstandards/footers/
 *
 * @package bbgRedesign
 */

?>

	</div><!-- #content -->

	<div class="usa-grid bbg__footer__return-to-top__container">
		<div class="usa-footer-return-to-top bbg__footer__return-to-top">
			<a href="#">Return to top</a>
		</div>
	</div>

	<footer class="usa-footer usa-footer-medium usa-sans" role="contentinfo" style="position: relative; z-index: 9990;">

		<div class="usa-footer-secondary_section usa-footer-big-secondary-section">
			<div class="usa-grid" itemscope itemtype="https://schema.org/GovernmentOffice">
				<div class="usa-footer-logo usa-width-one-half">
					<a href="<?php echo site_url(); ?>">
						<img itemprop="image" role="img" aria-label="BBG logo" class="usa-footer-logo-img" src="<?php echo get_template_directory_uri() ?>/img/logo-agency-square.png" alt="Broadcasting Board of Governors logo">
						<h3 itemprop="name" class="usa-footer-logo-heading">Broadcasting Board of Governors</h3>
					</a>
					<nav class="usa-footer-nav">
						<ul class="usa-unstyled-list">
							<li class="usa-width-one-fourth usa-footer-primary-content bbg__footer__subnav--links">
								<a href="/press-room">Press room</a>
							</li>
							<li class="usa-width-one-fourth usa-footer-primary-content bbg__footer__subnav--links">
								<a href="/news/network-highlights/newsletter-archives/signup/">Sign up</a>
							</li>
						</ul>
					</nav>
				</div>

				<div class="usa-footer-contact-links usa-width-one-half">
					<div class="usa-social-links">
						<a class="bbg_footer_social-link usa-link-facebook" href="https://www.facebook.com/BBGgov/" role="img" aria-label="Facebook"></a>
						<a class="bbg_footer_social-link usa-link-twitter" href="https://twitter.com/BBGgov" role="img" aria-label="Twitter"></a>
						<a class="bbg_footer_social-link usa-link-youtube" href="https://www.youtube.com/user/bbgtunein" role="img" aria-label="YouTube"></a>
						<a class="bbg_footer_social-link usa-link-rss" href="https://www.bbg.gov/category/press-release/feed/" role="img" aria-label="RSS"></a>
					</div>

					<address itemscope itemtype="https://schema.org/GovernmentOffice">
						<h3 class="usa-footer-contact-heading">Contact the BBG</h3>
						<p itemprop="address" aria-label="address">330 Independence Avenue, SW<br/>Washington, DC 20237</p>
						<p itemprop="telephone" aria-label="telephone"><a href="tel:+01-202-203-4000" rel="nofollow">(202) 203-4000</a></p>
						<a itemprop="email" aria-label="email" href="mailto:publicaffairs@bbg.gov">publicaffairs@bbg.gov</a>
					</address>
				</div>
			</div>
		</div>
		<?php if( have_rows('site_setting_footer_links', 'option') ): ?>
			<div class="bbg__footer__sub">
				<div class="usa-grid">
				<?php
					$counter = 0;
					while( have_rows('site_setting_footer_links', 'option') ): the_row();
						$counter++;
						if ($counter > 1) {
							echo " | ";
						}
						$anchorText = get_sub_field('anchor_text');
						$anchorLink = get_sub_field('anchor_link');
						echo "<div class='bbg__footer__sub__required-link'><a href='$anchorLink'>$anchorText</a></div>";
					endwhile;
				?>


				</div>
			</div>
		<?php endif; ?>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
