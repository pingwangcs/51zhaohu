<?php

/**
 * wrap a div with given class around the given content
 *
 * @uses $vars['content'] Content HTML for the div
 * @uses $vars['div_class'] div class to apply
 */
	$content = $vars["content"];
	$class = $vars["div_class"];
	$id = $vars["div_id"];
	
	$output = "";
	$output .= '<div id="' . $id . '" class="' . $class . '">';
	$output .= $content . '</div>';
	
	echo $output;
	