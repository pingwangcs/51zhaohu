<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 */
?>

<div>
	<?php echo elgg_view('input/text', array('name' => 'username', 'placeholder' => elgg_echo('loginusername'))); ?>
</div>
<div>
	<?php echo elgg_view('input/password', array('name' => 'password', 'placeholder' => elgg_echo('password'))); ?>
</div>

<?php echo elgg_view('login/extend'); ?>

<div>
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('login'), 'data-role' =>'none','class'=>'account-button account-input')); ?>

	<label class="right mtm">
		<input type="checkbox" name="persistent" value="true" data-role='none'/>
		<?php echo elgg_echo('user:persistent'); ?>
	</label>
	
	<?php 
	if ($vars['returntoreferer']) { 
		echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
	}
	?>
</div>

<div>
	<?php 
	if (elgg_get_config('allow_registration')) {
		echo elgg_view("output/url", array(
				"class" => "elgg-button account-url account-input register-url",
				"href" => elgg_get_site_url().'register' ,
				"text" => elgg_echo('register'))
		);
	}
	?>
	<label class="right mtm">
		<a class="forgot_link" href="<?php echo elgg_get_site_url(); ?>forgotpassword">
		<?php echo elgg_echo('user:password:lost'); ?>
	</a></label>
</div>

