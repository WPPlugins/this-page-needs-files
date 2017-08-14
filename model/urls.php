<?php
namespace be\mch\tpnf;

defined('BE_MCH_TPNF')||die();


class TPNF_SplEnum  {
	public static function InitList() {
		$class = get_called_class();
		$instance = new \ReflectionClass($class);
		
		static::$List = array_flip($instance->getConstants());
	}
	
	public static function GetName($key) {
		return static::$List[$key];
	}
	
	public static function GetList() {
		return static::$List;
	}
}

class TPNF_Model_Url_EType extends TPNF_SplEnum {
	protected static $List;
	
    const __default = self::None;
    
	const None = 0;
    const Css = 1;
    const Js = 2;
}
TPNF_Model_Url_EType::InitList();

class TPNF_Model_Url_ERelative extends TPNF_SplEnum {
	protected static $List;
	
    const __default = self::None;
    
    const None = 0;
    const Admin = 1;
    const Content = 2;
    const Includes = 3;
    const Plugins = 4;
    const Site = 5;
    const Theme = 6;
    const Themes = 7;
}
TPNF_Model_Url_ERelative::InitList();

class TPNF_Model_Url {
	/*
	@var $Type \TPNF_Model_Url_EType
	*/
	public $Type;

	/*
	@var $Type bool
	*/
	public $IDEAuto;
	
	/*
	@var $Relative \TPNF_Model_Url_ERelative
	*/	
	public $Relative;
	
	/*
	@var $File string
	*/
	public $File;

	/*
	@var $ID string
	*/
	public $ID;	

	/*
	@var $Priority string
	*/
	public $Priority;	
	
	function __construct() {
		$this->Type = null;
		$this->IDEAuto = true;
		$this->Relative = new TPNF_Model_Relative(TPNF_Model_Url_ERelative::None);
		$this->File = "";
		$this->ID = "";
	}
	
	static public function Cast($ref) {
		$returnValue = new TPNF_Model_Url();
		
		foreach($returnValue as $key => $value) {
			if (property_exists($ref, $key)) {
				$returnValue->$key = $ref->$key;
			}
		}
		
		return $returnValue;
	}
}

class TPNF_Model_Urls {
	/*
	@var $Version string
	*/
	public $Version;
	
	/*
	@var $Urls \TPNF_Model_Url[]
	*/
	public $Urls;
	
	function __construct() {
		$this->Urls = array();
	}
	
	static public function Cast($ref) {
		$returnValue = new TPNF_Model_Urls();
		
		foreach($returnValue as $key => $value) {
			if (property_exists($ref, $key)) {
				switch($key) {
					default:
						$returnValue->$key = $ref->$key;
						break;
					case 'Urls':
						foreach($ref->Urls as $aUrl) {
							$returnValue->Urls[] = TPNF_Model_Url::Cast($aUrl);
						}
						break;
				}
			}
		}
		
		return $returnValue;
	}
}

class TPNF_Model_Relative {
	/*
	@var $Version \TPNF_Model_Url_ERelative
	*/
	public $Relative;
	
	/*
	@var $Name string
	*/
	public $Name;	
	
	/*
	@var $Path string
	*/
	public $Path;
	
	/*
	@var $Path string
	*/
	public $Label;
	
	/*
	@param $Relative \TPNF_Model_Url_ERelative
	*/
	function __construct($Relative) {
		$this->Label = null;
		
		switch($Relative) {
			default :
				throw new \Exception('Invalid value for $Relative');
				break;

			case TPNF_Model_Url_ERelative::None :
				$this->Path = "";
				$this->Label = "Absolute URL";
				break;
				
			case TPNF_Model_Url_ERelative::Admin :
				$this->Path = admin_url();
				break;

			case TPNF_Model_Url_ERelative::Content :
				$this->Path = content_url();
				break;			
					
			case TPNF_Model_Url_ERelative::Includes :
				$this->Path = includes_url();
				break;
				
			case TPNF_Model_Url_ERelative::Plugins :
				$this->Path = plugins_url();
				break;
				
			case TPNF_Model_Url_ERelative::Site :
				$this->Path = admin_url();
				break;
				
			case TPNF_Model_Url_ERelative::Theme :
				$this->Path = get_template_directory_uri();
				break;
				
			case TPNF_Model_Url_ERelative::Themes :
				$this->Path = get_theme_root_uri();
				break;
		}
		
		// Assert ending slash in Path and copy Path to Label
		if ($this->Label == null && $this->Path != null) {
			if (strpos($this->Path, "/", strlen($this->Path) - 1) === false) {
				$this->Path .= "/";
			}
			
			$this->Label = $this->Path;
		}
		
		$this->Relative = $Relative;
		$this->Name = TPNF_Model_Url_ERelative::GetName($Relative);
	}
}

class TPNF_Model_Main {
	/*
	@var $Urls TPNF_Model_Urls
	*/
	public $Urls;
	
	/*
	@var $Relatives \TPNF_Model_Relative[]
	*/
	public $Relatives;
	
	function __construct() {
		$this->Urls = new TPNF_Model_Urls();
		$this->Relatives = array();
		
		$arrRelatives = TPNF_Model_Url_ERelative::GetList();
		
		foreach($arrRelatives as $aRelative => $aName) {
			$this->Relatives[$aRelative] = new TPNF_Model_Relative($aRelative);
		}
	}
}