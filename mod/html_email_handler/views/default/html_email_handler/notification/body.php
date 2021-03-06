<?php
	$title = $vars["title"];
	$message = nl2br($vars["message"]);
	$language = get_current_language();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $language; ?>" lang="<?php echo $language; ?>">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<base target="_blank" />
		
		<?php
			if(!empty($title)){
				echo "<title>" . $title . "</title>\n";
			}
		?>
	</head>
	<body>
		<style type="text/css">
			body {
				font: 12px/17px "Arial,Helvetica,sans-serif;
				color: #333333;
			}
			
			a {
				color: #4690d6;
			}
			
			#notification_container {
				padding: 20px 0;
				width: 600px;
				margin: 0 auto;
			}
		
			#notification_header {
				text-align: right;
				padding: 0 0 10px;
			}
			
			#notification_header a {
				text-decoration: none;
				font-weight: bold;
				color: #0054A7;
				font-size: 18px;
			}
		
			#notification_wrapper {
				background: #DEDEDE;
				padding: 10px;
			}
			
			#notification_wrapper h2 {
				margin: 5px 0 5px 10px;
				color: #0054A7;
				font-size: 16px;
				line-height: 20px;
			}
			
			#notification_content {
				background: #FFFFFF;
				padding: 10px;
			}
			
			#notification_footer {
				
				margin: 10px 0 0;
				background: #B6B6B6;
				padding: 10px;
				text-align: right;
			}
			
			#notification_footer_logo {
				float: left;
			}
			
			#notification_footer_logo img {
				border: none;
			}
			
			.clearfloat {
				clear:both;
				height:0;
				font-size: 1px;
				line-height: 0px;
			}
			
		</style>
	
		<div id="notification_container">
					<?php echo $message; ?>
		</div>
	</body>
</html>