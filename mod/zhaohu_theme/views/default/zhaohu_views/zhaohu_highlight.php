<?php
/**
 * zhaohu highlight view, the div contain images with slogans 
 *
 */

$site_url = elgg_get_site_url();

$left_arrow_link = elgg_view('zhaohu_views/zhaohu_link', array(
		'href' => '#',
		'id' => 'zhaohu_homepage_left_arrow',
		'text' => elgg_view('output/img', array(
				'src' => $site_url . "mod/zhaohu_theme/images/left_arrow.png",
				'alt' => 'left arrow',
				'onclick' => "zhaohu_change_homepage_background_manual(-1);",
				'class' => 'zhaohu-arrow-img')
		)
));

$right_arrow_link = elgg_view('zhaohu_views/zhaohu_link', array(
		'href' => '#',
		'id' => 'zhaohu_homepage_right_arrow',
		'text' => elgg_view('output/img', array(
				'src' => $site_url . "mod/zhaohu_theme/images/right_arrow.png",
				'alt' => 'right arrow',
				'onclick' => "zhaohu_change_homepage_background_manual(1);",
				'class' => 'zhaohu-arrow-img')
		)
));

$left_arrow_div = "<div id=\"zhaohu_homepage_left_arrow_div\" class=\"zhaohu-arrow-div\">$left_arrow_link</div>";
$right_arrow_div = "<div id=\"zhaohu_homepage_right_arrow_div\" class=\"zhaohu-arrow-div\">$right_arrow_link</div>";

$content_inside = '<a href="#" id="zhaohu-homepage-background-link" class="new-year-background"></a>' . $left_arrow_div . $right_arrow_div;
echo "<div id=\"zhaohu_highlight_div\" class=\"zhaohu_highlight\">$content_inside</div>";
?>

<script type="text/javascript">

ImageNames = new Object();
ImageNames[0] = "table_game.png";
ImageNames[1] = "watch_movie.jpg";
ImageNames[2] = "zhaohu_homepage_new.jpg";
ImageNames[3] = "cute_background.jpg";
ImageNames.length = 4;
image_index = 0;

var background_change_interval = setInterval(zhaohu_change_homepage_background_auto, 6000);

function zhaohu_change_homepage_background_auto(){
	zhaohu_change_homepage_background(1);
}

function zhaohu_change_homepage_background_manual(direction){
	clearInterval(background_change_interval);
	zhaohu_change_homepage_background(direction);
}

function zhaohu_change_homepage_background(direction){
	image_index += direction;
	if(image_index < 0)
		image_index = ImageNames.length - 1;
	if(image_index > ImageNames.length - 1)
		image_index = 0;
	
	background_link = document.getElementById('zhaohu-homepage-background-link');
	if(image_index == 0 )
		background_link.className = 'new-year-background';
	else
		background_link.className = 'default-background';
    image_url = "url(/mod/zhaohu_theme/images/" + ImageNames[image_index] + ")";
    div = document.getElementById('zhaohu_highlight_div');
    div.style.backgroundImage = image_url;
}
</script>
