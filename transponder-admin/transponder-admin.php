<?php
/*
*	Plugin Name: Trans*Ponder Volunteer/Admin Area
*	Description: Form submission moderation section for publicly submitted resources
*	Author: Team Dumpsterfire (Hack4acause 2018)
*	Version: 0.1
*/
	add_action('admin_menu', 'transponder_admin_menu');
	add_shortcode('transponder-volunteer','review_submission');
	function transponder_admin_menu() {
		add_menu_page( 'Trans*ponder Posts', 'Trans*ponder', 'manage_options', 'transponder-admin', 'transponder_pendingt', 'dashicons-rss', 1 );
		add_submenu_page('transponder-admin','Pending Submissions','Pending','manage_options', 'transponder-admin','transponder_pending');
		add_submenu_page('transponder-admin','Settings','Settings','manage_options', 'transponder-admin-settings','transponder_init');
	}	
	function transponder_init() {	
		
	}
	/*
	add_menu_page('My Custom Page', 'My Custom Page', 'manage_options', 'my-top-level-slug');
	add_submenu_page( 'my-top-level-slug', 'My Custom Page', 'My Custom Page',
		'manage_options', 'my-top-level-slug');
	add_submenu_page( 'my-top-level-slug', 'My Custom Submenu Page', 'My Custom Submenu Page',
		'manage_options', 'my-secondary-slug');
	*/
	function transponder_pending() {
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
			heading.append(jQuery("<td>Type of Services</td>"));
			heading.append(jQuery("<td>Provider Type</td>"));
			heading.append(jQuery("<td>Provider Name</td>"));
			for (var i = 0; i < data.length; i++) {
				drawRow(data[i]);
			}
		}
		function drawRow(rowData) {
			var row = jQuery("<tr />");
			jQuery("#mytable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
			row.append(jQuery("<td>" + rowData[2] + "</td>"));
			row.append(jQuery("<td>" + rowData[3] + "</td>"));
			row.append(jQuery("<td>" + rowData[7] + "</td>"));			
		}

	</script>
	<?php
	}
	function review_submission($atts) {
		$args = shortcode_atts(array('id'=>'-1'), $atts);
		if(strcmp($arfs['id'],'-1') == 0 {
			return "Nothing to review";
		}
		$formData = $args['id'];
		$entries = GFFormsModel::get_leads(1);
		echo "<script> window.leadData = ".json_encode($entries).";</script>";
		echo do_shortcode('[gravityform id="3" title="false" description="false"]');
		
	}
?>