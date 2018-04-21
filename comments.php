<?php
if(comments_open()) {
	?>
	<div class="comments">',
		<h2>
			<?php _e('Comments', 'yulai-federation-wiki'); ?>
		</h2>

		<?php
		// this is displayed if there are comments
		if(have_comments()) {
			?>
			<h3>
				<?php
				_e('This post currently has', 'yulai-federation-wiki');
				comments_number(__('no responses', 'yulai-federation-wiki'), __('one response', 'yulai-federation-wiki'), __('% responses', 'yulai-federation-wiki'));
				?>
			</h3>

			<ul class="commentlist">
				<?php wp_list_comments(); ?>
			</ul>

			<div class="comment-nav">
				<div class="alignleft">';
					previous_comments_link();
				</div>
				<div class="alignright">';
					next_comments_link();
				</div>
			</div>
			<?php
		} else {
			// this is displayed if there are no comments so far
			_e('So empty here ... leave a comment!', 'yulai-federation-wiki');
		}

		// load comment form
		comment_form();
		?>
	</div>
	<?php
}
