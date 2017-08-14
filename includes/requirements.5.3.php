<?php
// Precond: PHP 5.3+
namespace be\mch\tpnf;

if (!defined('BE_MCH_TPNF')) {
	return;
}


class Check_Constants
{
	const A = 1;
	const B = self::A;
	
	static function tryGetConstants() {
		try {
			$class = get_called_class();
			$instance = new \ReflectionClass($class);
			// might throw a Fatal error
			array_flip($instance->getConstants());
			
			return true;
		}
		catch (Exception $e) {
			return false;
		}			
	}	
}

if (!Check_Constants::tryGetConstants()) {
	$err = new BE_MCH_TPNF_Error('This version of PHP doesn\'t support <a href="http://php.net/manual/reflectionclass.getconstants.php" target="_blank">getConstants</a>');
	add_action('admin_notices', array($err, 'display'));
	
	return false;
}

return true;