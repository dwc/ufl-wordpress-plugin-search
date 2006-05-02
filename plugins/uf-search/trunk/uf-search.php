<?php
/*
Plugin Name: UF Search
Version: 1.1
Plugin URI: http://www.webadmin.ufl.edu/
Description: Handling of the search form on <a href="http://news.ufl.edu/">University of Florida News</a> and other WordPress sites at UF. Requires the <code>uf-controller</code> plugin.
Author: Daniel Westermann-Clark
Author URI: http://www.webadmin.ufl.edu/
*/

define('UF_SEARCH_PLUGIN_BASE', dirname(__FILE__) . '/');

require_once(PLUGINS_LIBRARY . 'class.UfOption.php');
require_once(PLUGINS_LIBRARY . 'class.UfOptionGroup.php');
require_once(PLUGINS_LIBRARY . 'class.UfOptionsPage.php');
require_once(PLUGINS_LIBRARY . 'class.UfPlugin.php');
require_once('controllers/class.UfSearchController.php');


/*
 * Core plugin code for UF Search.
 */
if (! class_exists('UfSearchPlugin')) {
	class UfSearchPlugin extends UfPlugin {
		function SOURCES() {
			$sources = array(
				'this'      => new UfSearchSource(get_settings('blogname'), get_settings('siteurl') . '/index.php', 's'),
				'web'       => new UfSearchSource('UF Web with Google', 'http://search.ufl.edu/web', 'query'),
				'phonebook' => new UfSearchSource('UF Phonebook', 'http://phonebook.ufl.edu/display_form.cgi', 'person'),
			);

			return $sources;
		}

		function UfSearchPlugin() {
			$this->{get_parent_class(__CLASS__)}('Search', __FILE__);

			$options = array(
				new UfOptionGroup('General', array(
					new UfOption('uf_search_default_source_name', 'this', 'Default source'),
				)),
			);
			$this->options_page = new UfOptionsPage($this->name, '', $options);
		}

		function add_plugin_hooks() {
			parent::add_plugin_hooks();

			$controller = new UfSearchController();
			$this->register_action($controller, 'search');
		}
	}
}

$uf_search_plugin = new UfSearchPlugin();
?>
