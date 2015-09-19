<?php
/**
 * Group and zhaohu tag-based search form and result divs in mobile view
 */
elgg_load_js("zhaohu_manager.search");
$loaded_js = elgg_get_loaded_js();


echo '<div id="zhaohu_search_and_result_mobile_div">';

# the mobile search bar

$site_url = elgg_get_site_url();
$search_img ='<img id="zhaohu_mobile_search_img" src="' . $site_url . 'mod/zhaohu_theme/images/search.png">';
$location_selector = '<select id="search_location_state" name="State">
                            <option value="WA">WA</option>
							<option value="CA">CA</option>
                      </select>';
$search_input = '<input type="search" id="zhaohu_mobile_search_input" placeholder="' . elgg_echo("zhaohu:find_zhaohu") . '">';
$search_button = '<a href="#" id="zhaohu_mobile_search_button">' . $search_img . '</a>';
echo '<div id="zhaohu_mobile_zhaohu_search">' . $location_selector . $search_input. $search_button . '</div>';

echo elgg_view("zhaohu_manager/recommended_zhaohus");
# the search result div
echo '<div id="zhaohu_search_result_mobile_div">';
echo "<div id='find_result_groups_mobile'></div>";
echo "<div id='find_result_zhaohus_mobile'></div>";
echo '</div>';
echo '</div>';
?>
