<?php
/*
Plugin Name: UF News Search
Version: 1.1
Plugin URI: http://www.webadmin.ufl.edu/
Description: Handling of the search form on <a href="http://news.ufl.edu/">University of Florida News</a>.
Author: Daniel Westermann-Clark
Author URI: http://www.webadmin.ufl.edu/
*/

define('UF_NEWS_SEARCH_PLUGIN_BASE', dirname(__FILE__) . '/');

require_once(PLUGINS_LIBRARY . 'class.UfNewsOption.php');
require_once(PLUGINS_LIBRARY . 'class.UfNewsOptionGroup.php');
require_once(PLUGINS_LIBRARY . 'class.UfNewsOptionsPage.php');
require_once(PLUGINS_LIBRARY . 'class.UfNewsPlugin.php');
require_once('controllers/class.UfNewsSearchController.php');


/*
 * Core plugin code for UF News search.
 */
if (! class_exists('UfNewsSearchPlugin')) {
	class UfNewsSearchPlugin extends UfNewsPlugin {
		function SOURCES() {
			$sources = array(
				'this'      => new UfNewsSearchSource(get_settings('blogname'), get_settings('siteurl') . '/index.php', 's'),
				'web'       => new UfNewsSearchSource('UF Web with Google', 'http://search.ufl.edu/web', 'query'),
				'phonebook' => new UfNewsSearchSource('UF Phonebook', 'http://phonebook.ufl.edu/display_form.cgi', 'person'),
			);

			return $sources;
		}

		function UfNewsSearchPlugin() {
			$this->{get_parent_class(__CLASS__)}('Search', __FILE__);

			$options = array(
				new UfNewsOptionGroup('General', array(
					new UfNewsOption('uf_news_search_default_source_name', 'this', 'Default source'),
				)),
			);
			$this->options_page = new UfNewsOptionsPage($this->name, '', $options);
		}

		function add_plugin_hooks() {
			parent::add_plugin_hooks();

			$controller = new UfNewsSearchController();
			$this->register_action($controller, 'search');
		}
	}
}

$uf_news_search_plugin = new UfNewsSearchPlugin();
?>
