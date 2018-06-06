<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
    <label>
        <input type="search" class="search-field" placeholder="<?php echo __('Search', 'yulai-federation-wiki'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo __('Search', 'yulai-federation-wiki'); ?>" />
    </label>
    <input type="submit" class="search-submit" value="<?php echo __('Search', 'yulai-federation-wiki'); ?>" />
</form>
