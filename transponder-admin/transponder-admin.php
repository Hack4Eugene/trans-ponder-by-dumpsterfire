<?php

require_once('includes/transponder-admin-2.php');

/*
*    Plugin Name: Trans*Ponder Volunteer/Admin Area
*    Description: Form submission moderation section for publicly submitted resources
*    Author: Team Dumpsterfire (Hack4acause 2018)
*    Version: 0.5 (MVP Candidate)
*/

    // Add Trans*ponder to the WordPress admin menu
    add_action('admin_menu', 'transponder_admin_menu');
    
    // Apply a bit of polish and make things display a little better
    add_action('admin_enqueue_scripts','shinyStuff'); 

    /* shinyStuff brings in our stylesheet so we can style the admin section without having to do a bunch of inline shenanigans */ 
    function shinyStuff() 
    {
        wp_register_style('transponder-admin',plugins_url('style.css',__FILE__ ));
        wp_enqueue_style('transponder-admin', get_stylesheet_uri() );
    }
    
    /* transponder_admin_menu sets up the admin menu with 2 option. The Admin option is only available to Administrators and Volunteers can't access this */
    function transponder_admin_menu() 
    {
        add_menu_page( 
            'Trans*ponder Posts', 
            'Trans*ponder', 
            'edit_posts', 
            'transponder-admin',
            'pending_vol_review', 
            plugins_url('transponder-admin/includes/images/pluginicon.png'), 0 
        );
        add_submenu_page(
            'transponder-admin',
            'Pending Submissions',
            'Volunteer',
            'edit_posts', 
            'transponder-admin',
            'pending_vol_review'
        );
        add_submenu_page(
            'transponder-admin',
            'Admin Review',
            'Admin',
            'edit_users', 
            'transponder-admin-review',
            'pending_admin_review'
        );
        add_submenu_page(
            'transponder-admin',
            'Live and Archived',
            'Live/Archived',
            'edit_users', 
            'transponder-live-archived-list',
            'list_live_and_archived'
        );
    }
    
    /*
    *     Setup Custom Post Type for Approved Submissions
    */
    function create_resources_post_type() 
    {
        $labels = array(
            'name' => 'Resource Suggestions',
            'singular_name' => 'Resource Suggestion'
        );
        $args = array (
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'publicly_queryable' => true,
            'query_var' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'heirarchical' => false,
            'menu_icon' => 'dashicons-location-alt',
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail',
                'revisions',
        ),
        'taxonomies' => array('category','post_tag'),
        'menu_position' => 1
        );
        register_post_type('resourcesuggestions',$args);
    }
    
    add_action('init','create_resources_post_type');
    
    function get_taxonomy_queries( $query ) 
    {
        if ( ( $query->is_category() || $query->is_tag() )
            && $query->is_main_query() ) {
                $query->set( 'post_type', array( 'post', 'resourcesuggestions' ) );
        }
    }
    
    add_action( 'pre_get_posts', 'get_taxonomy_queries' );
    
    register_taxonomy_for_object_type('category', 'resourcesuggestions');
    
    /*    
    *    pending_vol_review is the Volunteer review section, admins can use this 
    *   to look at new submissions as well, that allows
    *    the review workflow to proceed forward and be vetted before an admin is 
    *   needed to approve the submission
    */    
    function pending_vol_review() 
    {
        if (rgget('eid') !== '') {
            echo do_shortcode('[gravityform id=12 title="false" description="false"]');
        } else {
            $entries = retrieveEntriesFromDb('pending_vol_review');
            echo "<h1>Pending Submissions Ready for Volunteers to Review</h1>";
            echo "<script> window.entries = ".json_encode($entries).";</script>"; 
            echo "<div id='formEntries'></div>";
            ?><!--
                This script sets up the table we need to display those entries to our volunteers within the WordPress dashboard
            -->
            <script>
                var tbl=jQuery("<table/>").attr("id","mytable");
                jQuery("#formEntries").append(tbl);
                jQuery("#mytable").attr("class","table");
                document.addEventListener("DOMContentLoaded", function(){
                    drawTable(entries);
                });

                function drawTable(entries) {
                    var heading = jQuery("<tr />");
                    jQuery("#mytable").append(heading);
                    heading.append(jQuery("<td class='heading'>Table ID</td>"));
                    heading.append(jQuery("<td class='heading'>Type of Services</td>"));
                    heading.append(jQuery("<td class='heading'>Provider Type</td>"));
                    heading.append(jQuery("<td class='heading'>Provider Name</td>"));
                    heading.append(jQuery("<td class='heading'>Review</td>"));
                    for (var i = 0; i < entries.length; i++) {
                        drawRow(entries[i]);
                    }
                }

                function drawRow(rowData) {
                    var row = jQuery("<tr />");
                    // this will append tr element to table... keep its reference for a while since we will add cells into it
                    jQuery("#mytable").append(row); 
                    // Table ID
                    row.append(jQuery("<td>" + rowData.id + "</td>"));
                    // Type of Services
                    row.append(jQuery("<td>" + rowData.service_type + rowData.other_service_type + "</td>"));
                    // Provider Type
                    row.append(jQuery("<td>" + rowData.medical_type + rowData.mental_type + 
                        rowData.surgical_type + rowData.bodywork_type + rowData.other_provider_type + "</td>"));
                    // Provider Name
                    row.append(jQuery("<td>" + rowData.provider_name + "</td>"));
                    // Click to Review entry
                    row.append(jQuery("<td><a class='button' href='admin.php?page=transponder-admin&user_type=volunteer&eid=" +     
                        rowData['id']+"'>Start</a></td>"));
                }
            </script><?php
        }
    }
        
        /*    
        *    pending_admin_review is the admin view and populates the form using the 
        *   information entered by the community and our volunteer
        */    
        function pending_admin_review() {
            if( rgget('eid') !== '' ){
                echo do_shortcode('[gravityform id=12 title="false" description="false"]');
            } else {
                $entries = retrieveEntriesFromDb('pending_admin_review');
                echo "<h1>Pending Submissions for Final Review by Admin</h1>";
                echo "<script> window.entries = ".json_encode($entries).";</script>";
                echo "<div id='formEntries'></div>";
                ?><script>
                    var tbl=jQuery("<table/>").attr("id","mytable");
                    jQuery("#formEntries").append(tbl);
                    jQuery("#mytable").attr("class","table");
                    document.addEventListener("DOMContentLoaded", function(){
                        drawTable(entries);
                    });
        
                    function drawTable(entries) 
                    {
                        var heading = jQuery("<tr />");
                        jQuery("#mytable").append(heading);
                        heading.append(jQuery("<td class='heading'>Table ID</td>"));
                        heading.append(jQuery("<td class='heading'>Type of Services</td>"));
                        heading.append(jQuery("<td class='heading'>Provider Type</td>"));
                        heading.append(jQuery("<td class='heading'>Provider Name</td>"));
                        heading.append(jQuery("<td class='heading'>Review</td>"));
                        for (var i = 0; i < entries.length; i++) {
                            if(entries[i]['visible'] !== false) {
                                drawRow(entries[i]);
                            }
                        }
                    }
        
                    function drawRow(rowData) 
                    {
                        var row = jQuery("<tr />");
                        jQuery("#mytable").append(row); //this will append tr element to table... keep its reference for a while since we will add cells into it
                        // Table ID
                        row.append(jQuery("<td>" + rowData.id + "</td>"));
                        // Type of Services
                        row.append(jQuery("<td>" + rowData.service_type + " " + rowData.other_service_type + "</td>"));
                        // Provider Type
                        row.append(jQuery("<td>" + rowData.medical_type + rowData.mental_type + 
                            rowData.surgical_type + rowData.bodywork_type + " " + rowData.other_provider_type + "</td>"));
                        // Provider Name
                        row.append(jQuery("<td>" + rowData.provider_name + "</td>"));
                        // Click to Review entry
                        row.append(jQuery("<td><a class='button' href='admin.php?page=transponder-admin-review&user_type=admin&eid=" +
                        rowData.id + "'>Start</a></td>"));
                    }
                </script><?php
            }
        }

    /*    
     *    list_archived_and_live shows the entries that have been posted live or has been archived.
     */    
    function list_live_and_archived() {
        if( rgget('eid') !== '' ){
            echo do_shortcode('[gravityform id=12 title="false" description="false"]');
        } else {
            $entries = retrieveEntriesFromDb('live_and_archived');
            echo "<h1>Live and Archived Entries</h1>";
            echo "<script> window.entries = ".json_encode($entries).";</script>";
            echo "<div id='formEntries'></div>";
            ?><script>
                var tbl=jQuery("<table/>").attr("id","mytable");
                jQuery("#formEntries").append(tbl);
                jQuery("#mytable").attr("class","table");
                document.addEventListener("DOMContentLoaded", function(){
                    drawTable(entries);
                });

                function drawTable(entries) 
                {     
                    var heading = jQuery("<tr />");
                    jQuery("#mytable").append(heading);
                    heading.append(jQuery("<td class='heading'>id</td>"));
                    heading.append(jQuery("<td class='heading'>Type of Services</td>"));
                    heading.append(jQuery("<td class='heading'>Provider Type</td>"));
                    heading.append(jQuery("<td class='heading'>Provider Name</td>"));
                    heading.append(jQuery("<td class='heading'>Publish to Web</td>"));
                    heading.append(jQuery("<td class='heading'>Follow Up Status</td>"));
                    heading.append(jQuery("<td class='heading'>Edit</td>"));
                    for (var i = 0; i < entries.length; i++) {
                        drawRow(entries[i]);
                    }
                }

                function drawRow(rowData) 
                {
                    var row = jQuery("<tr />");
                    jQuery("#mytable").append(row); //this will append tr element to table... keep its reference for a while since we will add cells into it
                    // Table ID
                    row.append(jQuery("<td>" + rowData.id + "</td>"));
                    // Type of Services
                    row.append(jQuery("<td>" + rowData.service_type + " " + rowData.other_service_type + "</td>"));
                    // Provider Type
                    row.append(jQuery("<td>" + rowData.medical_type + rowData.mental_type + 
                        rowData.surgical_type + rowData.bodywork_type + " " + rowData.other_provider_type + "</td>"));
                    // Provider Name
                    row.append(jQuery("<td>" + rowData.provider_name + "</td>"));
                    // Publish to Web?
                    row.append(jQuery("<td>" + rowData.publish_to_web + "</td>"));
                    // Follow Up Status
                    if (rowData.publish_to_web !== 'Yes') {
                        row.append(jQuery("<td>" + rowData.followup_needed + "</td>"));
                    } else {
                        row.append(jQuery("<td>Post is Live</td>"));
                    }
                    // Click to Edit entry
                    row.append(jQuery("<td><a class='button' href='admin.php?page=transponder-live-archived-list&user_type=admin&eid=" 
                        + rowData.id + "'>Start</a></td>"));
                }
            </script><?php
        }
    }
    
    /*
    * Query the providers_table in the database for Live and Archived entries.
    */
    function retrieveEntriesFromDb($stage)
    {
        global $wpdb; 
        $tableName = $wpdb->prefix . 'providers_table';
        
        switch ($stage) {
            case 'pending_vol_review':
                $entries = $wpdb->get_results(
                    'SELECT id, service_type, other_service_type, medical_type, mental_type, surgical_type, bodywork_type, other_provider_type, provider_name, is_review_ready, is_review_ready_2, followup_needed FROM ' . $tableName 
                );
                return filter_pending_vol_review($entries);
            case 'pending_admin_review':
                $entries = $wpdb->get_results(
                    'SELECT id, service_type, other_service_type, medical_type, mental_type, surgical_type, bodywork_type, other_provider_type, provider_name, is_review_ready, is_review_ready_2, publish_to_web, followup_needed FROM ' . $tableName
                );
                return filter_pending_admin_review($entries);
            case 'live_and_archived':
                return $wpdb->get_results(
                    'SELECT id, service_type, other_service_type, medical_type, mental_type, surgical_type, bodywork_type, other_provider_type, provider_name, publish_to_web, followup_needed FROM ' . 
                    $tableName . ' WHERE publish_to_web = "Yes" OR followup_needed = "Send to Archive"'
                );
            default:
                break;
        }
    }

    /*
     * Community submited rows should only be visible to volunteers
     * if is_review_ready is not 'yes' or if it is, it is visible if
     * the followup_needed is 'send back to volunteer', or if the second
     * is_review_ready_2 is no.
     */
    function filter_pending_vol_review ($dbEntries)
    {
        $filteredEntries = [];
        
        $count = count($dbEntries);
        for ($i=0; $i<$count; $i++) {
            $show = true;
            
            if (
                $dbEntries[$i]->is_review_ready === 'Yes'
                || $dbEntries[$i]->followup_needed === 'Send to Archive'
                || $dbEntries[$i]->followup_needed === 'Send Back to Admin Verification List'
                || $dbEntries[$i]->is_review_ready_2 === 'Yes'
            ) {
                $show = false;
            }
            
            if (
                ( $dbEntries[$i]->followup_needed === 'Send Back to Volunteer Verification List'
                    && $dbEntries[$i]->is_review_ready_2 === 'No' )
                || ( $dbEntries[$i]->followup_needed === 'Send Back to Volunteer Verification List'
                    && $dbEntries[$i]->is_review_ready_2 === '' )
            ) {
                $show = true;
            }
            
            if ($show) {
                $filteredEntries[] = $dbEntries[$i];
            }
        }
        return $filteredEntries;
    }

    /*
     * volunteer submitted rows should only be visible to admins if
     * is_review_ready = 'yes' and not sent back to Volunteer's pending
     * list, not sent to archives.
     */
    function filter_pending_admin_review ($dbEntries)
    {
        $filteredEntries = [];
        
        $count = count($dbEntries);
        for ($i=0; $i<$count; $i++) {
            if (
                $dbEntries[$i]->is_review_ready === 'No'
                || $dbEntries[$i]->is_review_ready === ''
                || ( $dbEntries[$i]->followup_needed === 'Send Back to Volunteer Verification List'
                    && $dbEntries[$i]->is_review_ready_2 === 'No' )
                || ( $dbEntries[$i]->followup_needed === 'Send Back to Volunteer Verification List'
                    && $dbEntries[$i]->is_review_ready_2 === ''
                )
                || $dbEntries[$i]->publish_to_web === 'Yes'
                || $dbEntries[$i]->followup_needed === 'Send to Archive'
                || $dbEntries[$i]->is_review_ready_2 === 'No'
            ) {
                // don't do anything
            } else {
                $filteredEntries[] = $dbEntries[$i];
            }
        }
        return $filteredEntries;
    }
