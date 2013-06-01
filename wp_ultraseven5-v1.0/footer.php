		<?php if ( is_active_sidebar('before-footer') and !is_front_page() and !is_page_template('template-home.php') ) : ?>
			<div class="before-footer-area twelve columns">
				<div class="row">
					<div class="twelve columns"><div class="twelve columns separator"></div></div>
				</div>
				<?php
					if ( !is_front_page() and !is_page_template('template-home.php') ) {
						dynamic_sidebar('before-footer');
					}
				?>
			</div>
		<?php endif; ?>

			</div> <!-- .row -->
		</section> <!-- #main -->

		<footer id="footer" class="twelve columns">
			<div class="row">
				<div class="twelve columns">
					<div class="footer-separator twelve columns"></div>
				</div>
					<div class="three columns">
						<?php dynamic_sidebar('footer-widgets-1'); ?>
					</div>
					<div class="three columns">
						<?php dynamic_sidebar('footer-widgets-2'); ?>
					</div>
					<div class="three columns">
						<?php dynamic_sidebar('footer-widgets-3'); ?>
					</div>
					<div class="three columns">
						<?php dynamic_sidebar('footer-widgets-4'); ?>
					</div>
				</div>

			<div class="footer-credits">
				<?php echo ci_footer(); ?>
			</div>
		</footer>

	</div> <!-- .row < #page -->
</div> <!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
