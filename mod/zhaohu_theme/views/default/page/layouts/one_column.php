<?php
/**
 * Zhaohu one-column layout
 *
 *
 * @uses $vars['content'] Content string
 * @uses $vars['class']   Additional class to apply to layout
 */

$class = 'elgg-layout elgg-layout-one-column zhaohu-one-column clearfix';
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
