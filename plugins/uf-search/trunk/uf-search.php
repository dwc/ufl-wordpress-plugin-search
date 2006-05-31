<?php
/*
Plugin Name: UF Search
Version: 1.1
Plugin URI: http://www.webadmin.ufl.edu/
Description: Handling of the search form on WordPress sites at UF. Requires the <code>uf-plugin-framework</code> plugin.
Author: Daniel Westermann-Clark
Author URI: http://www.webadmin.ufl.edu/
*/

define('UF_SEARCH_PLUGIN_BASE', dirname(__FILE__) . '/');

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
				'phonebook' => new UfSearchSource('UF Phonebook', 'http://phonebook.ufl.edu/people/search', 'query'),
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

			$controller = new UfSearchController($sources, get_settings('uf_search_default_source_name'));
			$this->register_action($controller, 'search');
		}
	}
}

if (! function_exists('get_search_uri')) {
	function get_search_uri($query) {
		global $wp_rewrite;

		$search_uri = '';

		$search_permastruct = $wp_rewrite->get_search_permastruct();
		if ($search_permastruct) {
			$search_uri = get_bloginfo('url') . '/' . str_replace('%search%', urlencode($query), $search_permastruct);
		}
		else {
			$search_uri = get_bloginfo('url') . '/index.php?s=' . urlencode($query);
		}

		return $search_uri;
	}
}

$uf_search_plugin = new UfSearchPlugin();
?>
