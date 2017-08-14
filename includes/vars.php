<?php
// important: no namespace for ths file! PHP 5.0+ Compatible!
if (!defined('BE_MCH_TPNF')) {
	return;
}

// Store a numlber to indicate weither the plugin seems to behave.
define('BE_MCH_TPNF_WORKING', 'BE_MCH_TPNF_WORKING');
define('BE_MCH_TPNF_WORKING_UNDEFINED', 'UNDEFINED');
define('BE_MCH_TPNF_WORKING_FATAL', 'FATAL');
define('BE_MCH_TPNF_WORKING_ERROR', 'ERROR');
define('BE_MCH_TPNF_WORKING_KO', 'KO');
define('BE_MCH_TPNF_WORKING_OK', 'OK');

// Store an number to indicate weither emergency ran validate_all (see emergency.php).
define('BE_MCH_TPNF_EMERGENCY', 'BE_MCH_TPNF_EMERGENCY');
define('BE_MCH_TPNF_EMERGENCY_UNDEFINED', 'UNDEFINED');
define('BE_MCH_TPNF_EMERGENCY_KO', 'KO');
define('BE_MCH_TPNF_EMERGENCY_OK', 'OK');

// Store an number to indicate weither a message after unistall should be displayed.
define('BE_MCH_TPNF_MSG', 'BE_MCH_TPNF_MSG');
define('BE_MCH_TPNF_MSG_UNDEFINED', 'UNDEFINED');
define('BE_MCH_TPNF_MSG_READY', 'READY');
define('BE_MCH_TPNF_MSG_SET', 'SET');
define('BE_MCH_TPNF_MSG_DISMISS', 'DISMISS');

define('BE_MCH_TPNF_ACTIVATION', 'BE_MCH_TPNF_ACTIVATION');
define('BE_MCH_TPNF_ACTIVATION_UNDEFINED', 'UNDEFINED');

// class used for globally shared variables
class BE_MCH_TPNF_VARS {
	static private $errors;
	static public $exWorking;
	static public $working;
	static public $exEmergency;
	static public $emergency;
	static public $exMsg;
	static public $msg;
	static public $exActivation;
	static public $activation;	
	
	static public function load() {
		self::$errors = array();
		self::$working = self::$exWorking = get_option(BE_MCH_TPNF_WORKING, BE_MCH_TPNF_WORKING_UNDEFINED);
		self::$emergency = self::$exEmergency = get_option(BE_MCH_TPNF_EMERGENCY, BE_MCH_TPNF_EMERGENCY_UNDEFINED);
		self::$msg = self::$exMsg = get_option(BE_MCH_TPNF_MSG, BE_MCH_TPNF_MSG_UNDEFINED);
		$activation = get_option(BE_MCH_TPNF_ACTIVATION, BE_MCH_TPNF_ACTIVATION_UNDEFINED);
		
		if ($activation !== BE_MCH_TPNF_ACTIVATION_UNDEFINED) {
			$activation = DateTime::createFromFormat(DateTime::W3C, $activation);
		}
		self::$activation = self::$exActivation = $activation;
	}
	
	static public function store_variable($variable) {
		$bt = debug_backtrace();
		$caller = array_shift($bt);
		
		switch($variable) {
			default:
				if ($variable != null) {
					break;
				}
			case BE_MCH_TPNF_WORKING:
				if (self::$working !== self::$exWorking) {
					self::$exWorking = self::$working;

					if (self::$working !== BE_MCH_TPNF_WORKING_UNDEFINED) {
						update_option(BE_MCH_TPNF_WORKING, self::$working);
					} else {
						delete_option(BE_MCH_TPNF_WORKING);
					}
				}
				if ($variable != null) {
					break;
				}
			case BE_MCH_TPNF_EMERGENCY:
				if (self::$emergency !== self::$exEmergency) {
					self::$exEmergency = self::$emergency;
				
					if (self::$emergency !== BE_MCH_TPNF_EMERGENCY_UNDEFINED) {
						update_option(BE_MCH_TPNF_EMERGENCY, self::$emergency);
					} else {
						delete_option(BE_MCH_TPNF_EMERGENCY);
					}
				}
				if ($variable != null) {
					break;
				}
			case BE_MCH_TPNF_MSG:
				if (self::$msg !== self::$exMsg) {
					self::$exMsg = self::$msg;
				
					if (self::$msg !== BE_MCH_TPNF_MSG_UNDEFINED) {
						update_option(BE_MCH_TPNF_MSG, self::$msg);
					} else {
						delete_option(BE_MCH_TPNF_MSG);
					}
				}
				if ($variable != null) {
					break;
				}
			case BE_MCH_TPNF_ACTIVATION:
				if (self::$activation !== self::$exActivation) {
					self::$exActivation = self::$activation;
			
					if (self::$activation !== BE_MCH_TPNF_ACTIVATION_UNDEFINED) {
						update_option(BE_MCH_TPNF_ACTIVATION, self::$activation->format(DateTime::W3C));
					} else {
						delete_option(BE_MCH_TPNF_ACTIVATION);
					}
				}
				if ($variable != null) {
					break;
				}				
		}
	}
	
	static public function store() {
		self::store_variable(null);
	}
	
	static public function add_error($error) {
		self::$erros[] = $error;
	}
}
BE_MCH_TPNF_VARS::load();
add_action('shutdown', array('BE_MCH_TPNF_VARS', 'store'), 21);