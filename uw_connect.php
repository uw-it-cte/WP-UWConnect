<?php
/**
 * Plugin Name: UW Connect for Wordpress
 * Description: A brief description of the plugin.
 * Version: 1.0.0
 * Author: UW IT ACA
 * Author URI: https://github.com/uw-it-aca
 * License: GPL2
 */
/*  Copyright 2015  UW IT ACA  (email : cstimmel@uw.edu)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function uw_connect_setup() {
    wp_register_style( 'uwconnect_font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' );
    wp_register_style( 'uwconnect_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css' );
    wp_enqueue_style( 'uwconnect_font-awesome' );
    wp_enqueue_style( 'uwconnect_bootstrap' );
}
add_action( 'wp_enqueue_scripts', 'uw_connect_setup');

function get_page_by_slug($slug) {
    if ($pages = get_pages())
        foreach ($pages as $page)
            if ($slug === $page->post_name) return $page;
    return false;
}

function add_query_vars($qvars) {
    $qvars[] = "ticketID";
    return $qvars;
}
add_filter('query_vars', 'add_query_vars');

function add_rewrite_rules($aRules) {
    $aNewRules = array('my_request/([^/]+)/?$' => 'index.php?pagename=my_request&ticketID=$matches[1]');
    $aRules = $aNewRules + $aRules;
    return $aRules;
}
add_filter('rewrite_rules_array', 'add_rewrite_rules');

function create_request_page() {
    $post = array(
          'comment_status' => 'open',
          'ping_status' =>  'closed' ,
          'post_date' => date('Y-m-d H:i:s'),
          'post_name' => 'my_request',
          'post_status' => 'publish' ,
          'post_title' => 'My Request',
          'post_type' => 'page',
    );
    $newvalue = wp_insert_post( $post, false );
    update_option( 'mrpage', $newvalue );
}
register_activation_hook(__FILE__, 'create_request_page');

function create_requests_page() {
    $post = array(
          'comment_status' => 'open',
          'ping_status' =>  'closed' ,
          'post_date' => date('Y-m-d H:i:s'),
          'post_name' => 'my_requests',
          'post_status' => 'publish' ,
          'post_title' => 'My Requests',
          'post_type' => 'page',
    );
    $newvalue = wp_insert_post( $post, false );
    update_option( 'mrspage', $newvalue );
}
register_activation_hook(__FILE__, 'create_requests_page');

function request_page_template( $template ) {

  if ( is_page( 'my_request' ) ) {
    $new_template = dirname(__FILE__) . '/request-page-template.php';
    if ( '' != $new_template ) {
      return $new_template ;
    }
  }
  if ( is_page( 'my_requests' ) ) {
    $new_template = dirname(__FILE__) . '/requests-page-template.php';
    if ( '' != $new_template ) {
      return $new_template ;
    }
  }

  return $template;
}
add_filter( 'template_include', 'request_page_template');

//Builds a request to Service Now and returns results as a JSON object.
function get_SN($url, $args) {
    $url = SN_URL . $url;
    $response = wp_remote_get( $url, $args );
    $body = wp_remote_retrieve_body( $response );
    $json = json_decode( $body );
    return $json;
}

// Takes two datetime objects and sorts descending by sys_updated_on
function sortByUpdatedOnDesc($a, $b) {
    return $a->sys_updated_on < $b->sys_updated_on;
}

// Takes two datetime objects and sorts descending by sys_created_on
function sortByCreatedOnDesc($a, $b) {
    return $a->sys_created_on < $b->sys_created_on;
}

// Takes two strings and sorts descending by number
function sortByNumberDesc($a, $b) {
    return $a->number < $b->number;
}
?>
