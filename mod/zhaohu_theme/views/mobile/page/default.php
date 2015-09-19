<?php
/**
 * Elgg mobile pageshell TODO: clean this up for mobile
 * The standard HTML page shell that everything else fits into
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['title']       The page title
 * @uses $vars['body']        The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

// render content before head so that JavaScript and CSS can be loaded. See #4032
if(!elgg_is_from_app()){
	$topbar = elgg_view('page/elements/topbar', $vars);
}
$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));
$body = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);

// Set the content type
header("Content-type: text/html; charset=UTF-8");

$lang = get_current_language();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang; ?>" lang="<?php echo $lang; ?>">
<head>
<?php echo elgg_view('page/elements/head', $vars); ?>
<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-54513675-1', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');
</script>
<div class="elgg-page elgg-page-default zhaohu-mobile-view-body">
	<div class="elgg-page-messages">
		<?php echo $messages; ?>
	</div>

	<div class="elgg-page-topbar">
		<div class="elgg-inner">
			<?php echo $topbar; ?>
		</div>
	</div>
	
	<div class="elgg-page-body">
		<div class="elgg-inner">
			<?php echo $body; ?>
		</div>
	</div>
	<div class="elgg-page-footer">
		<div class="elgg-inner">
			<?php echo $footer; ?>
		</div>
	</div>
</div>
</body>
</html>