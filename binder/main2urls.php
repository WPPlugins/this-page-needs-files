<?php
namespace be\mch\tpnf;

defined('BE_MCH_TPNF')||die();

function tpnf_binder_main2urls() {
	static $returnValue = 0;
	
	if ($returnValue !== 0) {
		return $returnValue;
	}
	
	if (!isset($_REQUEST['tpnf-indices'])) {
		$returnValue = null;
		
		return $returnValue;
	}
	
	// This section might need an emergency check
	// $emergency = new TPNF_Emergency(__NAMESPACE__ . '\tpnf_binder_main2urls');
	
	$fileExtension = '/^(?:.*\/)?(?:\w+\.)+(\w+)[^\/]*$/';
	
	$returnValue = new TPNF_Model_Urls();
	
	$suffixes = explode(',', $_REQUEST['tpnf-indices']);
	
	foreach($suffixes as $suffix) {
		$url = new TPNF_Model_Url();

		$url->File = $_REQUEST[sprintf('tpnf-fileName-%d', $suffix)];		
		
		if (strlen($url->File) < 1) {
			continue;
		}
		
		$url->ID = $_REQUEST[sprintf('tpnf-id-%d', $suffix)];
		$url->Relative = (int)$_REQUEST[sprintf('tpnf-relative-%d', $suffix)];
		
		try {
			new TPNF_Model_Url_ERelative($url->Relative);
		}
		catch (UnexpectedValueException $e) {
			$url->Relative = TPNF_Model_Url_ERelative::None;
		}
		
		$url->Priority = $_REQUEST[sprintf('tpnf-priority-%d', $suffix)];
		switch( $_REQUEST[sprintf('tpnf-type-%d', $suffix)]) {
			case 'auto':
				$url->IDEAuto = true;
				$url->Type = TPNF_Model_Url_EType::None;
				
				$matches = array();
				if (1 === preg_match($fileExtension, $url->File, $matches) && count($matches) == 2) {
					switch (strtolower($matches[1])) {
						case 'js':
							$url->Type = TPNF_Model_Url_EType::Js;
							break;
				
						case 'css':
							$url->Type = TPNF_Model_Url_EType::Css;
							break;
					}
				}
				break;
				
			case 'js':
				$url->IDEAuto = false;
				$url->Type = TPNF_Model_Url_EType::Js;
				break;
				
			case 'css':
				$url->IDEAuto = false;
				$url->Type = TPNF_Model_Url_EType::Css;
				break;
		}
		
		$returnValue->Urls[] = $url;
	}
	
	// $emergency->validate();
	return $returnValue;
}
