<?php
/*
Plugin Name: Filament
Plugin URI: http://filament.io/
Description: Install & manage all your Web apps from a single place. Connect your website to Filament with this plugin, and never bug your developers again!
Version: 1.1.0
Author: dtelepathy
Author URI: http://www.dtelepathy.com/
Contributors: kynatro, dtelepathy, dtlabs
License: GPL3

Copyright 2012 digital-telepathy  (email: support@filament.io)

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
    var $label = "Filament";
    var $slug = "filament";
    var $menu_hooks = array();
    var $version = '1.1.0';

    /**
     * Initialize the plugin
     *
     * @uses add_action()
     * @uses load_theme_textdomain()
     * @uses Filament::_route()
     */
    function __construct() {
        /**
         * Make this plugin available for translation.
         * Translations can be added to the /languages/ directory.
         */
        load_theme_textdomain( $this->slug, dirname( __FILE__ ) . '/locales' );

        // Admin in-line styles
        add_action( 'admin_head', array( &$this, 'admin_head' ) );

        // Admin menu addition
        add_action( 'admin_menu', array( &$this, 'admin_menu' ) );

        // Admin page load
        add_action( "admin_print_styles-toplevel_page_{$this->slug}", array( &$this, "load_admin_page" ) );

        // Code snippet output
        add_action( 'wp_head', array( &$this, 'wp_head' ) );

        // Plugin action link
        add_filter( 'plugin_action_links', array( &$this, 'plugin_action_links' ), 10, 2 );

        // Custom routing
        add_action( 'init', array( &$this, 'route' ) );

        // Site Structure
        add_action( 'wp_ajax_' . $this->slug . '_taxonomy_structure', array( &$this, 'ajax_taxonomy_structure' ) );
        add_action( 'wp_ajax_nopriv_' . $this->slug . '_taxonomy_structure', array( &$this, 'ajax_taxonomy_structure' ) );
    }

    /**
     * Submit processing for admin_options view
     *
     * @uses update_option()
     * @uses wp_die()
     * @uses wp_verify_nonce()
     */
    private function _submit_admin_options() {
        $code_snippet = wp_check_invalid_utf8( htmlentities( stripslashes( $_REQUEST['single_drop'] ), ENT_QUOTES, "UTF-8" ) );

        update_option( $this->slug . '_single_drop', $code_snippet );

        wp_redirect( admin_url( 'admin.php' ) . '?page=' . $this->slug . '&message=submit' ); exit;
    }

    /**
     * Hook into admin_head action
     *
     * Output in-line styles for admin menu icon sizing
     */
    public function admin_head() {
        include( dirname( __FILE__ ) . '/views/admin/_styles.php' );
    }


    /**
     * Define the admin menu options for this plugin
     *
     * @uses add_action()
     * @uses add_menu_page()
     * @uses add_submenu_page()
     */
    public function admin_menu() {
        $this->menu_hooks['deploy'] = add_menu_page( $this->label, $this->label, 'edit_themes', $this->slug, array( &$this, 'admin_options' ), plugins_url( 'assets/images/bolt.png', __FILE__ ) );

        // Sign up for Filament
        $this->menu_hooks['signup'] = add_submenu_page( $this->slug, $this->label, 'Signup for Filament', 'edit_themes', $this->slug . '/signup', array( &$this, 'admin_options' ) );
    }

    /**
     * Admin options page view
     *
     * Sets up and renders the view for setting deploy options
     *
     * @uses get_option()
     */
    public function admin_options() {
        $data = array();
        $action = $this->slug . '_admin_options';

        $data['single_drop'] = html_entity_decode( get_option( $this->slug . '_single_drop', "" ), ENT_QUOTES, "UTF-8" );

        include( dirname( __FILE__ ) . '/views/admin/admin_options.php' );
    }

    /**
     * Public site taxonomy structure URL for Filament App knowledge
     */
    public function ajax_taxonomy_structure() {
        header( 'Content-type: application/json' );

        $structure = array(
          'post_types' => array(),
          'categories' => array(),
          'tags' => array()
        );

        $post_types = wp_cache_get( 'post_types', $this->slug );
        if( !$post_types ) {
            $post_types = get_post_types( array( 'public' => true ) );
            wp_cache_set( 'post_types', $post_types, $this->slug, 3600 );
        }
        
        $categories = wp_cache_get( 'categories', $this->slug );
        if( !$categories ) {
            $categories = get_terms( 'category' );
            wp_cache_set( 'categories', $categories, $this->slug, 3600 );
        }
        
        $tags = wp_cache_get( 'tags', $this->slug );
        if( !$tags ) {
            $tags = get_terms( 'post_tag' );
            wp_cache_set( 'tags', $tags, $this->slug, 3600 );
        }

        $structure['post_types'] = array_values( $post_types );
        foreach( $categories as $category ) $structure['categories'][] = $category->slug;
        foreach( $tags as $tag ) $structure['tags'][] = $tag->slug;
        
        exit( json_encode( $structure ) );
    }

    /**
     * Initialization function to hook into the WordPress init action
     *
     * Instantiates the class on a global variable and sets the class, actions
     * etc. up for use.
     */
    static function instance( ) {
        global $Filament;

        // Only instantiate the Class if it hasn't been already
        if( !isset( $Filament ) )
            $Filament = new Filament( );
    }

    public function load_admin_page() {
        wp_enqueue_style( "{$this->slug}-admin", filament_plugin_url( "/assets/admin.css" ), array(), $this->version, 'screen' );
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
    public function plugin_action_links( $links, $file ) {
        $new_links = array( );

        if( $file == plugin_basename( dirname( __FILE__ ) . '/' . basename( __FILE__ ) ) ) {
            $new_links[] = '<a href="' . admin_url( 'admin.php?page=' . $this->slug ) . '">' . __( "Deploy Filament" ) . '</a>';
        }

        return array_merge( $new_links, $links );
    }

    /**
     * Route the user based off of environment conditions
     *
     * This function will handling routing of form submissions to the appropriate
     * form processor.
     */
    public function route() {
        $uri = $_SERVER['REQUEST_URI'];
        $uri_parse = parse_url( $uri );
        $protocol = isset( $_SERVER['HTTPS'] ) ? 'https' : 'http';
        $hostname = $_SERVER['HTTP_HOST'];
        $url = "{$protocol}://{$hostname}{$uri}";
        $method = $_SERVER['REQUEST_METHOD'];
        $is_post = !!( $method == "POST" );
        parse_str( $_SERVER['QUERY_STRING'], $params );

        if( basename( $uri_parse['path'] ) == 'admin.php' && isset( $params['page'] ) && $params['page'] == $this->slug . '/signup' ) {
          wp_redirect( "http://filament.io/?utm_source=filament_wp&utm_medium=link&utm_content=plugin&utm_campaign=filament", 301 ); exit;
        }

        if( $is_post && isset( $_REQUEST['_wpnonce'] ) ) {
            if( wp_verify_nonce( $_REQUEST['_wpnonce'], $this->slug . '_admin_options' ) ) {
                $this->_submit_admin_options();
            }
        }
    }

    /**
     * Hook into wp_head for Filament code snippet output
     *
     * @uses get_option()
     */
    public function wp_head() {
        global $wp_query;

        $metas = array(
            'is-404' => is_404(),
            'is-archive' => is_archive(),
            'is-attachment' => is_attachment(),
            'is-author' => is_author(),
            'is-category' => is_category(),
            'is-front-page' => is_front_page(),
            'is-home' => is_home(),
            'is-page' => is_page(),
            'is-search' => is_search(),
            'is-single' => is_single(),
            'is-singular' => is_singular(),
            'is-sticky' => is_sticky(),
            'is-tag' => is_tag(),
            'is-tax' => is_tax(),
            'post-type' => get_post_type(),
            'categories' => "",
            'tags' => ""
        );

        if( $metas['is-category'] ) {
            $category = get_category( get_query_var( 'cat' ), false );
            $metas['categories'] = $category->slug;
        } else if( $metas['is-singular'] ) {
            $category_ids = wp_get_object_terms( $wp_query->post->ID, 'category', array( 'fields' => 'ids' ) );
            $categories = array();

            foreach( (array) $category_ids as $category_id ) {
                $category = get_category( $category_id );
                $categories[] = $category->slug;
            }

            $metas['categories'] = implode( $categories, "," );

            $tag_objs = wp_get_post_tags( $wp_query->post->ID );
            $tags = array();

            foreach( (array) $tag_objs as $tag_obj ) {
                $tags[] = $tag_obj->slug;
            }

            $metas['tags'] = implode( $tags, "," );
        }

        $namespace = $this->slug;

        include( "views/_meta.php" );

        echo html_entity_decode( get_option( $this->slug . '_single_drop', "" ), ENT_QUOTES, "UTF-8" );
    }
}

function filament_plugin_url( $path = "" ) {
    return trailingslashit( plugins_url() ) . basename( dirname( __FILE__ ) ) . $path;
}

add_action( 'plugins_loaded', array( 'Filament', 'instance' ) );