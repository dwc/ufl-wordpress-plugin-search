<?php
/*
Plugin Name: UF Search
Version: 1.1
Plugin URI: http://www.webadmin.ufl.edu/
Description: Handling of the search form on WordPress sites at UF. Requires the <code>uf-plugin-framework</code> plugin.
Author: Daniel Westermann-Clark
Author URI: http://dev.webadmin.ufl.edu/~dwc/
*/

define('UF_SEARCH_PLUGIN_BASE', dirname(__FILE__) . '/');

// Load the plugin after the framework
add_action('plugins_loaded', 'uf_search_plugins_loaded');


$uf_search_plugin = null;
function uf_search_plugins_loaded() {
	global $uf_search_plugin;

	require_once('models/class.UfSearchSource.php');
	$sources = array(
		'this'      => new UfSearchSource(get_settings('blogname'), get_settings('siteurl') . '/index.php', 's'),
		'web'       => new UfSearchSource('UF Web with Google', 'http://search.ufl.edu/web', 'query'),
		'phonebook' => new UfSearchSource('UF Phonebook', 'http://phonebook.ufl.edu/people/search', 'query'),
	);

	require_once('plugins/class.UfSearchPlugin.php');
	$uf_search_plugin = new UfSearchPlugin('Search', basename(__FILE__), $sources);
}

/*
 * Workaround WordPress' braindead lack of stripslashes.
 */
function uf_search_query() {
	$query = stripslashes(stripslashes($_REQUEST['s']));

	return $query;
}

function uf_search_uri($query) {
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

function uf_search_sources() {
	global $uf_search_plugin;

	$sources = array();
	if ($uf_search_plugin) {
		$sources = $uf_search_plugin->sources;
	}

	return $sources;
}
?>
