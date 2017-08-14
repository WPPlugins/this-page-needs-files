<?php
namespace be\mch\tpnf;

if (!defined('BE_MCH_TPNF')) {
	return;
}

require_once(__DIR__ . '/../model/urls.php');
require_once(__DIR__ . '/../binder/main2urls.php');

if(is_admin()) {
	include(__DIR__ . '/admin.php');
} else {
	include(__DIR__ . '/frontend.php');	
}