<?php
/**
 * Our Theme's namespace to keep the global namespace clear
 *
 * WordPress\Themes\YulaiFederation
 */
namespace WordPress\Themes\YulaiFederationWiki;

// set content width for embedded media
if(!isset($content_width)) {
	$content_width = 1024; /* pixels */
}

// WIKIWP SETUP
if(!\function_exists('\WordPress\Themes\YulaiFederation\yfWikiSetup')) {
	// Sets up theme defaults and registers support for various WordPress features.
	function yfWikiSetup() {
		// Make theme available for translation. Translations can be filed in the "/languages/" directory.
		\load_theme_textdomain('yulai-federation-wiki', \get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		\add_theme_support('automatic-feed-links');

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		\add_theme_support('post-formats', [
			'status'
		]);

		// Add thumbnail support
		if(\function_exists('add_theme_support')) {
			\add_theme_support('post-thumbnails');
			// default post thumbnail dimensions (cropped)
			\the_post_thumbnail('thumbnail');		// Thumbnail (default 150px x 150px max)
			\the_post_thumbnail('medium');			// Medium resolution (default 300px x 300px max)
			\the_post_thumbnail('large');			// Large resolution (default 640px x 640px max)
			\the_post_thumbnail('full');				// Full resolution (original size uploaded)
			// additional image sizes
			\add_image_size('mini', 100, 100, true); // 100px x 100px crop
			\add_image_size('thumbnail-croped', 150, 150, true); // 150px x 150px croped
			\add_image_size('medium-croped', 300, 300, true); // 150px x 150px croped
			\add_image_size('medium-fix-width', 300, 9999, false); // 300px wide and unlimited height
		}

		// Remove accents on media upload
		\add_filter('sanitize_file_name', 'remove_accents');

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		\add_theme_support('html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		]);

		// Set up the WordPress core custom header feature.
		$args = [
			'flex-width' => true,
			'flex-height' => true,
		];

		\add_theme_support('custom-header', $args);

		// Set up the WordPress core custom background feature.
		\add_theme_support('custom-background', apply_filters('wikiwp_custom_background_args', [
			'default-color' => 'F0F0F0',
			'default-image' => '',
		]));
	}

	\add_action('after_setup_theme', '\\WordPress\Themes\YulaiFederationWiki\yfWikiSetup');
}

// OPEN GRAPH
function yfWikiDoctypeOpengraph($openGraph) {
	return $openGraph . ' ' . 'xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}

\add_filter('language_attributes', '\\WordPress\Themes\YulaiFederationWiki\yyfWikiDoctypeOpengraph');

function yfWikiOpenGraph() {
	if(\is_single()) {
		global $post;

		if(\get_the_post_thumbnail($post->ID, 'large')) {
			$thumbnail_id = \get_post_thumbnail_id($post->ID);
			$thumbnail_object = \get_post($thumbnail_id);
			$image = $thumbnail_object->guid;
		} else {
			// default open graph image
			// $image = '';
		}

		$excerpts = yfWikiExcerpt($post->post_content, $post->post_excerpt);
		$strippedExcerpts = \strip_tags($excerpts);
		$description = \str_replace("\"", "'", $strippedExcerpts);

		echo '<meta property="og:title" content="' . \get_the_title() . '" />' . "\n",
		'<meta property="og:type" content="article" />' . "\n",
		'<meta property="og:image" content="';

		if(\function_exists('\wp_get_attachment_thumb_url')) {
			echo \wp_get_attachment_thumb_url(\get_post_thumbnail_id($post->ID));
		}

		echo '" />' . "\n",
		'<meta property="og:url" content="' . \get_permalink() . '" />' . "\n",
		'<meta property="og:description" content="' . $description . '" />' . "\n",
		'<meta property="og:site_name" content="' . \get_bloginfo('name') . '" />' . "\n";
	}
}

// OPEN GRAPH FOR BETTER SHARING
\add_action('wp_head', '\\WordPress\Themes\YulaiFederationWiki\yfWikiOpenGraph');

function yfWikiExcerpt($text, $excerpt) {
	if($excerpt) {
		return $excerpt;
	}

	$text = \strip_shortcodes($text);
	$text = \apply_filters('the_content', $text);
	$text = \str_replace(']]>', ']]&gt;', $text);
	$text = \strip_tags($text);
	$excerpt_length = \apply_filters('excerpt_length', 55);
	$excerpt_more = \apply_filters('excerpt_more', ' ' . '[...]');
	$words = \preg_split("/[\n
         ]+/", $text, $excerpt_length + 1, \PREG_SPLIT_NO_EMPTY);

	if(\count($words) > $excerpt_length) {
		\array_pop($words);

		$text = \implode(' ', $words);
		$text = $text . $excerpt_more;
	} else {
		$text = \implode(' ', $words);
	}

	return \apply_filters('wp_trim_excerpt', $text, $excerpt);
}

function yfWikiLoadStyles() {
	\wp_register_style('bootstrap', \get_theme_file_uri('/css/bootstrap.min.css'), [], false, 'all');
	\wp_register_style('yulai-federation-wiki', \get_theme_file_uri('/style.css'), [], false, 'all');
	\wp_register_style('yulai-federation-wiki-navigation', \get_theme_file_uri('/css/navigation-side.css'), [], false, 'all');
	\wp_register_style('wiki-style', \get_theme_file_uri('/css/wiki.css'), [], false, 'all');

	\wp_enqueue_style('bootstrap');
	\wp_enqueue_style('yulai-federation-wiki');
	\wp_enqueue_style('yulai-federation-wiki-navigation');
	\wp_enqueue_style('wiki-style');
}
\add_action('wp_enqueue_scripts', '\\WordPress\Themes\YulaiFederationWiki\yfWikiLoadStyles');

function yfWikiLoadScripts() {
	\wp_enqueue_script('functions-script', get_theme_file_uri('/js/functions.js'), ['jquery'], false, true);

}
add_action('wp_enqueue_scripts', '\\WordPress\Themes\YulaiFederationWiki\yfWikiLoadScripts');

// CUSTOM LOGO UPLOADER
function yfWikiCustomizeRegister($wp_customize) {
	$wp_customize->add_section('wikiwp_custom_logo', [
		'title' => \__('Logo', 'yulai-federation-wiki'),
		'description' => \__('Use your own Logo instead of the blog name.', 'yulai-federation-wiki'),
		'priority' => 25,
	]);

	$wp_customize->add_setting('custom_logo', [
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	]);

	$wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, 'custom_logo', [
		'label' => \__('Set your own logo', 'yulai-federation-wiki'),
		'section' => 'wikiwp_custom_logo',
		'settings' => 'custom_logo',
	]));
}
\add_action('customize_register', '\\WordPress\Themes\YulaiFederationWiki\yfWikiCustomizeRegister');

// CUSTOM MENUS
function yfWikiCustomMenus() {
	\register_nav_menus(
		[
			'main-menu' => \__('Main', 'yulai-federation-wiki'),
			'meta-menu' => \__('Meta', 'yulai-federation-wiki')
		]
	);
}
\add_action('init', '\\WordPress\Themes\YulaiFederationWiki\yfWikiCustomMenus');

// order posts in categories
if(!function_exists('\WordPress\Themes\YulaiFederation\yfWikiCustomPostOrder')) {
	function yfWikiCustomPostOrder($query) {
		if((\is_category('news'))) {
			$query->query_vars['orderby'] = 'modified';
			$query->query_vars['order'] = 'DESC';
		} else {
			$query->query_vars['orderby'] = 'order';
		}
	}

	\add_action('pre_get_posts', '\\WordPress\Themes\YulaiFederationWiki\yfWikiCustomPostOrder');
}

// LOAD COMMENT REPLAY SCRIPT
function yfWikiLoadCommentReplayScript() {
	if((!\is_admin()) && \is_singular() && \comments_open() && \get_option('thread_comments')) {
		\wp_enqueue_script('comment-reply');
	}
}
\add_action('wp_print_scripts', '\\WordPress\Themes\YulaiFederationWiki\yfWikiLoadCommentReplayScript');

// AUTOMATIC FEED LINKS
//\add_theme_support('automatic-feed-links');

// SIDEBAR
function yfWikiRegisterSidebarLeft() {
	// Add sidebar support
	\register_sidebar([
		'name' => \__('Sidebar', 'yulai-federation-wiki'),
		'id' => 'sidebar-1',
		'description' => \__('Sidebar on the right hand of the website', 'yulai-federation-wiki'),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgetTitle">',
		'after_title' => '</h4>',
	]);

	// Custom sidebar navigation
	\register_sidebar([
		'name' => 'Navigation',
		'id' => 'navigation',
		'description' => 'Appears as the sidebar beneath the navigation',
		'before_widget' => '<div class="widget"><ul>',
		'after_widget' => '</ul></div>',
		'before_title' => '<h4 class="widgetTitle">',
		'after_title' => '</h4>',
	]);

	// Custom footer sidebar left
	\register_sidebar([
		'name' => 'Footer left',
		'id' => 'footer-left',
		'description' => 'Place your widgets here for the left side of the footer',
		'before_widget' => '<ul class="widget sidebar-footer-widget">',
		'after_widget' => '</ul>',
		'before_title' => '<h4 class="widgetTitle">',
		'after_title' => '</h4>',
	]);

	// Custom footer sidebar middle
	\register_sidebar([
		'name' => 'Footer middle',
		'id' => 'footer-mid',
		'description' => 'Place your widgets here for the middle of the footer',
		'before_widget' => '<ul class="dynamic-sidebar-widget sidebar-footer-widget">',
		'after_widget' => '</ul>',
		'before_title' => '<h4 class="widgetTitle">',
		'after_title' => '</h4>',
	]);

	// Custom footer sidebar right
	\register_sidebar([
		'name' => 'Footer right',
		'id' => 'footer-right',
		'description' => 'Place your widgets here for the right side of the footer',
		'before_widget' => '<ul class="dynamic-sidebar-widget sidebar-footer-widget">',
		'after_widget' => '</ul>',
		'before_title' => '<h4 class="widgetTitle">',
		'after_title' => '</h4>',
	]);
}
\add_action('widgets_init', '\\WordPress\Themes\YulaiFederationWiki\yfWikiRegisterSidebarLeft');

// CHANGE EXCERPT MORE LINK
function yfWikiExcerptMore($more) {
	global $post;

	return '... <a href="' . \get_permalink($post->ID) . '">' . \__('read more', 'yulai-federation-wiki') . ' &raquo;</a>';
}
\add_filter('excerpt_more', '\\WordPress\Themes\YulaiFederationWiki\yfWikiExcerptMore');

/**
 * Thumbnail output handling
 *
 * @return string formatted output in HTML
 */
function yfWikiGetThumbnail($post) {
	if(\has_post_thumbnail()) {
		// home and category
		if(\is_category() || \is_home() || \is_front_page()) {
			?>
			<div class="entryThumbnail alignleft">
				<a class="thumbnailLink thumbnailPostLink" href="<?php \esc_url(\the_permalink()); ?>">
					<figure class="thumbnailPost">
						<?php \the_post_thumbnail('mini'); ?>
					</figure>
				</a>
			</div>
			<?php
		} elseif(\is_single()) {
			// FEATURED IMAGE MEDIUM FIX WIDTH
			if(\has_post_thumbnail('medium-fix-width')) {
				$medium_fix_width_image_url = \wp_get_attachment_image_src(\get_post_thumbnail_id(), 'medium-fix-width');

				echo '<a class="postmeta-thumbnail" href="' . $medium_fix_width_image_url[0] . '" title="' . \the_title_attribute('echo=0') . '" >hallo</a>';
			} else {
				$thumbnail_large_url = \wp_get_attachment_image_src(\get_post_thumbnail_id(), 'large');

				echo '<a class="postmeta-thumbnail" href="' . $thumbnail_large_url[0] . '" title="' . \the_title_attribute('echo=0') . '" >' . \get_the_post_thumbnail($post->ID, 'large') . '</a>';
			}
		}
	}
}

/**
 * Tags output handling
 *
 * @return string formatted output in HTML
 */
function yfWikiGetTags($post) {
	\_e('Tags', 'yulai-federation-wiki');

	echo ':&nbsp;';

	$tag = \get_the_tags();

	if(!$tag) {
		echo 'There are no tags for this post';
	} else {
		\the_tags('', ', ', '');
	}
}

/**
 * Related posts output handling
 *
 * @return string formatted output in HTML
 */
function yfWikiGetRelatedPosts($post) {
	if(\is_single()) {
		?>
		<div class="widget relatedPosts">
			<h4 class="widgetTitle">
				<?php \_e('Related Posts', 'yulai-federation-wiki'); ?>
			</h4>

			<ul class="relatedPostList">
				<?php
				// if post has tags show related posts by tags
				if(\has_tag()) {
					$tags = \wp_get_post_tags($post->ID);

					if($tags) {
						$tag_ids = [];

						foreach($tags as $individual_tag) {
							$tag_ids[] = $individual_tag->term_id;
						}

						$args = [
							'tag__in' => $tag_ids,
							'orderby' => 'title',
							'order' => 'DESC',
							'post__not_in' => [$post->ID],
							'posts_per_page' => 5,
						];

						$my_query = new \WP_Query($args);

						if($my_query->have_posts()) {
							while($my_query->have_posts()) {
								$my_query->the_post();
								?>
								<li>
									<a href="<?php \the_permalink(); ?>" rel="bookmark" title="<?php \the_title_attribute(); ?>">
										<div class="thumb">
											<?php \the_post_thumbnail('mini'); ?>
										</div>

										<span><?php \the_title(); ?></span>
									</a>
								</li>
								<?php
							}
						}
					}
				} else {
					$categories = \get_the_category($post->ID);

					if($categories) {
						$category_ids = [];

						foreach($categories as $individual_category) {
							$category_ids[] = $individual_category->term_id;
						}

						$args = [
							'category__in' => $category_ids,
							'orderby' => 'title',
							'order' => 'DESC',
							'post__not_in' => [$post->ID],
							'posts_per_page' => 5,
						];

						$my_query = new \WP_Query($args);

						if($my_query->have_posts()) {
							while($my_query->have_posts()) {
								$my_query->the_post();
								?>
								<li>
									<a href="<?php \the_permalink(); ?>" rel="bookmark" title="<?php \the_title_attribute(); ?>">
										<div class="thumb">
											<?php \the_post_thumbnail('mini'); ?>
										</div>

										<span><?php \the_title(); ?></span>
									</a>
								</li>
								<?php
							}
						}
					}
				}
				?>
			</ul>
		</div>
		<?php
	}
}

/**
 * Edit post link output handling
 *
 * @return string formatted output in HTML
 */
function yfWikiGetEditPostLink($post) {
	// show edit button if user is logged in
	if(\is_user_logged_in()) {
		?>
		<div class="widget postMetaEdit">
			<div class="edit">
				<?php \edit_post_link(\__('edit', 'yulai-federation-wiki')); ?>
			</div>
		</div>
		<?php
	}
}

/**
 * Post excerpt output handling
 *
 * @return string formatted output in HTML
 */
function yfWikiGetPostExcerpt($post) {
	$wikiwpAdditionalExcerptPostClasses = [
		'entry',
		'entryTypePostExcerpt'
	];
	?>

	<article <?php \post_class($wikiwpAdditionalExcerptPostClasses); ?>>
		<div class="">
			<?php yfWikiGetThumbnail($post); ?>

			<div class="entryContainer">
				<header class="entryHeader">
					<h2 class="entryTitle">
						<a href="<?php \the_permalink(); ?>">
							<?php \the_title(); ?>
						</a>
					</h2>

					<div class="postinfo postinfo-excerpt">
						<span><?php \the_modified_date(); ?></span>
					</div>
				</header>

				<div class="entryContent">
					<?php \the_excerpt(); ?>
				</div>

				<footer class="entryMeta">
					<?php \get_template_part('postinfo'); ?>
				</footer>
			</div>
		</div>
	</article>
	<?php
}

function yfMainMenuFallback() {
	echo '<ul class="default-nav">';

	// show pages
	\wp_list_pages([
		'title_li' => '<span class="menu-title">' . \__('Pages', 'yulai-federation-wiki') . '</span>'
	]);

	// show categories
	\wp_list_categories([
		'title_li' => '<hr><span class="menu-title">' . \__('Categories', 'yulai-federation-wiki') . '</span>'
	]);

	echo '</ul>';
}
