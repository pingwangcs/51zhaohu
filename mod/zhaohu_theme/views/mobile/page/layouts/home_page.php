<?php
/**
 * Zhaohu mobile home page layout
 *
 *
 * @uses $vars['content'] Content string
 * @uses $vars['class']   Additional class to apply to layout
 */

$class = 'zhaohu-mobile-home-page elgg-layout';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

?>
<div class="<?php echo $class; ?>">
	<div class="elgg-body elgg-main zhaohu-mobile-body">
	<?php

		if (isset($vars['title'])) {
			echo elgg_view_title($vars['title']);
		}

		echo $vars['content'];
		
		// @deprecated 1.8
		if (isset($vars['area1'])) {
			echo $vars['area1'];
		}
	?>
	</div>
</div>