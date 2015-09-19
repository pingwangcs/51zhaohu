<?php 

	if($vars["full"]) {
		$zhaohu = $vars["entity"];
		if($zhaohu->videoUrl)
			echo elgg_view("zhaohu_manager/zhaohu/video_view", $vars);
		else
			echo elgg_view("zhaohu_manager/zhaohu/view", $vars);
    }elseif(elgg_in_context("sidebar")) {
    	$zhaohu = $vars["entity"];
    	$output .= '<div class="zhaohu_manager_zhaohu_view_owner"><a href="' . $zhaohu->getURL() . '">' 
    			. $zhaohu->title . '</a></div>';    	
    	echo $output;
    } 
    elseif(elgg_in_context("maps")) {    
        $zhaohu = $vars["entity"];
        
        $output = '<div class="gmaps_infowindow">';
        $output .= '<div class="gmaps_infowindow_text">';
        $output .= '<div class="zhaohu_manager_zhaohu_view_owner"><a href="' . $zhaohu->getURL() . '">' . $zhaohu->title . '</a> (' . date(ZHAOHU_MANAGER_FORMAT_DATE, $zhaohu->start_day) . ')</div>';
        $output .= $zhaohu->getLocation(true) . '<br />';
        $output .= elgg_view("zhaohu_manager/zhaohu/actions", $vars) . '</div>';
        if($zhaohu->icontime){
            $output .= '<div class="gmaps_infowindow_icon"><img src="' . $zhaohu->getIcon('medium') . '" /></div>';
        }
        $output .= '</div>';    

        echo $output;
    }
    elseif(elgg_in_context("recommended_zhaohu"))
    {
    	$zhaohu = $vars["entity"];
    	$owner = $zhaohu->getOwnerEntity();
    	 
    	$content = '<div class="recommended-zhaohu-item">';
    	 
    	$zhaohu_link = elgg_view('output/url', array(
    			'href' => $zhaohu->getURL(),
    			'text' => $zhaohu->title,
    			'is_trusted' => true
    	));
    	$content .= '<div class="recommended-zhaohu-item-title">' . $zhaohu_link . '</div>';
    	 
    	$content .= '<div class="recommended-zhaohu-item-time"><label>' . elgg_echo('zhaohu:time') . ': </label>';
    	$content .= date("Y-m-d", $zhaohu->start_day) . " " . date('H', $zhaohu->start_time) . ':' . date('i', $zhaohu->start_time);
    	$content .= '</div>';
    	 
    	$owner_link = elgg_view('output/url', array(
    			'href' => $owner->getURL(),
    			'text' => $owner->name,
    			'is_trusted' => true
    	));
    	
    	$author_text = elgg_echo('zhaouhu:initiated_by');
    	$content .= '<div class="recommended-zhaohu-item-author"><label>' . $author_text . '</label>' . ': ' . $owner_link . "</div>";
    	
    	// group
    	$group = $zhaohu->getContainerEntity();
    	$group_link = elgg_view('output/url', array(
    			'href' => $group->getURL(),
    			'text' => $group->name,
    			'is_trusted' => true
    	));
    	$group_text = elgg_echo('zhaouhu:group_of');
    	$content .= '<div class="recommended-zhaohu-item-group"><label>' . $group_text . '</label>' . ': ' . $group_link .' </div>';
    	 
    	$content .= '</div>';

    	// icon
    	$icon = elgg_view_entity_icon($zhaohu, "medium");
    	
    	echo elgg_view_image_block($icon, $content, array("class" => "recommended-zhaohu-item-div"));
    }
    else {
        $zhaohu = $vars["entity"];
        $owner = $zhaohu->getOwnerEntity();
        $group = $zhaohu->getContainerEntity(); // Get group
		
		$content = "";
		$subtitle = "";
		
        // Time
        $content .= '<div><label>' . elgg_echo('zhaohu:start_time') . '</label>: ' . date(ZHAOHU_MANAGER_FORMAT_DATE, $zhaohu->start_day) . " ". date('H:i', $zhaohu->start_time);
        // optional end time
        if ($zhaohu->end_ts) {
        	$content .= '&nbsp;&nbsp;&nbsp;&nbsp;<label>' . elgg_echo('zhaohu:end_time') . '</label>: ' . date(ZHAOHU_FORMAT_TS, $zhaohu->end_ts);
        }
        $content .= '</div>';
        
        // zhaohu owner
        $owner_link = elgg_view('output/url', array(
        		'href' => $owner->getURL(),
        		'text' => $owner->name,
        		'is_trusted' => true
        ));
        
        $author_text = elgg_echo('zhaouhu:initiated_by');
        $content .= '<div><label>' . $author_text . '</label>' . ': ' . $owner_link;
        
        // group
        $group_link = elgg_view('output/url', array(
        		'href' => $group->getURL(),
        		'text' => $group->name,
        		'is_trusted' => true
        ));
        $group_text = elgg_echo('zhaouhu:group_of');
        $content .= '&nbsp;&nbsp;&nbsp;&nbsp;<label>' . $group_text . '</label>' . ': ' . $group_link .' </div>';
        
    	// location
        $content .= '<div><label>' . elgg_echo('zhaohu:location') . "</label>: " . $zhaohu->location . '</div>';
        
        if($zhaohu->status == 'published') {
        	$content .= elgg_view("zhaohu_manager/zhaohu/actions", $vars);
        }
        else {
        	$content .= elgg_echo($zhaohu->status);
        }       
        
        // icon
        $icon = elgg_view_entity_icon($zhaohu);
       
		$params = array(
			'entity' => $zhaohu,
			'metadata' => '',//$menu
			'subtitle' => '',//$subtitle
			'tags' => false,
			'content' => $content,
		);
		$params = $params + $vars;
		
		$list_body = elgg_view('object/elements/summary', $params);
		if($zhaohu->featured_zh == "y")
		{
			$featured_icon_url = elgg_get_site_url() . "mod/zhaohu_theme/images/V-2.png";
			echo "<div class='zhaohu-featured-event-div'><img src=\"{$featured_icon_url}\" class='zhaohu-featured-event-icon'></div>";
		}
		echo elgg_view_image_block($icon, $list_body, array('class' => 'zhaohu-image-block'));

    }
