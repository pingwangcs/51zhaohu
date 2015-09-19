<?php
/**
 * Zhaohu inside group layout for main column with one sidebar
 *
 * @uses $vars['content'] Content HTML for the main column
 * @uses $vars['sidebar'] Optional content that is displayed in the sidebar
 * @uses $vars['class']   Additional class to apply to layout
 * @uses $vars['sidebar_class']   Additional sidebar class to apply to layout
 * @uses $vars['sidebar_id']   sidbar div id
 */

$class = 'elgg-layout elgg-layout-one-sidebar zhaohu-group-one-sidebar clearfix';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

$sidebar_class = 'elgg-sidebar';
if (isset($vars['sidebar_class'])) {
	$sidebar_class = "$sidebar_class {$vars['sidebar_class']}";
}

$sidebar_id = 'elgg_sidebar';
if (isset($vars['sidebar_id'])) {
	$sidebar_id = "{$vars['sidebar_id']}";
}

?>

<div class="<?php echo $class; ?>">
	<div id="<?php echo $sidebar_id; ?>" class="<?php echo $sidebar_class; ?>">
		<?php
			echo elgg_view('page/elements/sidebar', $vars);
		?>
	</div>

	<div class="elgg-main elgg-body">
		<?php
			// @todo deprecated so remove in Elgg 2.0
			if (isset($vars['area1'])) {
				echo $vars['area1'];
			}
			if (isset($vars['content'])) {
				echo $vars['content'];
			}
		?>
	</div>
</div>

