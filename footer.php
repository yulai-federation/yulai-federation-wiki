		</div>
		<footer class="container-fluid">
			<div class="content clearfix">
				<?php
				// dynamic sidebar
				if(is_active_sidebar('footer-left')) {
					?>
					<div class="col-md-4 dynamic-sidebar-footer-left">
						<?php dynamic_sidebar('footer-left'); ?>
					</div>
					<?php
				}

				if(is_active_sidebar('footer-mid')) {
					?>
					<div class="col-md-4 dynamic-sidebar-footer-middle">
						<?php dynamic_sidebar('footer-mid'); ?>
					</div>
					<?php
				}

				if(is_active_sidebar('footer-right')) {
					?>
					<div class="col-md-4 dynamic-sidebar-footer-right">
						<?php dynamic_sidebar('footer-right'); ?>
					</div>
					<?php
				}
				?>

				<div class="col-md-12 copyright">
					<p>
						<strong>&copy; <a href="<?php echo esc_url(home_url()); ?>"><?php echo get_bloginfo('name'); ?></a></strong> | powered by the <a href="https://github.com/yulai-federation/yulai-federation-wiki" target="_blank">YF Wiki Theme</a> and <a href="http://wordpress.org/" target="_blank">WordPress</a>.
					</p>
				</div>
			</div>
		</footer>

		wp_footer();
	</body>
</html>
