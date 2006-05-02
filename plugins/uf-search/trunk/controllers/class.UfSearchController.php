<?php
require_once(UF_NEWS_SEARCH_PLUGIN_BASE . 'models/class.UfNewsSearchSource.php');


if (! class_exists('UfNewsSearchController')) {
	class UfNewsSearchController {
		function handle_search_action() {
			$reqSource = stripslashes($_GET['source']);
			$reqQuery = stripslashes($_GET['query']);

			$sources = UfNewsSearchPlugin::SOURCES();
			$defaultSource = $sources[get_settings('uf_news_search_default_source_name')];

			$source = ($sources[$reqSource]) ? $sources[$reqSource] : $defaultSource;
			$source->search($reqQuery);
		}
	}
}
?>
