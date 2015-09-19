<?php
/**
 * Elgg user display (details) - Zhaohu over-write it
 * @uses $vars['entity'] The user entity
 */

$user = elgg_get_page_owner_entity();

echo elgg_view("output/url", array("href" => "profile/$user->username",
		"class" => "profile-home-mobile",
		"text" => elgg_echo('profile:home_mobile')));

$profile_fields = elgg_get_config('profile_fields');

echo '<div id="profile-details" class="elgg-body pll">';
echo "<h2>{$user->name}</h2>";

echo elgg_view("profile/status", array("entity" => $user));

$even_odd = null;
if (is_array($profile_fields) && sizeof($profile_fields) > 0) {
	foreach ($profile_fields as $shortname => $valtype) {
		if ($shortname == "description") {
			// skip about me and put at bottom
			continue;
		}
		$value = $user->$shortname;

		if (!empty($value)) {

			// fix profile URLs populated by https://github.com/Elgg/Elgg/issues/5232
			// @todo Replace with upgrade script, only need to alter users with last_update after 1.8.13
			if ($valtype == 'url' && $value == 'http://') {
				$user->$shortname = '';
				continue;
			}

			// validate urls
			if ($valtype == 'url' && !preg_match('~^https?\://~i', $value)) {
				$value = "http://$value";
			}

			// this controls the alternating class
			$even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';
			if ($shortname == "birthMonth" || $shortname == "birthDay" ) {
				continue;
			}
			if ($shortname == "birthYear")
				$shortname = "birthdate"
			?>
			<div class="<?php echo $even_odd; ?>">
				<b><?php echo elgg_echo("profile:{$shortname}"); ?>: </b>
				<?php
				if ($shortname == "birthdate") {
					echo elgg_view("output/dropdown", array('value' => $user->birthYear));
					echo '-' .elgg_view("output/dropdown", array('value' => $user->birthMonth));
					echo '-' .elgg_view("output/dropdown", array('value' => $user->birthDay));
				} else
					echo elgg_view("output/{$valtype}", array('value' => $value));
				?>
			</div>
			<?php
		}
	}
}

if (!elgg_get_config('profile_custom_fields')) {
	if ($user->isBanned()) {
		echo "<p class='profile-banned-user'>";
		echo elgg_echo('banned');
		echo "</p>";
	} else {
		if ($user->description) {
			echo "<p class='profile-aboutme-title'><b>" . elgg_echo("profile:aboutme") . "</b></p>";
			echo "<div class='profile-aboutme-contents'>";
			echo elgg_view('output/longtext', array('value' => $user->description, 'class' => 'mtn'));
			echo "</div>";
		}
	}
}

// render joined group for the user
echo elgg_view('profile/joined_groups');

echo '</div>';