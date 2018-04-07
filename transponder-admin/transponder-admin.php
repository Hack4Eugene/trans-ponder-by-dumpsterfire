<?php
/*
*	Plugin Name: Trans*Ponder Volunteer/Admin Area
*	Description: Form submission moderation section for publicly submitted resources
*	Author: Team Dumpsterfire (Hack4acause 2018)
*	Version: 0.1
*/
	add_action('admin_menu', 'transponder_admin_menu');
	function transponder_admin_menu() {
		add_menu_page( 'Trans*ponder Posts', 'Trans*ponder', 'manage_options', 'transponder-admin', 'transponder_init', 'dashicons-rss', 1 );
	}	
	function transponder_init() {
	
		echo "<h1>There once was a heading</h1>";
		$entries = GFFormsModel::get_leads(1);
		var_dump($entries);
		/*$lead_id = 1;
		$lead = RGFormsModel::get_lead( $lead_id ); 
		$form = GFFormsModel::get_form_meta( $lead['form_id'] ); 

		$values= array();

		foreach( $form['fields'] as $field ) {

			$values[$field['id']] = array(
				'id'    => $field['id'],
				'label' => $field['label'],
				'value' => $lead[ $field['id'] ],
			);
		
		}
		print_r($values);*/
	}
?>