<?php
namespace be\mch\tpnf;

if (!defined('BE_MCH_TPNF')) {
	return;
}

function tpnf_load_admin_scripts() {
	wp_enqueue_style('tpnf-main', plugins_url('css/main.css', BE_MCH_TPNF_FILE));
	wp_enqueue_script('tpnf-main', plugins_url('js/main.js', BE_MCH_TPNF_FILE));
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\tpnf_load_admin_scripts', 1);

function tpnf_main() {
	global $post, $wp_current_filter;
	
	// This section might need an emergency check
	// $emergency = new TPNF_Emergency(__NAMESPACE__ . '\tpnf_main');
	
	//throw new \Exception(print_r($wp_current_filter, true) . ':D');
	
	$model = new TPNF_Model_Main();
	
	$model->Urls = tpnf_binder_main2urls();
	
	if ($model->Urls == null) {
		$meta = get_post_meta($post->ID, 'tpnf_urls', true);
		
		if (strlen($meta) > 0) {
			$std = json_decode($meta);
	
			$model->Urls = TPNF_Model_Urls::Cast($std);
		} else {			
			$model->Urls = new TPNF_Model_Urls();
		}
	}

	$model->Urls->Urls[] = new TPNF_Model_Url();
	
	include __DIR__ . '/../templates/main.php';
	
	// $emergency->validate();
}
function tpnf_add_meta_boxes() {
	add_meta_box( 
		'tpnf_meta_box'
		, 'This page needs files'
		, __NAMESPACE__ . '\tpnf_main'
		, null
		, 'advanced'
		, 'high'
	);
}
add_action('add_meta_boxes', __NAMESPACE__ . '\tpnf_add_meta_boxes');	

function tpnf_save_meta_box($post_id) {
	$urls = tpnf_binder_main2urls();
	
	if($urls != null) {
		if (count($urls->Urls) > 0) {
			update_post_meta($post_id, 'tpnf_urls', json_encode($urls));
		}
		else {
			delete_post_meta($post_id, 'tpnf_urls');
		}
	}
}
add_action('save_post', __NAMESPACE__ . '\tpnf_save_meta_box');


function tpnf_deleted_meta_box($post_id) {
	delete_post_meta($post_id, 'tpnf_urls');
}
add_action('delete_post', __NAMESPACE__ . '\tpnf_deleted_meta_box');