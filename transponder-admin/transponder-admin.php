<?php

include_once('includes/transponder-admin-2.php');

/*
*	Plugin Name: Trans*Ponder Volunteer/Admin Area
*	Description: Form submission moderation section for publicly submitted resources
*	Author: Team Dumpsterfire (Hack4acause 2018)
*	Version: 0.4 (MVP Candidate)
*/
		
	/*	Create a custom table to store all submissions after review
	*	This table contains every field available on the admin 
    *	view form. It is the form that helps to determine 
    *   which rows in the Volunteer and Admin Pending Review tables are displayed 
	*/	
    function create_providers_table() 
    {
        global $wpdb;
        
        $table_name = $wpdb->prefix . "providers_table";
        $charset_collate = $wpdb->get_charset_collate();

        $sql = 'CREATE TABLE IF NOT EXISTS ' . $table_name . ' (
            id int(20) unsigned NOT NULL AUTO_INCREMENT,
            lead_id int(20) unsigned NOT NULL,
            is_provider_submitted text,
            service_type text,
            other_service_type text,
            medical_type text,
            mental_type text,
            surgical_type text,
            bodywork_type text,
            other_provider_type text,
            provider_name text,
            office_name text,
            provider_address text,
            provider_address_2 text,
            provider_city text,
            provider_state text,
            provider_zip tinytext,
            provider_country tinytext,
            provider_phone text,
            provider_email text,
            provider_url text,
            submitter_feedback text,
            experience_rating tinytext,
            is_trans_experienced tinytext,
            accepts_ohp tinytext,
            accepts_private_insurance tinytext,
            accepted_insurance text,
            accepts_medicare tinytext,
            accepts_scale_payments tinytext,
            scale_payment_desc text,
            is_awareness_trained tinytext,
            awareness_training_date date,
            awareness_trainer text,
            required_trainee_office text,
            required_trainee_caseWkr text,
            required_trainee_doctor text,
            required_trainee_admStaff text,
            required_trainee_allStaff text,
            required_trainee_other text,
            has_more_than_m_f tinytext,
            options_other_than_m_f text,
            pronoun_requested tinytext,
            preferred_name_requested tinytext,
            can_prescribe_hormones tinytext,
            assist_letter_hormones text,
            assist_letter_identDocChng text,
            assist_letter_gdrAffSurg text,
            additional_comments text,
            is_review_ready tinytext,
            admin_first_name text,
            admin_last_name text,
            publish_to_web tinytext,
            followup_needed tinytext,
            reason_followup_needed text,
            post_title text,
            post_body text,
            post_tags text,
            post_category text,
            comm_id text,
            vol_id text,

            PRIMARY KEY  (id),
            KEY lead_id (lead_id)
            ) ' . $charset_collate . ';';
        
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
    }

    // When plugin is activated check and create the table if necessary
	register_activation_hook(__FILE__, 'create_providers_table'); 
    
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
		add_menu_page( 'Trans*ponder Posts', 'Trans*ponder', 'edit_posts', 'transponder-admin', 'transponder_pending', plugins_url('transponder-admin/includes/images/pluginicon.png'), 0 );
		add_submenu_page('transponder-admin','Pending Submissions','Pending','edit_posts', 'transponder-admin','transponder_pending');
		add_submenu_page('transponder-admin','Admin','Admin','edit_users', 'transponder-admin-settings','transponder_vol');
    }
    
	/*
	*	 Setup Custom Post Type for Approved Submissions
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
			'suppports' => array(
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
	*	This function is under development
	*	Scope: Administrators should be able to add resources without review
    *	Acceptance Criteria: Admins only, Check if we are editing an existing form 
    *   or creating a new one, provide admin view of form 
    function transponder_admin() {
		
		if(isset($_GET['create'])) {

		} elseif(isset($_GET['edit'])) {
			$id = $_GET['id'];
			review_vol($id);
		} else {
			echo do_shortcode('[gravityform id="5" title="false" description="false"]');
		}
	}
	*/
    
    /*	
    *	transponder_pending is the Volunteer review section, admins can use this 
    *   to look at new submissions as well, that allows
    *	the review workflow to proceed forward and be vetted before an admin is 
    *   needed to approve the submission
    */	
    function transponder_pending() 
    {
		$entries = GFFormsModel::get_leads(1);
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			review_submission($id);
		} else {
            echo "<h1>Pending Submissions Ready for Volunteers to Review</h1>";
            
            // This will grab all of the entries from the community based form
            $entries = GFFormsModel::get_leads(1);	

            // determine if each entry is visible or not.
            addIsVisibleToEntries('comm', $entries);

            // This outputs a json string we can use on the front end
            echo "<script> window.leadData = ".json_encode($entries).";</script>"; 
			echo "<div id='formEntries'></div>";
			?>
		<!--
			This script sets up the table we need to display those entries to our volunteers within the WordPress dashboard
		-->
		<script>
			var tbl=jQuery("<table/>").attr("id","mytable");
			jQuery("#formEntries").append(tbl);
			jQuery("#mytable").attr("class","table");
			document.addEventListener("DOMContentLoaded", function(){
				drawTable(leadData);
			});

			function drawTable(data) {
				var heading = jQuery("<tr />");
				jQuery("#mytable").append(heading);
				heading.append(jQuery("<td class='heading'>Submitted At</td>"));
				heading.append(jQuery("<td class='heading'>Type of Services</td>"));
				heading.append(jQuery("<td class='heading'>Provider Type</td>"));
				heading.append(jQuery("<td class='heading'>Provider Name</td>"));
				heading.append(jQuery("<td class='heading'>Review</td>"));
				for (var i = 0; i < data.length; i++) {
                    // draw row if "is_review_ready" = "No" on the volunteer's form.
					if (data[i]['visible'] !== false) {
                        drawRow(data[i]);
                    }
				}
			}

			function drawRow(rowData) {
				//console.log(rowData);
				var row = jQuery("<tr />");
				jQuery("#mytable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
				row.append(jQuery("<td>" + rowData['date_created'] + "</td>"));
				row.append(jQuery("<td>" + rowData[2] + "</td>"));
				row.append(jQuery("<td>" + rowData[3] + "</td>"));
				row.append(jQuery("<td>" + rowData[7] + "</td>"));
				row.append(jQuery("<td><a class='button' href='admin.php?page=transponder-admin&id="+rowData['id']+"'>Start</a></td>"));
			}

		</script>
		<?php
		}
    }
    
    /*	
    *	transponder_vol is the admin view and populates the form using the 
    *   information entered by the community and our volunteer
    */	
	function transponder_vol() {
        $entries = GFFormsModel::get_leads(3);

		if(isset($_GET['id'])){
			$id = $_GET['id'];
			review_vol($id);
		} else {
			echo "<h1>Pending Submissions for Final Review by Admin</h1>";
            $entries = GFFormsModel::get_leads(3);

            // determine if each entry should be visible or not
            addIsVisibleToEntries('vol', $entries);

			echo "<script> window.leadData = ".json_encode($entries).";</script>";
			echo "<div id='formEntries'></div>";
			?>
		<script>
			var tbl=jQuery("<table/>").attr("id","mytable");
			jQuery("#formEntries").append(tbl);
			jQuery("#mytable").attr("class","table");
			document.addEventListener("DOMContentLoaded", function(){
				drawTable(leadData);
			});

            function drawTable(data) 
            {
                
                var heading = jQuery("<tr />");
                jQuery("#mytable").append(heading);
                heading.append(jQuery("<td class='heading'>Submitted At</td>"));
                heading.append(jQuery("<td class='heading'>Type of Services</td>"));
                heading.append(jQuery("<td class='heading'>Provider Type</td>"));
                heading.append(jQuery("<td class='heading'>Provider Name</td>"));
                heading.append(jQuery("<td class='heading'>Review</td>"));
                for (var i = 0; i < data.length; i++) {
                    if(data[i]['visible'] !== false) {
                        drawRow(data[i]);
                    }
                }
            }

            function drawRow(rowData) 
            {
                // console.log(rowData);
                var row = jQuery("<tr />");
                jQuery("#mytable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
                row.append(jQuery("<td>" + rowData['date_created'] + "</td>"));
                row.append(jQuery("<td>" + rowData[2] + "</td>"));
                row.append(jQuery("<td>" + rowData[3] + "</td>"));
                row.append(jQuery("<td>" + rowData[7] + "</td>"));
                row.append(jQuery("<td><a class='button' href='admin.php?page=transponder-admin-settings&id="+rowData['id']+"'>Start</a></td>"));
            }

		</script>
		<?php
		}
    }
    
    /*	
    *	This is our volunteer view, this allows them to review the submission 
    *   we received and fill out more information as they talk with the provider
    */	
    function review_submission($id) 
    {
        // There should not be any negative form ids
		if(strcmp($id,'-1') == 0) {  
			return "Nothing to review";
		}
        $entries = GFFormsModel::get_leads(1);

		foreach($entries as $entry) {
			$lead_id = $entry['id'];
			$lead = RGFormsModel::get_lead( $lead_id ); 
			if($entry['id'] == $_GET['id']) {
				echo "<script> window.leadData = ".json_encode($entry).";</script>";
			}
        }
        // Maybe add filter here?
		echo do_shortcode('[gravityform id="3" title="false" description="false"]');
		
		?>
		<script>
			Object.keys(leadData).forEach(function (key) {
				var fieldId = key.replace('.', '_');
				jQuery('#input_3_'+fieldId).val(leadData[key]);
			})
            // store the community submission entry id (id => comm_id)
            jQuery('#input_3_44').val(leadData['id']);
		
        </script>
		<?php
    }
    
    /*	
    *	This is our admin review view that will be populated with the community 
    *   and volunteer additions if it passed review
    */	
    function review_vol($id) 
    {
		if(strcmp($id,'-1') == 0) {
			return "Nothing to review";
		}
        $entries = GFFormsModel::get_leads(3);

		foreach($entries as $entry) {
			$lead_id = $entry['id'];
			$lead = RGFormsModel::get_lead( $lead_id ); 
			if($entry['id'] == $_GET['id']) {
				echo "<script> window.leadData = ".json_encode($entry).";</script>";
			}
		}
		echo do_shortcode('[gravityform id="5" title="false" description="false"]');
		
		?>
		<script>
			Object.keys(leadData).forEach(function (key) {
				var fieldId = key.replace('.', '_');
				jQuery('#input_5_'+fieldId).val(leadData[key]);
			});
			jQuery('#input_5_53').val(leadData[14]);
			jQuery('#input_5_54').val(leadData[7]);
			jQuery('#input_5_55').val(leadData[2]);

            // store the community submission entry id (id => comm_id) as well as the volunteer submission entry id (id => vol_id).
			jQuery('#input_5_57').val(leadData[44]);
			jQuery('#input_5_58').val(leadData['id']);
            //console.log('the admin form should obtain comm_id as ' + leadData[44] + ' and vol_id should be ' . leadData['id']);
		</script>
		<?php
    }
    
    /*
     * Given the form type (volunteer or admin), determine
     * if it should be on the Volunteer's or Admin's Pending Lists or no list.
     */
    function addIsVisibleToEntries($formType, & $entriesArray)
    {
        foreach ($entriesArray as &$entry) {
            if ($formType === 'comm') {
                $entry['visible'] = isCommVisible($entry['id']);
            }

            if ($formType === 'vol') {
                $entry['visible'] = isVolVisible($entry[44]);
            }
        }
    }

    /*
     * Community submited rows should only be visible to volunteers
     * if is_review_ready = 'no', otherwise, it should be on
     * the admin's pending review page
     */
    function isCommVisible ($entryID)
    {
        global $wpdb; 
        $tableName = $wpdb->prefix . 'providers_table';

        $data=$wpdb->get_results(
                'SELECT is_review_ready  FROM ' . $tableName . ' WHERE comm_id = ' . $entryID 
            );
            
            if (
                $data[0]->is_review_ready === 'Yes'
                || $data[0]->followup_needed === 'Send Back to Volunteer Verification List'
                ) {
                return false;
            } 
            
            return true;
    }

    /*
     * volunteer submitted rows should only be visible to admins if
     * is_review_ready = 'yes' and not sent back to Volunteer's pending
     * list.
     */
    function isVolVisible ($entryID)
    {
        global $wpdb; 
        $tableName = $wpdb->prefix . 'providers_table';

        $data=$wpdb->get_results(
                'SELECT is_review_ready, publish_to_web, followup_needed, followup_needed FROM ' . $tableName . ' WHERE comm_id = ' . $entryID 
            );

            if (
                $data[0]->is_review_ready === 'No'
                || $data[0]->publish_to_web === 'Yes' 
                || $data[0]->followup_needed === 'Send Back to Volunteer Verification List'
                || $data[0]->followup_needed === 'Send to Archive'
            ) {
                return false;
            } 
            return true;
    }




?>