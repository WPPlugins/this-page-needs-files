<?php
// important: no namespace for ths file! PHP 5.0+ Compatible!
if (!defined('BE_MCH_TPNF')) {
	return;
}

class BE_MCH_TPNF_Error {
	/*
	@var string
	*/
	var $error;
	
	function __construct($error) {
		$this->error = $error;
	}
	
	function display() {
		$data = tpnf_plugin_data();
		?>
		<div class="error">
			<h1><?php echo($data['Name']); ?></h1>
			<p><?php echo($this->error); ?></p>
		</div>
		<?php
	}
}