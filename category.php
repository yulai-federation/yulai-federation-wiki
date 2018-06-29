<?php
get_header();
get_template_part('navigation');
?>

<div class="catContainer">
    <section class="entryTypePostExcerptHeader">
        <header class="entryHeader">
            <h1 class="entryTitle">
                <?php single_cat_title(); ?>
            </h1>
        </header>

        <div class="entryContent">
            <?php
            // category description if exists
            $category = get_the_category();

            if(category_description($category[0]->cat_ID)) {
                echo '<p class="categoryDescription">' . category_description($category[0]->cat_ID) . '</p>';
            }
            ?>
        </div>
    </section>

    <?php
    if(have_posts()) {
        while(have_posts()) {
            the_post();
            ?>
            <section class="entryTypePostExcerptContainer">
                <?php WordPress\Themes\YulaiFederationWiki\yfWikiGetPostExcerpt($post); ?>
            </section>
            <?php
        }
        ?>

        <section class="entryTypePostExcerptMeta">
            <?php
            // Pagination
            echo '<div class="posts-pagination">';
            previous_posts_link('<span class="next-posts-link">&laquo; ' . __('Newer Entries', 'yulai-federation-wiki') . '</span>');
            next_posts_link('<span class="previous-posts-link">' . __('Older Entries', 'yulai-federation-wiki') . ' &raquo;</span>');
            echo '</div>'; // End of .posts-pagination
            ?>
        </section>
        <?php
    }
    ?>
</div>

<?php
// sidebar
get_sidebar();

// footer
get_footer();
