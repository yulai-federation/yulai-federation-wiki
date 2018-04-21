<?php
get_header();
get_template_part('navigation');
?>

<div class="content">
	<h1 class="page-title"><?php echo get_the_author(); ?></h1>

	<div class="avatar-profile">
		<div class="alignleft avatar"><?php echo get_avatar(get_the_author_meta('email'), '150'); ?></div>

		<?php
		// description
		if(get_the_author_meta('description')) {
			?>
			<p class="author-description"><?php echo get_the_author_meta('description');?></p>
			<?php
		}

		// website
		if(get_the_author_meta('user_url')) {
			?>
			<p class="author-url">
				<strong>
					<?php _e('Website:', 'yulai-federation-wiki'); ?>
				</strong>
				<a href="<?php echo get_the_author_meta('user_url'); ?>" title="<?php echo get_the_author_meta('user_url'); ?>" target="_blank"><?php echo get_the_author_meta('user_url'); ?></a>
			</p>
			<?php
		}
		?>

		<div class="author-postings">
			<h3>
				<?php
				echo get_the_author();
				_e('&acute;s postings', 'yulai-federation-wiki');
				?>
			</h3>

			<?php
			if(have_posts()) {
				?>
				<ul>
				<?php
				while(have_posts()) {
					the_post();
					?>
					<li>
						<a href="<?php echo get_permalink(); ?>" rel="bookmark" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a>
					</li>
					<?php
				}
				?>
				</ul>
				<?php
			} else {
				?>
				<p>
					<?php _e('No posts by this author.', 'yulai-federation-wiki'); ?>
				</p>
				<?php
			}
			?>
		</div>
	</div>

	<div class="author-list">
		<h2>
			<?php _e('Our authors', 'yulai-federation-wiki'); ?>
		</h2>

		<ul>
			<?php echo wp_list_authors('show_fullname=1&optioncount=1&orderby=post_count&order=DESC'); ?>
		</ul>
	</div>
</div>

<?php
// footer
get_footer();
