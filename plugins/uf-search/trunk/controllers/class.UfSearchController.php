<?php
require_once(UF_PLUGIN_FRAMEWORK_PLUGIN_LIBRARY . '/class.UfController.php');


if (! class_exists('UfSearchController')) {
	class UfSearchController extends UfController {
		var $sources = array();
		var $default = 'this';

		function UfSearchController($sources, $default) {
			$this->{get_parent_class(__CLASS__)}();

			$this->sources = $sources;
			$this->default = $default;
		}

		function handle_search_action() {
			$source = get_query_var('source');
			$query = get_query_var('query');

			$sources = $this->sources;
			$default = $this->default;

			$default_source = $sources[$default];

			$selected_source = ($sources[$source]) ? $sources[$source] : $default_source;
			$selected_source->search($query);
		}
	}
}
?>
