<?php
/*
*	Plugin Name: Trans*Ponder Volunteer/Admin Area
*	Description: Form submission moderation section for publicly submitted resources
*	Author: Team Dumpsterfire (Hack4acause 2018)
*	Version: 0.1
*/
	function transponder_activate() {
		global $wpdb;
		$sql = "CREATE TABLE IF NOT EXISTS 
		wp_a3t9xkcyny_serviceProviders (
		  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
		  `lead_id` int(20) unsigned NOT NULL,
		  `is_provider_submitted` BOOL NOT NULL,
		  `service_type` TEXT(50) NOT NULL,
		  `medical_type` TEXT(50),
		  `mental_type` TEXT(50),
		  `surgical_type` TEXT(50),
		  `bodywork_type` TEXT(50),
		  `provider_name` TEXT(50) NOT NULL,
		  `office_name` TEXT(50),
		  `provider_address` TEXT(50),
		  `provider_address_2` TEXT(50),
		  `provider_city` TEXT(50),
		  `provider_state` TEXT(50),
		  `provider_zip` TEXT(10),
		  `provider_country` TEXT(10),
		  `provider_phone` TINYINT(15),
		  `provider_email` TEXT(25),
		  `provider_url` TEXT(25),
		  `submitter_feedback` TEXT(25),
		  `experience_rating` TINYINT(10),
		  `is_trans_experienced` BOOL NOT NULL,
		  `accepts_ohp` BOOL NOT NULL,
		  `accepts_private_insurance` BOOL NOT NULL,
		  `insured_providers` TEXT(255),
		  `accepts_medicare` BOOL NOT NULL,
		  `accepts_scale_payments` BOOL NOT NULL,
		  `scale_payment_desc` TEXT(255),
		  `is_awareness_trained` BOOL NOT NULL,
		  `awareness_training_date` DATE NULL,
		  `awareness_trainer` TEXT(25),
		  `required_trainees` TEXT(15),
		  `has_more_than_m_f` BOOL NOT NULL,
		  `pronoun_requested` BOOL NOT NULL,
		  `preferred_name_requested` BOOL NOT NULL,
		  `can_prescribe_hormones` BOOL,
		  `letters_of_assistance` TEXT(25),
		  `additional_comments` TEXT(10000),
		  PRIMARY KEY (`id`),
		  KEY `lead_id` (`lead_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$check = dbDelta($sql);
		//var_dump($check);
	}
	register_activation_hook(__FILE__, 'transponder_activate');
	add_action('admin_menu', 'transponder_admin_menu');
	add_action('admin_enqueue_scripts','shinyStuff');
	function shinyStuff() {
		wp_register_style('transponder-admin',plugins_url('style.css',__FILE__ ));
		wp_enqueue_style('transponder-admin', get_stylesheet_uri() );
	}
	function transponder_admin_menu() {
		add_menu_page( 'Trans*ponder Posts', 'Trans*ponder', 'delete_posts', 'transponder-admin', 'transponder_pending', plugins_url('transponder-admin/includes/images/pluginicon.png'), 1 );
		add_submenu_page('transponder-admin','Pending Submissions','Pending','delete_posts', 'transponder-admin','transponder_pending');
		add_submenu_page('transponder-admin','Admin','Admin','edit_users', 'transponder-admin-settings','transponder_vol');
	}
	function transponder_admin() {
		if(isset($_GET['create'])) {

		} elseif(isset($_GET['edit'])) {
			$id = $_GET['id'];
			review_vol($id);
		} else {
			echo do_shortcode('[gravityform id="5" title="false" description="false"]');
		}
	}
	function transponder_pending() {
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			review_submission($id);
		} else {
			echo "<h1>Pending Submissions</h1>";
			$entries = GFFormsModel::get_lead(1);
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
			function drawTable(data) {
				var heading = jQuery("<tr />");
				jQuery("#mytable").append(heading);
				heading.append(jQuery("<td>Submitted At</td>"));
				heading.append(jQuery("<td>Type of Services</td>"));
				heading.append(jQuery("<td>Provider Type</td>"));
				heading.append(jQuery("<td>Provider Name</td>"));
				heading.append(jQuery("<td>Review</td>"));
				for (var i = 0; i < data.length; i++) {
					drawRow(data[i]);
				}
			}
			function drawRow(rowData) {
				var row = jQuery("<tr />");
				jQuery("#mytable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
				row.append(jQuery("<td>" + rowData['date_created'] + "</td>"));
				row.append(jQuery("<td>" + rowData[2] + "</td>"));
				row.append(jQuery("<td>" + rowData[3] + "</td>"));
				row.append(jQuery("<td>" + rowData[7] + "</td>"));
				row.append(jQuery("<td><a href='admin.php?page=transponder-admin&id="+rowData['id']+"'>Start</a></td>"));
			}

		</script>
		<?php
		}
	}
	function transponder_vol() {
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			review_vol($id);
		} else {
			echo "<h1>Pending Submissions</h1>";
			$entries = GFFormsModel::get_lead(3);
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
			function drawTable(data) {
				var heading = jQuery("<tr />");
				jQuery("#mytable").append(heading);
				heading.append(jQuery("<td>Submitted At</td>"));
				heading.append(jQuery("<td>Type of Services</td>"));
				heading.append(jQuery("<td>Provider Type</td>"));
				heading.append(jQuery("<td>Provider Name</td>"));
				heading.append(jQuery("<td>Review</td>"));
				for (var i = 0; i < data.length; i++) {
					drawRow(data[i]);
				}
			}
			function drawRow(rowData) {
				var row = jQuery("<tr />");
				jQuery("#mytable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
				row.append(jQuery("<td>" + rowData['date_created'] + "</td>"));
				row.append(jQuery("<td>" + rowData[2] + "</td>"));
				row.append(jQuery("<td>" + rowData[3] + "</td>"));
				row.append(jQuery("<td>" + rowData[7] + "</td>"));
				row.append(jQuery("<td><a href='admin.php?page=transponder-admin-settings&edit&id="+rowData['id']+"'>Start</a></td>"));
			}

		</script>
		<?php
		}
	}
	function review_submission($id) {
		if(strcmp($id,'-1') == 0) {
			return "Nothing to review";
		}
		add_action( 'gform_after_submission_3', 'pending_reviewed', $id, 3 );
		$formData = $id;
		$check = $_GET['id'];
		$entries = GFFormsModel::get_lead(3); 
		$lead_id = 6;
		$lead = RGFormsModel::get_lead( $lead_id ); 
		$form = GFFormsModel::get_form_meta( $lead[3] );
		var_dump($form);
		echo "<script> window.whatData = ".json_encode($form).";</script>";
		echo "<script> window.leadData = ".json_encode($entries).";</script>";
		echo do_shortcode('[gravityform id="3" title="false" description="false"]');
		
		?>
		<script>
			leadData.forEach(function (lead) {
				Object.keys(lead).forEach(function (key) {
					var fieldId = key.replace('.', '_');
					jQuery('#input_3_'+fieldId).val(lead[key]);
				})
			})
		</script>
		<?php
	}
	function review_vol($id) {
		if(strcmp($id,'-1') == 0) {
			return "Nothing to review";
		}
		//add_action( 'gform_after_submission_5', 'pending_reviewed', $id, 5 );
		$formData = $id;
		$check = $_GET['id'];
		var_dump($check);
		var_Dump($_GET);
		$entries = GFFormsModel::get_lead(5);
		echo "<script> window.leadData = ".json_encode($entries).";</script>";
		echo do_shortcode('[gravityform id="5" title="false" description="false"]');
		
		?>
		<script>
			leadData.forEach(function (lead) {
				Object.keys(lead).forEach(function (key) {
					var fieldId = key.replace('.', '_');
					jQuery('#input_5_'+fieldId).val(lead[key]);
				})
			})
		</script>
		<?php
	}
	function pending_reviewed($entry, $form) {
		//echo "<h1>WORKS</h1>";
		RGFormsModel::save_input($form, $field, $lead, $current_fields, $input_id);
	}
?>