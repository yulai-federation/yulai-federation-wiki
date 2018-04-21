<?php

echo '<form role="search" method="get" class="search-form" action="' . home_url('/') . '">',
 '<label>',
 '<input type="search" class="search-field" placeholder="' . __('Search', 'yulai-federation-wiki') . '" value="' . get_search_query() . '" name="s" title="' . __('Search', 'yulai-federation-wiki') . '" />',
 '</label>',
 '<input type="submit" class="search-submit" value="' . __('Search', 'yulai-federation-wiki') . '" />',
 '</form>';
