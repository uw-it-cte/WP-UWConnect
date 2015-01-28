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
function uw_connect_script_setup() {
    wp_register_style( 'uwconnect_font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' );
    wp_register_style( 'uwconnect_bootstrap', plugin_dir_url(__FILE__) . 'styles/bootstrap-3.1.1/css/bootstrap-3.1.1.min.css' );
    wp_register_style( 'uwconnect_style', plugin_dir_url(__FILE__) . 'styles/style.css');
    wp_enqueue_style( 'uwconnect_font-awesome' );
    wp_enqueue_style( 'uwconnect_bootstrap' );
    wp_enqueue_style( 'uwconnect_style' );
}
add_action( 'wp_enqueue_scripts', 'uw_connect_script_setup');

wp_register_script( 'jQuery','//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', array(), '1.7.2' );
wp_enqueue_script( 'jQuery' );

function uw_connect_menu() {
  add_options_page( 'UW Connect Options', 'WP-UWConnect', 'manage_options', 'uw-connect-options', 'uw_connect_options' );
}
add_action( 'admin_menu', 'uw_connect_menu' );

function uw_connect_options() {
  $hidden_field_name = 'uwc_submit_hidden';
  // variables for the field and option names
  $url = 'uwc_SN_URL';
  $data_url = 'uwc_SN_URL';
  $user = 'uwc_SN_USER';
  $data_user = 'uwc_SN_USER';
  $pass = 'uwc_SN_PASS';
  $data_pass = 'uwc_SN_PASS';

  // Read in existing option value from database
  $url_val = get_option( $url );
  $user_val = get_option( $user );
  $pass_val = get_option( $pass );

  // See if the user has posted us some information
  // If they did, this hidden field will be set to 'Y'
  if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) { 
      // Read their posted value
      $url_val = $_POST[ $data_url ];
      $user_val = $_POST[ $data_user ];
      $pass_val = $_POST[ $data_pass ];

      // Save the posted value in the database
      update_option( $url, $url_val );
      update_option( $user, $user_val );
      update_option( $pass, $pass_val );

?>
<div class="updated"><p><strong><?php _e('settings saved.', 'menu' ); ?></strong></p></div>
<?php
  }
  // Now display the settings editing screen
  echo '<div class="wrap">';
  // header
  echo "<h2>" . __( 'UW Connect Plugin Settings', 'menu' ) . "</h2>";
  // settings form
  ?>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("ServiceNow URL:", 'menu' ); ?>
<input type="text" name="<?php echo $data_url; ?>" value="<?php echo $url_val; ?>" size="20">
</p><hr />

<p><?php _e("ServiceNow User:", 'menu' ); ?>
<input type="text" name="<?php echo $data_user; ?>" value="<?php echo $user_val; ?>" size="20">
</p><hr />

<p><?php _e("ServiceNow Pass:", 'menu' ); ?>
<input type="text" name="<?php echo $data_pass; ?>" value="<?php echo $pass_val; ?>" size="20">
</p><hr />

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
</div>
<?php
}


function get_page_by_slug($slug) {
    if ($pages = get_pages()) {
      foreach ($pages as $page) {
        if ($slug === $page->post_name) {
          return $page;
        }
      }
    }
    return false;
}


function add_query_vars($qvars) {
    $qvars[] = "ticketID";
    return $qvars;
}
add_filter('query_vars', 'add_query_vars');

function add_rewrite_rules($aRules) {
    $aNewRules = array('myrequest/([^/]+)/?$' => 'index.php?pagename=myrequest&ticketID=$matches[1]');
    $aRules = $aNewRules + $aRules;
    return $aRules;
}
add_filter('rewrite_rules_array', 'add_rewrite_rules');

function get_page_by_name($pagename) {
  $pages = get_pages();
  foreach ($pages as $page) {
    if ($page->post_name == $pagename) {
      return $page;
    }
  }
  return false;
}

function create_request_page() {
    $post = array(
          'comment_status' => 'open',
          'ping_status' =>  'closed' ,
          'post_date' => date('Y-m-d H:i:s'),
          'post_name' => 'myrequest',
          'post_status' => 'publish' ,
          'post_title' => 'My Request',
          'post_type' => 'page',
    );
    $newvalue = wp_insert_post( $post, false );
    update_option( 'mrpage', $newvalue );
}
if (!get_page_by_name('my_request')) {
  register_activation_hook(__FILE__, 'create_request_page');
}

function create_requests_page() {
    $post = array(
          'comment_status' => 'open',
          'ping_status' =>  'closed' ,
          'post_date' => date('Y-m-d H:i:s'),
          'post_name' => 'myrequests',
          'post_status' => 'publish' ,
          'post_title' => 'My Requests',
          'post_type' => 'page',
    );
    $newvalue = wp_insert_post( $post, false );
    update_option( 'mrspage', $newvalue );
}
if (!get_page_by_name('my_requests')) {
  register_activation_hook(__FILE__, 'create_requests_page');
}

function create_servicestatus_page() {
    $post = array(
          'comment_status' => 'open',
          'ping_status' =>  'closed' ,
          'post_date' => date('Y-m-d H:i:s'),
          'post_name' => 'servicestatus',
          'post_status' => 'publish' ,
          'post_title' => 'ServiceStatus',
          'post_type' => 'page',
    );
    $newvalue = wp_insert_post( $post, false );
    update_option( 'sspage', $newvalue );
}
if (!get_page_by_name('servicestatus')) {
  register_activation_hook(__FILE__, 'create_servicestatus_page');
}

function request_page_template( $template ) {

  if ( is_page( 'myrequest' ) ) {
    if ( basename( get_page_template() ) == "page.php" ) {
      $new_template = dirname(__FILE__) . '/request-page-template.php';
      if ( '' != $new_template ) {
        return $new_template ;
      }
    }
  }
  if ( is_page( 'myrequests' ) ) {
    if ( basename( get_page_template() ) == "page.php" ) {
      $new_template = dirname(__FILE__) . '/requests-page-template.php';
      if ( '' != $new_template ) {
        return $new_template ;
      }
    }
  }
  if ( is_page( 'servicestatus' ) ) {
    if ( basename( get_page_template() ) == "page.php" ) {
      $new_template = dirname(__FILE__) . '/servicestatus-page-template.php';
      if ( '' != $new_template ) {
        return $new_template ;
      }
    }
  }
  return $template;
}
add_filter( 'template_include', 'request_page_template');

function service_status() {
  $hash = base64_encode( get_option('uwc_SN_USER') . ':' . get_option('uwc_SN_PASS') );
  $args = array(
      'headers' => array(
          'Authorization' => 'Basic ' . $hash,
      ),
      'timeout' => 25,
  );
  $JSON = get_SN('/incident_list.do?JSONv2&sysparm_query=active%3Dtrue%5EstateNOT%20IN6%2C7%5Epriority%3D3%5EORpriority%3D2%5EORpriority%3D1%5Eu_sectorNOT%20INK20%2CPNWGP%2CPWave%5EORu_sector%3D&displayvalue=true', $args);
  $IDJSON = get_SN('/incident_list.do?JSONv2&sysparm_query=active%3Dtrue%5EstateNOT%20IN6%2C7%5Epriority%3D3%5EORpriority%3D2%5EORpriority%3D1%5Eu_sectorNOT%20INK20%2CPNWGP%2CPWave%5EORu_sector%3D', $args);
      if(!$JSON) {
          echo "<div class='alert alert-warning' style='margin-top:2em;'>We are currently experiencing problems retrieving the status of our services. Please try again in a few minutes.</div>";
      }
      elseif(empty($JSON->records)) {
          echo "<div class='alert alert-warning' style='margin-top:2em;'>All services are operational.</div>";
      }
      $sn_data = array();
      foreach ( $IDJSON->records as $record ) {
          if( !isset( $sn_data[$record->cmdb_ci] ) ) { 
                  $sn_data[$record->cmdb_ci] = array();
                  unset($first);
              }
              $create = $record->sys_created_on;
              if( !isset( $first ) ) {
                  $first = $create;
              }
              if($create < $first) {
                  $first = $create;
              }
              $sn_data[$record->cmdb_ci][] = $record;
              $sn_data[$record->cmdb_ci][] = $first;

      }
      $classes = array();
      foreach ($sn_data as $ci) {
        $serviceid = $ci[0]->cmdb_ci;
        $servJSON = get_SN('/cmdb_ci_list.do?JSONv2&sysparm_query=u_active!%3Dfalse%5Esys_id%3D' . $serviceid . '&displayvalue=true', $args);
        $class = $servJSON->records[0]->sys_class_name;
        $classes[] = $class;
      }


      if ( !empty( $JSON->records ) ) { 
          $sn_data = array();
          foreach( $JSON->records as $record ) {
              if( !isset( $sn_data[$record->cmdb_ci] ) ) { 
                  $sn_data[$record->cmdb_ci] = array();
                  unset($first);
              }
              $create = $record->sys_created_on;
              if( !isset( $first ) ) {
                  $first = $create;
              }
              if($create < $first) {
                  $first = $create;
              }
              $sn_data[$record->cmdb_ci][] = $record;
              $sn_data[$record->cmdb_ci][] = $first;
          }
              echo "<h2 class='assistive-text' id='impact_headeing'>Impacted Services</h2>";
              # put the services into a single ordered list
              echo "<div class='row' aria-labelledby='impact_heading'>";
              $i = 0;
              foreach( $sn_data as $ci) {
                  $class = $classes[$i];
                  $service = array_search($ci, $sn_data);
                  // handle the case of blank services and switches who's 'name' is a sequence of 5 or more numbers
                  if ( $service !== '' && !preg_match('/^\d{5,}$/', $service) ) { 
                      $time = end($ci);
                    echo "<div class='services row'>";
                      echo "<div class='service_name col-lg-5 col-md-5 col-sm-8 col-xs-8' style='font-weight:bold; display:inline-block;'>$service</div>";
                      echo "<div class='service_class hidden-xs hidden-sm col-lg-2 col-md-2' style='display:inline-block; font-size:90%;'>$class</div>";
                      echo "<div class='service_time col-lg-4 col-md-4 col-sm-4 col-xs-4' style='color:#aaa; font-size:95%; display:inline-block;'><span class='hidden-sm hidden-xs'>Reported at </span>$time</div>";
                    echo "</div>";
               }
               $i++;
            }
        echo "</div>";
      }
  echo "<p class='alert alert-info' style='margin-top: 2em;'>Experiencing IT problems not listed on this page? Need more information about a service impact? Want to provide feedback about this page? <a href='/itconnect/help'>Get help.</a></p>";
        die();
}
add_action( 'wp_ajax_service_status', 'service_status' );
add_action( 'wp_ajax_nopriv_service_status', 'service_status' );

function enable_ajax() {
  wp_enqueue_script( 'function', plugin_dir_url( __FILE__ ) . 'service.js', 'jquery', true);
  wp_localize_script( 'function', 'service_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('template_redirect', 'enable_ajax');

//Builds a request to Service Now and returns results as a JSON object.
function get_SN($url, $args) {
    $url = get_option('uwc_SN_URL') . $url;
    $response = wp_remote_get( $url, $args );
    $body = wp_remote_retrieve_body( $response );
    $json = json_decode( $body );
    return $json;
}

// Takes two datetime objects and sorts descending by sys_updated_on
function sortByUpdatedOnDesc($a, $b) {
    $dt_a = DateTime::createFromFormat('m-d-Y H:i:s', $a->sys_updated_on);
    $dt_b = DateTime::createFromFormat('m-d-Y H:i:s', $b->sys_updated_on);
    return $dt_a < $dt_b;
}

// Takes two datetime objects and sorts descending by sys_created_on
function sortByCreatedOnDesc($a, $b) {
    $dt_a = DateTime::createFromFormat('m-d-Y H:i:s', $a->sys_created_on);
    $dt_b = DateTime::createFromFormat('m-d-Y H:i:s', $b->sys_created_on);
    return $dt_a < $dt_b;
}

// Takes two strings and sorts descending by number
function sortByNumberDesc($a, $b) {
    return $a->number < $b->number;
}
?>
