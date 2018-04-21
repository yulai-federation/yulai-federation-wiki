<?php
get_header();
get_template_part('navigation');
?>

<div class="searchContainer">
	<section class="entryTypePostExcerptHeader">
		<header class="entryHeader">
			<h1 class="entryTitle">
				<?php
				echo $wp_query->found_posts . '&nbsp;';
				printf(__('results found for %s', 'yulai-federation-wiki'), '<strong>' . get_search_query() . '</strong>');
				?>
			</h1>
		</header>
	</section>

	<section class="entryTypePostExcerptContainer">
		<?php
		// query for post order
		$posts = query_posts($query_string . '&orderby=name&order=asc&posts_per_page=-1');

		if(have_posts()) : while(have_posts()) : the_post();
				// get post excerpt
				WordPress\Themes\YulaiFederationWiki\yfWikiGetPostExcerpt($post);
			endwhile;
			?>
		</section>

		<section class="entryTypePostExcerptMeta">
			<?php
			// Pagination
			echo '<div class="posts-pagination">';
			previous_posts_link('<span class="next-posts-link">&laquo; ' . __('Newer Entries', 'yulai-federation-wiki') . '</span>');
			next_posts_link('<span class="previous-posts-link">' . __('Older Entries', 'yulai-federation-wiki') . ' &raquo;</span>');
			echo '</div>'; // End of .posts-pagination
		// If no posts were found
		endif;
		?>
	</section>
</div>

<?php
// sidebar
get_sidebar();

// footer
get_footer();
