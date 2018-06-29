<?php
while(have_posts()) {
    the_post();
    ?>
    <article class="entry entryTypePost">
        <header class="entryHeader">
            <h1 class="entryTitle">
                <?php the_title(); ?>
            </h1>
        </header>

        <div class="entryContent">
            <?php the_content(); ?>
        </div>

        <footer class="entryMeta">
            <?php
            // get the post info
            get_template_part('postinfo');
            ?>
        </footer>
    </article>
    <?php
}
