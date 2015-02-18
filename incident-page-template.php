<?php

define( 'DONOTCACHEPAGE', True );
if(isset( $_SERVER['REMOTE_USER'])) {
    $user = $_SERVER['REMOTE_USER'];
} else if(isset($_SERVER['REDIRECT_REMOTE_USER'])) {
    $user = $_SERVER['REDIRECT_REMOTE_USER'];
} else if(isset($_SERVER['PHP_AUTH_USER'])) {
    $user = $_SERVER['PHP_AUTH_USER'];
}
$error_flag = False;
$sn_num = get_query_var('ticketID');
if( $sn_num == '' ) {
    $new_url = site_url() . '/servicestatus/';
    wp_redirect( $new_url );
}
get_header(); ?>

<div id="main-content" class="row main-content">
  <div id="content" class="site-content it_container" role="main">
    <div id="secondary" class="col-lg-2 col-md-2 hidden-sm hidden-xs" role="complementary">
      <div class="" id="sidebar" role="navigation" aria-label="Sidebar Menu">
        <?php dynamic_sidebar('servicenow-sidebar'); ?>
      </div>
    </div>
  <div id="primary" class="col-xs-12 col-sm-12 col-md-10 col-lg-10 itsm-primary">

<?php
              $args = array(
                  'headers' => array(
                      'Authorization' => 'Basic ' . base64_encode( get_option('uwc_SN_USER') . ':' . get_option('uwc_SN_PASS') ),
                  )
              );

              $url = '/incident.do?JSONv2&displayvalue=true&sysparm_query=number=' . $sn_num;
              $ticket_json = get_SN($url, $args);
              $record = $ticket_json->records[0];
              $priority = substr($record->priority, 0, 1);

              if ( (int)$priority < 2 ) {
                 echo "<p class='alert bg-danger'>The requested incident is not public. If you filed this incident please view it's details at it's <a href='itconnect/myrequest/$record->number'>My Request</a> page.</p>";
              } else {

                $urlwl = '/incident.do?JSONv2&sysparm_query=number='. $sn_num;
                $ticket_jsonwl = get_SN($urlwl, $args);
                $recordwl = $ticket_jsonwl->records[0];
                //array of sys_id's of users in watch list
                $watch_list = explode(',', $recordwl->watch_list);

                $caller_url = '/sys_user_list.do?JSONv2&sysparm_query=name%3D' . urlencode($record->caller_id);
                $caller_json = get_SN($caller_url, $args);
                $caller_nid = $caller_json->records[0]->user_name;


                // Get the comments
                $comment_url = '/sys_journal_field.do?displayvalue=true&JSONv2&sysparm_cation=getRecords&sysparm_query=active=true^element=comments^element_id=' . $record->sys_id;
                $comment_json = get_SN($comment_url, $args);
                $comments = $comment_json->records;
                    echo "<h2 style='margin-top:0;'>$record->short_description&nbsp;&nbsp;<span style='color:#999;'>($record->number)</span></h2>";
                    echo "<h3 class='assistive-text'>Details:</h3>";
                    echo "<table class='table'>";
                if( !empty( $record->caller_id ) ) {
                    $caller = $record->caller_id;  
                } else if( !empty( $record->u_caller ) ) {
                    $caller = $record->u_caller;
                } else {
                    $caller = 'UNKNOWN';
                }

                // Array of record states and their corresponding classes
                $states = array(
                    "New" => 'class="label label-success"',
                    "Active" => 'class="label label-success"',
                    "Awaiting User Info" => 'class="label label-warning"',
                    "Awaiting Tier 2 Info" => 'class="label label-success"',
                    "Awaiting Vendor Info" => 'class="label label-success"',
                    "Internal Review" => 'class="label label-success"',
                    "Stalled" => 'class="label label-success"',
                    "Delivered" => 'class="label label-success"',
                    "Resolved" => 'class="label label-default"',
                    "Closed" => 'class="label label-default"',
                );

                if ($record->state != "Resolved" && $record->state != "Awaiting User Info" && $record->state != "Closed") {
                    $record->state = "Active";
                }

                echo "<tr><td>Status:</td><td class='request_status'>";
                        if (array_key_exists($record->state, $states)) {
                            $class = $states[$record->state];
                            echo "<span $class>$record->state</span>"; 
                        }
                echo "</td></tr>";
                echo "<tr><td>Service:</td> <td>$record->cmdb_ci</td></tr>";
                echo "<tr><td>Opened on:</td> <td>$record->opened_at</td></tr>";
                echo "<tr><td>Last Updated:</td> <td>$record->sys_updated_on</td></tr>";

                echo "</div>";
                  echo "</td></tr>";
                  echo "</table>";
                  echo "<h3 style='margin-top:2em;'>Description:</h3><div><pre>" . stripslashes($record->description) . " </pre></div>";


              if ($record->state == "Closed") {
                echo "<p class='alert alert-error'>This record has been closed. If you wish to revisit this issue, you can reference the issue number above in a new request to <a href='mailto:help@uw.edu'>help@uw.edu</a>.";
              }

              echo "<h3 style='margin-top:2em;'>Additional comments:</h3>";

              usort( $comments, 'sortByCreatedOnDesc' ); //comments sorted chronologically descending
              echo "<ol style='margin-left:0;'>";


              $prevwatch = array();
              foreach( $comments as $comment ) {
                  $watcher = False;
                  $comment_user = $comment->sys_created_by;
                  //is this user the logged in user or do we know they're in the watch list already? if not get their SN sys_id
                  if ( !in_array($comment_user, $prevwatch) ) {
                      $user_url = '/sys_user_list.do?JSONv2&sysparm_query=user_name%3D' . $comment_user;
                      $user_json = get_SN($user_url, $args);
                      $comment_user_id = $user_json->records[0]->sys_id;
                      //Are they a watcher?
                      if ( in_array($comment_user_id, $watch_list) ) {
                          $watcher = True;
                          //We've seen them now
                          array_push($prevwatch, $comment_user);
                      }
                  } else if ( in_array($comment_user, $prevwatch) ) {
                      $watcher = True;
                  } else {

                  }
                  echo "<li class='media'>";
                  //Check who the commenter is, following roles win in order listed if a user is more than one
                  //caller?
                  if ($comment->sys_created_by == $caller_nid) {
                      echo "<div class='media-body support-comments'>";
                      $display_user = "Caller";
                  //watcher?
                  } elseif ($watcher) {
                      echo "<div class='media-body support-comments'>";
                      $display_user = "Watcher";
                  //support staff
                  } else {
                      echo "<div class='media-body support-comments'>";
                      $display_user = "UW-IT SUPPORT STAFF";
                  }
                  echo "<div class='comment-timestamp'><strong class='user_name'>$display_user</strong> <span class='create-date'>$comment->sys_created_on</span></div>";
                  echo "<pre>";
                  echo stripslashes($comment->value);
                  echo "</pre>";
                  echo "</div>";
                  echo "</li>";
                }
                echo "</ol>";
          }
      ?>
    </div><!-- #content -->
  </div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();

