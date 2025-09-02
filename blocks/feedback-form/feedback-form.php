<section class="single-article-button">
	<div class="grid-x grid-margin-x">
		<div class="cell">
			<button class="btn primary toggle-btn" data-trigger="feedback-toggle" aria-expanded="false">
				<i class="fa-solid fa-comments-question"></i> 
				<?php _e( 'What do you think of this page?', 'strl-frontend' ); ?>
			</button>
			<div class="feedback-toggle bg-tertiary">
				<?php echo do_shortcode( '[gravityforms id="3" ajax="true" title="false" description="false"][/gravityforms]' ); ?>
			</div>
		</div>
	</div>
</section>
