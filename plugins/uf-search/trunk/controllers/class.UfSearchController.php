<?php
require_once(UF_PLUGIN_FRAMEWORK_LIBRARY . '/class.UfController.php');


if (! class_exists('UfSearchController')) {
	class UfSearchController extends UfController {
		var $sources = array();
		var $default = 'this';

		function UfSearchController($sources, $default) {
			$this->sources = $sources;
			$this->default = $default;

			$this->{get_parent_class(__CLASS__)}();
		}

		function handle_search_action() {
			$source = $_REQUEST['source'];
			$query = $_REQUEST['query'];

			$sources = $this->sources;
			$default = $this->default;

			$default_source = $sources[$default];

			$selected_source = ($sources[$source]) ? $sources[$source] : $default_source;
			$selected_source->search($query);
		}
	}
}
?>
