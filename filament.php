<?php
/*
Plugin Name: Filament
Plugin URI: http://filament.io/
Description: Install & manage all your Web apps from a single place. Connect your website to Filament with this plugin, and never bug your developers again!
Version: 1.0.0
Author: dtelepathy
Author URI: http://www.dtelepathy.com/
Contributors: kynatro, dtelepathy, dtlabs
License: GPL3

Copyright 2012 digital-telepathy  (email : support@digital-telepathy.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Filament {
    static $label = "Filament";
    static $slug = "filament";
    static $menu_hooks = array();
    static $version = '1.0.0';

    /**
     * Route the user based off of environment conditions
     * 
     * This function will handling routing of form submissions to the appropriate
     * form processor.
     */
    private function _route() {
        $uri = $_SERVER['REQUEST_URI'];
        $uri_parse = parse_url( $uri );
        $protocol = isset( $_SERVER['HTTPS'] ) ? 'https' : 'http';
        $hostname = $_SERVER['HTTP_HOST'];
        $url = "{$protocol}://{$hostname}{$uri}";
        $method = $_SERVER['REQUEST_METHOD'];
        $is_post = !!( $method == "POST" );
        parse_str( $_SERVER['QUERY_STRING'], $params );

        if( basename( $uri_parse['path'] ) == 'admin.php' && isset( $params['page'] ) && $params['page'] == self::$slug . '/signup' ) {
          wp_redirect( "http://app.filament.io/users/register?utm_source=filament_wp&utm_medium=link&utm_content=plugin&utm_campaign=filament", 301 ); exit;
        }

        if( $is_post && isset( $_REQUEST['_wpnonce'] ) ) {
            self::_submit_admin_options();
        }
    }

    /**
     * Submit processing for admin_options view
     * 
     * @uses update_option()
     * @uses wp_die()
     * @uses wp_verify_nonce()
     */
    private function _submit_admin_options() {
        if( !wp_verify_nonce( $_REQUEST['_wpnonce'], self::$slug . '_admin_options' ) ) {
            wp_die( __( "Sorry, but there was an error processing your form submission, please try again.", self::$slug ) );
            return false;
        }

        update_option( self::$slug . '_single_drop', $_REQUEST['single_drop'] );

        wp_redirect( admin_url( 'admin.php' ) . '?page=' . self::$slug ); exit;
    }

    /**
     * Hook into admin_head action
     * 
     * Output in-line styles for admin menu icon sizing
     */
    static function admin_head() {
        include( dirname( __FILE__ ) . '/views/admin/_styles.php' );
    }

    /**
     * Define the admin menu options for this plugin
     * 
     * @uses add_action()
     * @uses add_menu_page()
     * @uses add_submenu_page()
     */
    static function admin_menu() {
        self::$menu_hooks['deploy'] = add_menu_page( self::$label, self::$label, 'edit_themes', self::$slug, array( 'Filament', 'admin_options' ), plugins_url( 'assets/images/bolt.png', __FILE__ ) );

        // Sign up for Filament
        self::$menu_hooks['signup'] = add_submenu_page( self::$slug, self::$label, 'Signup for Filament', 'edit_themes', self::$slug . '/signup', array( 'Filament', 'admin_options' ) );
    }

    /**
     * Admin options page view
     * 
     * Sets up and renders the view for setting deploy options
     * 
     * @uses get_option()
     */
    static function admin_options() {
        $data = array();
        $action = self::$slug . '_admin_options';

        $data['single_drop'] = get_option( self::$slug . '_single_drop', "" );

        include( dirname( __FILE__ ) . '/views/admin/admin_options.php' );
    }

    /**
     * Initialize the plugin
     * 
     * @uses add_action()
     * @uses load_theme_textdomain()
     * @uses Filament::_route()
     */
    static function initialize() {
        /**
         * Make this plugin available for translation.
         * Translations can be added to the /languages/ directory.
         */
        load_theme_textdomain( self::$slug, dirname( __FILE__ ) . '/locales' );
        
        // Admin menu addition
        add_action( 'admin_menu', array( 'Filament', 'admin_menu' ) );

        // Code snippet output
        add_action( 'wp_head', array( 'Filament', 'wp_head' ) );

        // Plugin action link
        add_filter( 'plugin_action_links', array( 'Filament', 'plugin_action_links' ), 10, 2 );

        // Admin in-line styles
        add_action( 'admin_head', array( 'Filament', 'admin_head' ) );

        self::_route();
    }

    /**
     * Hook into plugin_action_links filter
     *
     * Adds a "Deploy Filament" link next to the "Deactivate" link in the plugin 
     * listing page when the plugin is active.
     *
     * @param object $links An array of the links to show, this will be the
     * modified variable
     * @param string $file The name of the file being processed in the filter
     * 
     * @uses plugin_basename()
     */
    static function plugin_action_links( $links, $file ) {
        $new_links = array( );

        if( $file == plugin_basename( dirname( __FILE__ ) . '/' . basename( __FILE__ ) ) ) {
            $new_links[] = '<a href="' . admin_url( 'admin.php?page=' . self::$slug ) . '">' . __( "Deploy Filament" ) . '</a>';
        }

        return array_merge( $new_links, $links );
    }

    /**
     * Hook into wp_head for Filament code snippet output
     * 
     * @uses get_option()
     */
    static function wp_head() {
        $single_drop = get_option( self::$slug . '_single_drop', "" );

        echo $single_drop;
    }
}

add_action( 'plugins_loaded', array( 'Filament', 'initialize' ) );
add_action( 'initialize', array( 'Filament', 'route' ) );