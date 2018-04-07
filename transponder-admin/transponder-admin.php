<?php
/*
*	Plugin Name: Trans*Ponder Volunteer/Admin Area
*	Description: Form submission moderation section for publicly submitted resources
*	Author: Team Dumpsterfire (Hack4acause 2018)
*	Version: 0.1
*/
	add_action('admin_menu', 'transponder_admin_menu');
	add_action('admin_enqueue_scripts','shinyStuff');
	function my_custom_admin_head() {
		echo "<script src='https://www.google.com/recaptcha/api.js'></script>";
	}
	add_action( 'admin_head', 'my_custom_admin_head' );
	function shinyStuff() {
		wp_register_style('transponder-admin',plugins_url('style.css',__FILE__ ));
		wp_enqueue_style('transponder-admin', get_stylesheet_uri() );
		wp_enqueue_scripts('transponder-admin', 'https://www.google.com/recaptcha/api.js');
	}
	function transponder_admin_menu() {
		add_menu_page( 'Trans*ponder Posts', 'Trans*ponder', 'delete_posts', 'transponder-admin', 'transponder_pending', plugins_url('transponder-admin/includes/images/pluginicon.png'), 1 );
		add_submenu_page('transponder-admin','Pending Submissions','Pending','delete_posts', 'transponder-admin','transponder_pending');
		add_submenu_page('transponder-admin','Admin','Admin','edit_users', 'transponder-admin-settings','transponder_admin');
	}
	function transponder_admin() {
		if(isset($_GET['create'])) {

		} elseif(isset($_GET['edit'])) {

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
			$entries = GFFormsModel::get_leads(1);
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
	function review_submission($id) {
		if(strcmp($id,'-1') == 0) {
			return "Nothing to review";
		}
		add_action( 'gform_after_submission_3', 'pending_reviewed', $id, 3 );
		$formData = $id;
		$entries = GFFormsModel::get_leads($id);
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
	function pending_reviewed($entry, $form) {
		?> <script>alert("review removed");</script> <?php
	}
?>