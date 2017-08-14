<?php
namespace be\mch\tpnf;

if (!defined('BE_MCH_TPNF')) {
	return;
}

function tpnf_load_main_script() {
	wp_enqueue_script('be_mch_tpnf-main',  plugins_url('js/frontend.js', BE_MCH_TPNF_FILE));
}

function tpnf_acknowledge_footer() {
	echo(
		'<script>Be_Mch_Tpnf.HasFooter = true;</script>'
	);
}

function tpnf_excecute_client_scripts($line) {
	static $lines = array();
	
	if (strlen($line) > 0) {
		$lines[] = $line;
		
		return;
	}
	
	echo(sprintf(
		'<script>Be_Mch_Tpnf.Excecute([%1$s]);</script>'
		, implode(',', $lines)
	));
}

function tpnf_load_client_scripts($post) {
	static $tmpID = 0, $hooked = false, $postsID = array();
	
	if(empty($post)) {
		return;
	}

	// Once per post		
	if (isset($postsID[$post->ID])) {
		return;
	}
	$postsID[$post->ID] = true;
	
	$meta = get_post_meta($post->ID, 'tpnf_urls', true);
	
	if (strlen($meta) < 1) {
		return;
	}
	
	// This section might need an emergency check
	// $emergency = new TPNF_Emergency(__NAMESPACE__ . '\tpnf_main');
	
	$std = json_decode($meta);

	$model = new TPNF_Model_Main();
	$model->Urls = TPNF_Model_Urls::Cast($std);
	
//		die(print_r($model, true));
	
	foreach($model->Urls->Urls as $aUrl) {
		++$tmpID;
		
		$ref = sprintf('be_mch_tpnf-%d', $tmpID);
		$url = sprintf('%1$s%2$s', $model->Relatives[$aUrl->Relative]->Path, $aUrl->File);
		
		switch ($aUrl->Type) {
			case TPNF_Model_Url_EType::Css:
				wp_enqueue_style($ref, $url);
				$ext = 'css';
				break;
			case TPNF_Model_Url_EType::Js:
				// room for improvement
				wp_enqueue_script($ref, 'http://0.0.0.0/' . $ref . '/#' . $url);
				$ext = 'js';
				break;
			default:
				continue;
				break;
		}
		
		tpnf_excecute_client_scripts(sprintf(
			'{Ref:"%1$s",ID:"%2$s",Priority:"%3$s",Type:"%4$s"}'
			, $ref
			, $aUrl->ID
			, $aUrl->Priority
			, $ext
		));
	}
	
	if (!$hooked) {
		add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\tpnf_load_main_script' );
		add_action( 'wp_footer', __NAMESPACE__ . '\tpnf_acknowledge_footer' );
		add_action( 'wp_footer', __NAMESPACE__ . '\tpnf_excecute_client_scripts' );
		$hooked = true;
	}
	
	// $emergency->validate();
}
add_action( 'the_post', __NAMESPACE__ . '\tpnf_load_client_scripts' );