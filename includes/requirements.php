<?php
// important: no namespace for ths file! PHP 5.0+ Compatible!
if (!defined('BE_MCH_TPNF')) {
	return;
}

function tpnf_check_requirements()
{
	static $alreadyChecked = false;
	
	if ($alreadyChecked) {
		return;
	}
	$alreadyChecked = true;
	
	// Fatal error until proven otherwise
	BE_MCH_TPNF_VARS::$working = BE_MCH_TPNF_WORKING_FATAL;
	try {
		// Expected behaviour: requirement met or not
		BE_MCH_TPNF_VARS::$working = tpnf_check_requirements_work() ? BE_MCH_TPNF_WORKING_OK : BE_MCH_TPNF_WORKING_KO;
	} catch (Exception $e) {
		// Unexpected error
		BE_MCH_TPNF_VARS::$working = BE_MCH_TPNF_WORKING_ERROR;
	}
}

function tpnf_check_requirements_work()
{
	require_once(dirname(BE_MCH_TPNF_FILE) . '/includes/error.php');
	
	if (version_compare(PHP_VERSION, '5.3.0') < 0) {
		$err = new BE_MCH_TPNF_Error('PHP >= 5.3.0 required');
		add_action('admin_notices', array($err, 'display'));
		
		return false;
	}
	
	return include('requirements.5.3.php');
}