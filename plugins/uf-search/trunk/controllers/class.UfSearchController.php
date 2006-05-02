<?php
require_once(UF_SEARCH_PLUGIN_BASE . 'models/class.UfSearchSource.php');


if (! class_exists('UfSearchController')) {
	class UfSearchController {
		function handle_search_action() {
			$reqSource = stripslashes($_GET['source']);
			$reqQuery = stripslashes($_GET['query']);

			$sources = UfSearchPlugin::SOURCES();
			$defaultSource = $sources[get_settings('uf_search_default_source_name')];

			$source = ($sources[$reqSource]) ? $sources[$reqSource] : $defaultSource;
			$source->search($reqQuery);
		}
	}
}
?>
