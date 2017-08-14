<?php
/**
 * Plugin Name: This page needs file
 * Description: Allow to include urls to javascript and css files inside the HTML header on a page/post specifc basis.
 * Version: 1.0.7
 * Date: 29/05/2015
 * Author: Jacquemin Serge
 * Author URI: https://profiles.wordpress.org/sergejack
**/
// important: no namespace for ths file! PHP 5.0+ Compatible!
define('BE_MCH_TPNF', true);
define('BE_MCH_TPNF_FILE', __FILE__);
define('BE_MCH_TPNF_PATH', basename(dirname(BE_MCH_TPNF_FILE)) . '/' . basename(BE_MCH_TPNF_FILE));
define('BE_MCH_TPNF_ACT_DELAY', 'P7D');

// define('WP_DEBUG', true);

include(dirname(BE_MCH_TPNF_FILE) . '/includes/vars.php');

function tpnf_activate() {
	BE_MCH_TPNF_VARS::$working = BE_MCH_TPNF_WORKING_KO;
	BE_MCH_TPNF_VARS::$emergency = BE_MCH_TPNF_EMERGENCY_OK;
	BE_MCH_TPNF_VARS::$msg = BE_MCH_TPNF_MSG_READY;
	BE_MCH_TPNF_VARS::$activation = new DateTime();
	
	BE_MCH_TPNF_VARS::store();
}
register_activation_hook(BE_MCH_TPNF_FILE, 'tpnf_activate');

function tpnf_uninstall()
{
	BE_MCH_TPNF_VARS::$msg = BE_MCH_TPNF_MSG_UNDEFINED;
	BE_MCH_TPNF_VARS::$working = BE_MCH_TPNF_WORKING_UNDEFINED;
	BE_MCH_TPNF_VARS::$emergency = BE_MCH_TPNF_EMERGENCY_UNDEFINED;
	BE_MCH_TPNF_VARS::$activation = BE_MCH_TPNF_ACTIVATION_UNDEFINED;
	
	BE_MCH_TPNF_VARS::store();
}
register_deactivation_hook(BE_MCH_TPNF_FILE, 'tpnf_uninstall');

switch(BE_MCH_TPNF_VARS::$msg) {
	case BE_MCH_TPNF_MSG_UNDEFINED :
		BE_MCH_TPNF_VARS::$msg = BE_MCH_TPNF_MSG_READY;
		BE_MCH_TPNF_VARS::$activation = new DateTime();
		
		// Go on....
	case BE_MCH_TPNF_MSG_READY :
		$dateMin = new DateTime();
		$dateMin->sub(new DateInterval(BE_MCH_TPNF_ACT_DELAY));
	
		if (BE_MCH_TPNF_VARS::$activation >= $dateMin) {
			break;
		} else {
			BE_MCH_TPNF_VARS::$msg = BE_MCH_TPNF_MSG_SET;
			// Go on....
		}
	case BE_MCH_TPNF_MSG_SET :
		function tpnf_uninstalled() {
			$data = tpnf_plugin_data();
			$delay = BE_MCH_TPNF_VARS::$activation->diff(new DateTime());
			?>
			<div class="updated tpnf-msg">
				<h1><?php echo($data['Name']); ?></h1>
				<p>
					Hey, is this plugin meeting your needs?
				</p>
				<p>
					Please tell us about it on the official Wordpress website.
                    <br/>
                    <a href="https://wordpress.org/support/view/plugin-reviews/this-page-needs-files#postform" data-dismiss="<?php echo(add_query_arg('tpnf-action-dismiss', 'true')); ?>"  target="_blank">Give us feedback</a>.
                    <br/>
				</p>
                <p>
                    Not in the mood to give us a bit of feedback?
                    <br/>
                    <a href="<?php echo(add_query_arg('tpnf-action-dismiss', 'true')); ?>">Dismiss this message</a>
                </p>
                <p>
   					Thank for having used <strong><?php echo($data['Name']); ?></strong> for <?php echo($delay->format('%a')); ?> days. We'll keep working to improve it.
                </p>
			</div>
			<?php
		}
		
		if ($_GET[sanitize_key( 'tpnf-action-dismiss' )] == 'true') {
			BE_MCH_TPNF_VARS::$msg = BE_MCH_TPNF_MSG_DISMISS;
			BE_MCH_TPNF_VARS::store_variable(BE_MCH_TPNF_MSG);
		} else {
			add_action('admin_notices', 'tpnf_uninstalled');
		}
		
		break;
}

if ($_GET[sanitize_key( 'tpnf-action-reactivate' )] == 'true') {
	BE_MCH_TPNF_VARS::$working = BE_MCH_TPNF_WORKING_KO;
	BE_MCH_TPNF_VARS::$emergency = BE_MCH_TPNF_EMERGENCY_OK;
}

function tpnf_plugin_data() {
	return get_plugin_data(BE_MCH_TPNF_FILE);
}

require_once(dirname(BE_MCH_TPNF_FILE) . '/includes/error.php');
require_once(dirname(BE_MCH_TPNF_FILE) . '/includes/requirements.php');

// BE_MCH_TPNF_VARS::$working = BE_MCH_TPNF_WORKING_OK;

function tpnf_run() {
	if (BE_MCH_TPNF_VARS::$working === BE_MCH_TPNF_WORKING_FATAL) {
		$err = new BE_MCH_TPNF_Error(sprintf(
			'An potent fatal error has previously been encoutered.%1$s
			This plugin has put itself on a halted state and currently prevents itself from running.%1$s
			Please click on "reactivate" when/if you think the issue has been fixed.%1$s
			%1$s
			<a href="%2$s">Reactivate</a>%1$s
			%1$s
			<a href="https://wordpress.org/support/plugin/this-page-needs-files#latest" target="_blank">Contact support</a>
			'
			, '<br/>'
			, add_query_arg('tpnf-action-reactivate', 'true')
		));
		add_action('admin_notices', array($err, 'display'));
		
		return;
	}
	
	if (BE_MCH_TPNF_VARS::$working === BE_MCH_TPNF_WORKING_ERROR) {
		$err = new BE_MCH_TPNF_Error(sprintf(
			'An unexpected error has previously been encoutered.%1$s
			%1$s
			<a href="https://wordpress.org/support/plugin/this-page-needs-files#latest" target="_blank">Contact support</a>
			'
			, '<br/>'
		));
		add_action('admin_notices', array($err, 'display'));
	}
	
	if (BE_MCH_TPNF_VARS::$working !== BE_MCH_TPNF_WORKING_OK) {
		// maybe plugin could start "working" due to a change of environement
		tpnf_check_requirements();
	}
	
	if (BE_MCH_TPNF_VARS::$working === BE_MCH_TPNF_WORKING_OK) {
		try {
			include(dirname(BE_MCH_TPNF_FILE) . '/includes/program.php');
		}
		catch (Exception $e) {
			$err = new BE_MCH_TPNF_Error($e->getMessage());
			add_action('admin_notices', array($err, 'display'));
		}
	}
}
add_action('plugins_loaded', 'tpnf_run');

function tpnf_add_action_links($links) {
	array_push(
		$links
		, '<a href="https://wordpress.org/support/plugin/this-page-needs-files#latest" target="_blank">Get Support</a>'
	);
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename(BE_MCH_TPNF_FILE), 'tpnf_add_action_links'); 