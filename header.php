<?php
defined('ABSPATH') or die();

// Getting Meta Description
$metaDesscription = get_bloginfo('name') . ' » ' . get_bloginfo('description');
if(is_single()) {
    $metaDesscription = single_post_title('', false);
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $metaDesscription; ?>">
        <link rel="pingback" href="<?php echo get_bloginfo('pingback_url'); ?>">
        <?php wp_head(); ?>
    </head>

    <body <?php \body_class('body'); ?> id="pagetop">
        <header class="headerMain">
            <div class="header-content">
                <div id="logo">
                    <?php
                    if(get_theme_mod('custom_logo')) {
                        echo '<a href="' . esc_url(home_url('/')) . '" id="site-logo" title="' . esc_attr(get_bloginfo('name', 'display')) . '" rel="home">',
                        '<img class="logo-img" src="' . get_theme_mod('custom_logo') . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '">',
                        '</a>';
                        // If no custom logo is set, show blog name
                    } else {
                        echo '<h2 class="blog-name"><a href="' . get_home_url() . '/">' . get_bloginfo('name') . '</a></h2>';
                    }

                    // Blog description
                    if(get_bloginfo('description')) {
                        echo '<span class="blog-description">' . get_bloginfo('description') . '</span>';
                    }
                    ?>
                </div>
            </div>
        </header>

        <!--
        // Container
        -->
        <div class="container-fluid">
            <?php
            // WordPress core custom header image
            $headerImage = get_header_image();

            $headerMetaClass = '';
            if($headerImage) {
                $headerMetaClass = 'meta-header-image';
                ?>
                <div class="header-image-container">
                    <img src="<?php echo esc_url($headerImage); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
                </div>
                <?php
            }
            ?>

            <div class="meta <?php echo $headerMetaClass; ?> clearfix">
                <div class="meta-search-form">
                    <?php get_search_form(); ?>
                </div>

                <?php
                if(is_user_logged_in()) {
                    if(current_user_can('edit_post', 123)) {
                        ?>
                        <a href="<?php echo get_home_url(); ?>/wp-admin/post-new.php" target="_self" class="add-post-link">
                            <small>
                                <span class="add-post-link-plus">+</span>
                                <span class="add-post-link-text"><?php echo __('Add post', 'yulai-federation-wiki'); ?></span>
                            </small>
                        </a>
                        <?php
                    }
                }
                ?>
            </div>
