<?php
/**
 * OceanWP Child Theme Functions
 *
 * When running a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions will be used.
 *
 * Text Domain: oceanwp
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
function oceanwp_child_enqueue_parent_style()
{

	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update the theme).
	$theme = wp_get_theme('OceanWP');
	$version = $theme->get('Version');

	// Load the stylesheet.
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('oceanwp-style'), $version);

}

add_action('wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style');

function add_admin_link($items, $args)
{
	// Vérifiez si l'utilisateur est connecté à WordPress
	if (is_user_logged_in()) {
		// Construisez le lien "Admin"
		$admin_link = '<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-admin"><a href="' . esc_url(get_admin_url()) . '">Admin</a></li>';

		// Trouvez la position du premier élément de menu
		$pos_first_menu = strpos($items, '<li');

		// Trouvez la position du premier élément de menu après le premier
		$pos_second_menu = strpos($items, '<li', $pos_first_menu + 1);

		// Insérez le lien "Admin" après le premier élément de menu
		if ($pos_first_menu !== false && $pos_second_menu !== false) {
			$items = substr_replace($items, $admin_link, $pos_second_menu, 0);
		}
	}
	return $items;
}

// Ajoutez la fonction comme un filtre pour tous les emplacements de menu
add_filter('wp_nav_menu_items', 'add_admin_link', 10, 2);

