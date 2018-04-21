<div class="asideMenuButton">
	<header class="asideMenuButtonTitle"><?php echo __('Sidebar', 'yulai-federation-wiki'); ?></header>
	<div class="asideMenuButtonContent">
		<hr>
		<hr>
		<hr>
	</div>
</div>

<aside>
	<div class="aside-container container-full">
		<div class="customSidebar">
			<?php
			if(is_single() || is_page_template('wiki-page.php')) {
				while(have_posts()) : the_post();
					// get thumbnail
					WordPress\Themes\YulaiFederationWiki\yfWikiGetThumbnail($post);
					?>

					<div class="row sidebarContent">
						<div class="col-md-12">
							<?php
							// show edit button if user is logged in
							WordPress\Themes\YulaiFederationWiki\yfWikiGetEditPostLink($post);
							?>

							<div class="widget">
								<h3 class="widgetTitle"><?php the_title(); ?></h3>
							</div>

							<div class="widget">
								<?php
								// modified date
								_e('Last update on', 'yulai-federation-wiki');
								echo '&nbsp;';
								the_modified_date();
								?>
							</div>

							<div class="widget">
								<div>
									<?php
									// publishing date
									_e('Published', 'yulai-federation-wiki');
									echo '&nbsp;';
									the_date();
									?>
								</div>

								<div>
									<?php
									_e('Author', 'yulai-federation-wiki');
									echo ':</strong>&nbsp;';
									the_author_posts_link();
									echo '</span>';
									?>
								</div>

								<div>
									<?php
									// categories
									_e('Categories', 'yulai-federation-wiki');
									echo ':&nbsp;';
									the_category(', ');
									?>
								</div>

								<?php WordPress\Themes\YulaiFederationWiki\yfWikiGetTags($post); ?>
							</div>

							<?php WordPress\Themes\YulaiFederationWiki\yfWikiGetRelatedPosts($post); ?>
						</div>
					</div>

					<?php
				endwhile;
			} else {
				?>
				<div class="row sidebarContent">
					<div class="col-md-12">
						<?php
						// show edit button if user is logged in
						WordPress\Themes\YulaiFederationWiki\yfWikiGetEditPostLink($post);
						?>
					</div>
				</div>
				<?php
			}
			?>
		</div>

		<div class="dynamicSidebar">
			<div class="row sidebarContent">
				<div class="col-md-12">
					<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar()) : endif; ?>
				</div>
			</div>
		</div>
	</div>
</aside>
