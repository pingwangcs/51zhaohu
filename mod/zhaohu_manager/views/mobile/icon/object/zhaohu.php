<?php

	$entity = elgg_extract("entity", $vars);
	$size = elgg_extract("size", $vars, "large");

	$icon = '<div class="zhaohu-manager-zhaohu-view-icon"><a href="' . $entity->getURL() . '" target="_blank"><img src="' . $entity->getIcon($size) . '" border="0" /></a></div>';
	echo $icon;