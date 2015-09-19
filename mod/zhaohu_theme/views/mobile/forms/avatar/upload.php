<?php
/**
 * Avatar upload form
 * 
 * @uses $vars['entity']
 */

?>
<div>
	<label><?php echo elgg_echo("avatar:upload"); ?></label><br />
	<?php echo elgg_view("input/file",array('name' => 'avatar')); ?>
</div>
<div class="elgg-foot">
	<?php echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->guid)); ?>
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('upload'))); ?>
	<?php echo 	elgg_view('output/url', array(
			'text' => elgg_echo('cancel'),
			'href' => $vars['entity']->getURL(),
			'class' => 'elgg-button elgg-button-cancel',
	)); ?>
</div>
