<?php
require_once(UF_PLUGIN_FRAMEWORK_LIBRARY . '/class.UfOption.php');
require_once(UF_PLUGIN_FRAMEWORK_LIBRARY . '/class.UfOptionGroup.php');
require_once(UF_PLUGIN_FRAMEWORK_LIBRARY . '/class.UfOptionsPage.php');
require_once(UF_PLUGIN_FRAMEWORK_LIBRARY . '/class.UfPlugin.php');
require_once(UF_SEARCH_PLUGIN_BASE . '/controllers/class.UfSearchController.php');
require_once(UF_SEARCH_PLUGIN_BASE . '/models/class.UfSearchSource.php');


if (! class_exists('UfSearchPlugin')) {
	class UfSearchPlugin extends UfPlugin {
		var $sources = array();

		function UfSearchPlugin($name, $file, $sources) {
			$options = array(
				new UfOptionGroup('General', array(
					new UfOption('uf_search_default_source_name', 'this', 'Default source'),
				)),
			);
			$this->add_admin_page(new UfOptionsPage($name, '', $options));

			$this->sources = $sources;

			$this->{get_parent_class(__CLASS__)}($name, $file);
		}

		function add_plugin_hooks() {
			parent::add_plugin_hooks();

			$controller = new UfSearchController($this->sources, get_option('uf_search_default_source_name'));
			$this->register_action($controller, 'search');
		}

		function add_source($name, $source) {
			$this->sources[$name] = $source;
		}
	}
}
?>
