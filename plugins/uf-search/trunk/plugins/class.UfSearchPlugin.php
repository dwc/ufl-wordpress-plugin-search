<?php
require_once(UF_PLUGIN_FRAMEWORK_LIBRARY . '/class.UfPlugin.php');
require_once(UF_PLUGIN_FRAMEWORK_LIBRARY . '/class.UfOption.php');
require_once(UF_PLUGIN_FRAMEWORK_LIBRARY . '/class.UfOptionGroup.php');
require_once(UF_PLUGIN_FRAMEWORK_LIBRARY . '/class.UfOptionsPage.php');
require_once(UF_SEARCH_PLUGIN_BASE . '/controllers/class.UfSearchController.php');
require_once(UF_SEARCH_PLUGIN_BASE . '/models/class.UfSearchSource.php');


if (! class_exists('UfSearchPlugin')) {
	class UfSearchPlugin extends UfPlugin {
		var $sources = array();

		function UfSearchPlugin() {
			$options = array(
				new UfOptionGroup('General', array(
					new UfOption('uf_search_default_source_name', 'this', 'Default source'),
				)),
			);
			$this->options_page = new UfOptionsPage($this->name, '', $options);

			$this->add_source('this',      new UfSearchSource(get_settings('blogname'), get_settings('siteurl') . '/index.php', 's'));
			$this->add_source('web',       new UfSearchSource('UF Web with Google', 'http://search.ufl.edu/web', 'query'));
			$this->add_source('phonebook', new UfSearchSource('UF Phonebook', 'http://phonebook.ufl.edu/people/search', 'query'));

			$this->{get_parent_class(__CLASS__)}('Search', __FILE__);
		}

		function add_plugin_hooks() {
			parent::add_plugin_hooks();

			$controller = new UfSearchController($this->sources, get_settings('uf_search_default_source_name'));
			$this->register_action($controller, 'search');
		}

		function add_source($name, $source) {
			$this->sources[$name] = $source;
		}
	}
}
?>
