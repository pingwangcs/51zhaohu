<?php
/**
 * Zhaohu home page layout
 *
 *
 * @uses $vars['content'] Content string
 * @uses $vars['class']   Additional class to apply to layout
 */

$class = 'zhaohu-home-page elgg-layout';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

?>
<div class="<?php echo $class; ?>">
	<div class="elgg-body elgg-main">
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