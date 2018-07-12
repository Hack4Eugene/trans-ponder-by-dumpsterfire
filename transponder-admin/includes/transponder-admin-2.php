<?php

/*
*	Plugin Name: Trans*Ponder Volunteer/Admin Area
*	Description: Form submission moderation section for publicly submitted resources
*	Author: Team Dumpsterfire (Hack4acause 2018)
*	Version: 0.4 (MVP Candidate)
*/
		
/*	
*   This collection of functions is a continuation of the transponder-admin
*   collection. It deals with saving data into the transponder custom table
*   upon submission of the provider information form.
*/	

register_activation_hook('transponder-admin/transponder-admin.php', 'create_providers_table'); 
add_action('gform_after_submission_12', 'add_or_update_entries_to_db', 10, 2);

	/*	Create a custom table to store all submissions after review
	*	This table contains every field available on the admin 
    *	view form. It is the form that helps to determine 
    *   which rows in the Volunteer and Admin Pending Review tables are displayed 
	*/	

function add_or_update_entries_to_db($entry, $form)
{
    global $wpdb;

    $exists = $wpdb->get_results( 
        $wpdb->prepare(
            "SELECT lead_id FROM wp_a3t9xkcyny_providers_table WHERE lead_id = %d",
            $entry['id'] 
        )
    );
    
    if (count($exists) > 0) {
        update_entries_in_db($entry, $form);
        return;
    }

    $wpdb->insert(
        'wp_a3t9xkcyny_providers_table',
        array(
        'lead_id'                   => $entry['id'],        
        'is_provider_submitted'     => $entry[47],
        'service_type'              => $entry[2],    
        'other_service_type'        => $entry[59],    
        'medical_type'              => $entry[3],    
        'mental_type'               => $entry[4],   
        'surgical_type'             => $entry[5],     
        'bodywork_type'             => $entry[6],     
        'other_provider_type'       => $entry[60],     
        'provider_name'             => $entry[7],     
        'office_name'               => $entry[8],   
        'provider_address'          => $entry['9.1'],        
        'provider_address_2'        => $entry['9.2'],          
        'provider_city'             => $entry['9.3'],     
        'provider_state'            => $entry['9.4'],      
        'provider_zip'              => $entry['9.5'],    
        'provider_country'          => $entry['9.6'],        
        'provider_phone'            => $entry[10],      
        'provider_email'            => $entry[11],      
        'provider_url'              => $entry[12],    
        'submitter_feedback'        => $entry[48],          
        'experience_rating'         => $entry[49],         
        'is_trans_experienced'      => $entry[26],            
        'accepts_ohp'               => $entry[17],   
        'accepts_private_insurance' => $entry[18],                 
        'accepted_insurance'        => $entry[19],          
        'accepts_medicare'          => $entry[20],        
        'accepts_scale_payments'    => $entry[21],              
        'scale_payment_desc'        => $entry[22],          
        'is_awareness_trained'      => $entry[27],            
        'awareness_training_date'   => $entry[30],               
        'awareness_trainer'         => $entry[29],         
        'required_trainee_office'   => $entry['56.1'],         
        'required_trainee_caseWkr'  => $entry['56.2'],         
        'required_trainee_doctor'   => $entry['56.3'],         
        'required_trainee_admStaff' => $entry['56.4'],         
        'required_trainee_allStaff' => $entry['56.5'],         
        'required_trainee_other'    => $entry['56.6'], 
        'req_trainee_other_desc'    => $entry[63],           
        'has_more_than_m_f'         => $entry[33],         
        'options_other_than_m_f'    => $entry[34],              
        'pronoun_requested'         => $entry[35],         
        'preferred_name_requested'  => $entry[36],                
        'can_prescribe_hormones'    => $entry[23],              
        'assist_letter_hormones'    => $entry['50.1'],         
        'assist_letter_identDocChng'=> $entry['50.2'],         
        'assist_letter_gdrAffSurg'  => $entry['50.3'],         
        'additional_comments'       => $entry[14],           
        'is_review_ready'           => $entry[51],       
        'admin_first_name'          => $entry['39.3'],        
        'admin_last_name'           => $entry['39.6'],       
        'publish_to_web'            => $entry[40],      
        'followup_needed'           => $entry[42],          
        'reason_followup_needed'    => $entry[45],                   
        'is_review_ready_2'         => $entry[68],
        'volunteer_notes'           => $entry[67],
        'post_title'                => $entry[52],  
        'post_body'                 => $entry[53], 
        'post_tags'                 => $entry[54], 
        'post_category'             => $entry[55],
        'last_user_type'            => $entry[61],
        'last_user_level'           => $entry[66]
        )
    );
}

function update_entries_in_db($entry, $form)
{
    global $wpdb;

    $entries =  array(
        'is_provider_submitted'     => $entry[47],
        'service_type'              => $entry[2],    
        'other_service_type'        => $entry[59],    
        'medical_type'              => $entry[3],    
        'mental_type'               => $entry[4],   
        'surgical_type'             => $entry[5],     
        'bodywork_type'             => $entry[6],     
        'other_provider_type'       => $entry[60],     
        'provider_name'             => $entry[7],     
        'office_name'               => $entry[8],   
        'provider_address'          => $entry['9.1'],        
        'provider_address_2'        => $entry['9.2'],          
        'provider_city'             => $entry['9.3'],     
        'provider_state'            => $entry['9.4'],      
        'provider_zip'              => $entry['9.5'],    
        'provider_country'          => $entry['9.6'],        
        'provider_phone'            => $entry[10],      
        'provider_email'            => $entry[11],      
        'provider_url'              => $entry[12],    
        'submitter_feedback'        => $entry[48],          
        'experience_rating'         => $entry[49],         
        'is_trans_experienced'      => $entry[26],            
        'accepts_ohp'               => $entry[17],   
        'accepts_private_insurance' => $entry[18],                 
        'accepted_insurance'        => $entry[19],          
        'accepts_medicare'          => $entry[20],        
        'accepts_scale_payments'    => $entry[21],              
        'scale_payment_desc'        => $entry[22],          
        'is_awareness_trained'      => $entry[27],            
        'awareness_training_date'   => $entry[30],               
        'awareness_trainer'         => $entry[29],         
        'required_trainee_office'   => $entry['56.1'],         
        'required_trainee_caseWkr'  => $entry['56.2'],         
        'required_trainee_doctor'   => $entry['56.3'],         
        'required_trainee_admStaff' => $entry['56.4'],         
        'required_trainee_allStaff' => $entry['56.5'],         
        'required_trainee_other'    => $entry['56.6'],         
        'req_trainee_other_desc'    => $entry[63],         
        'has_more_than_m_f'         => $entry[33],         
        'options_other_than_m_f'    => $entry[34],              
        'pronoun_requested'         => $entry[35],         
        'preferred_name_requested'  => $entry[36],                
        'can_prescribe_hormones'    => $entry[23],              
        'assist_letter_hormones'    => $entry['50.1'],         
        'assist_letter_identDocChng'=> $entry['50.2'],         
        'assist_letter_gdrAffSurg'  => $entry['50.3'],         
        'additional_comments'       => $entry[14],           
        'is_review_ready'           => $entry[51],       
        'admin_first_name'          => $entry['39.3'],        
        'admin_last_name'           => $entry['39.6'],       
        'publish_to_web'            => $entry[40],      
        'followup_needed'           => $entry[42],          
        'reason_followup_needed'    => $entry[45],                   
        'is_review_ready_2'         => $entry[68],
        'volunteer_notes'           => $entry[67],
        'post_title'                => $entry[52],  
        'post_body'                 => $entry[53], 
        'post_tags'                 => $entry[54], 
        'post_category'             => $entry[55],
        'last_user_type'            => $entry[61],
        'last_user_level'           => $entry[66]
    );

    // Don't overwrite values with blank strings.
    foreach( $entries as $key => $value ){
        if (empty ($value)){
            unset($entries[$key]);
        }
    }

    $wpdb->update(
        'wp_a3t9xkcyny_providers_table',
        $entries,
        array('lead_id' => $entry['id'])
    );
}

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
        req_trainee_other_desc text,
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
        is_review_ready_2 text,
        volunteer_notes text,
        post_title text,  
        post_body text, 
        post_tags text, 
        post_category text,
        last_user_type text,
        last_user_level text,      

        PRIMARY KEY  (id),
        KEY lead_id (lead_id)
        ) ' . $charset_collate . ';';
    
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
}

/**
 * Gravity Wiz // Gravity Forms // Populate Form with Entry (Optionally Update Entry on Submission)
 *
 * Pass an entry ID and populate the form automatically. No form configuration required. Optionally update the entry on
 * submission.
 *
 * @version  1.4
 * @author   David Smith <david@gravitywiz.com>
 * @license  GPL-2.0+
 * @link     http://gravitywiz.com/
 * @see      https://www.screencast.com/t/SdNyfbNyC5C
 *
 * Plugin Name:  Gravity Forms - Populate Form w/ Entry
 * Plugin URI:   http://gravitywiz.com/
 * Description:  Pass an entry ID and populate the form automatically. No form configuration required. Optionally update the entry on submission.
 * Author:       Gravity Wiz
 * Version:      1.4
 * Author URI:   http://gravitywiz.com
 */
class GW_Populate_Form {

	public function __construct( $args = array() ) {

		$this->_args = wp_parse_args( $args, array(
			'form_id'   => false,
			'query_arg' => 'eid',
			'update'    => false,
		) );

		add_action( 'init', array( $this, 'init' ) );

	}

	public function init() {

		if( ! property_exists( 'GFCommon', 'version' ) || ! version_compare( GFCommon::$version, '1.8', '>=' ) ) {
			return;
		}

		add_filter( 'gform_form_args', array( $this, 'prepare_field_values_for_population' ) );
        add_filter( 'gform_entry_id_pre_save_lead', array( $this, 'set_submission_entry_id' ), 10, 2 );
    }

	public function prepare_field_values_for_population( $args ) {

		if( ! $this->is_applicable_form( $args['form_id'] ) || ! $this->get_entry_id() ) {
			return $args;
		}

		$entry = GFAPI::get_entry( $this->get_entry_id() );
		if( is_wp_error( $entry ) ) {
			return $args;
		}

		$args['field_values'] = $this->prepare_entry_for_population( $entry );

		add_filter( sprintf( 'gform_pre_render_%d', $args['form_id'] ), array( $this, 'prepare_form_for_population' ) );

		return $args;
	}

	public function prepare_form_for_population( $form ) {
		foreach( $form['fields'] as &$field ) {
            
            // var_dump($form);
            // echo "pre form for population. fieldid is: ". $field['id']. " <br>";

			$field['allowsPrepopulate'] = true;

			if( is_array( $field['inputs'] ) ) {
				$inputs = $field['inputs'];
				foreach( $inputs as &$input ) {
					$input['name'] = (string) $input['id'];
				}
				$field['inputs'] = $inputs;
			}

            // CodeGold: Don't set the user_type or the user level fields from database
            if($field['id'] !== 61 && $field['id'] !== 66) {
                $field['inputName'] = $field['id'];
            }
      
            if($field['id'] === 66) {
                // CodeGold: determine user capability and set the hidden user_level field
                if (current_user_can('edit_users')) {
                    // Should correlate to administrator level
                    $field['defaultValue'] = 2;
                } elseif (current_user_can('edit_posts')) {
                    // Should correlate to volunteer level
                    $field['defaultValue'] = 1;
                } else {
                    // Should correlate to commmunity level
                    $field['defaultValue'] = 0;
                }
            }
		}

		return $form;
	}

	public function prepare_entry_for_population( $entry ) {
        // CodeGold: save the serviceType, follow up required
        $serviceType;

		$form = GFFormsModel::get_form_meta( $entry['form_id'] );

		foreach( $form['fields'] as $field ) {

			if( $field->type == 'post_category' ) {
				$value = explode( ':', $entry[ $field->id ] );
                $entry[ $field->id ] = $value[1];
                
                // CodeGold: Get, then set the category to the serviceType
                $categories = get_terms(
                    array (
                        'taxonomy' => 'category',
                        'hide_empty' => false,
                        'name' => $serviceType
                    ));
                $entry[ $field->id ] = $categories[0]->term_id;
			}

			switch( GFFormsModel::get_input_type( $field ) ) {
				case 'checkbox':

					$values = $this->get_field_values_from_entry( $field, $entry );
					if( is_array( $values ) ) {
						$value = implode( ',', array_filter( $values ) );
					} else {
						$value = $values;
					}
					$entry[$field['id']] = $value;

					break;

				case 'list':

					$value = maybe_unserialize( rgar( $entry, $field->id ) );
					$list_values = array();

					if( is_array( $value ) ) {
						foreach( $value as $vals ) {
							if( is_array( $vals ) ) {
								$vals = implode( '|', array_map( function( $value ) {
									$value = str_replace( ',', '&#44;', $value );
									return $value;
								}, $vals ) );
							}
							array_push( $list_values, $vals );
						}
						$entry[ $field->id ] = implode( ',', $list_values );
					}

                    break;
                    
                case 'select':
                    // CodeGold: get the serviceType
                    if ($field->id === 2) {
                        $serviceType = $this->get_field_values_from_entry( $field, $entry );
                    }

                    break;

                case 'textarea':
                    // CodeGold: get the follow up and display on top if it exists
                    $followupReq;
			        if ($field->id === 45) {
                        $followupReq = $this->get_field_values_from_entry( $field, $entry );
                        if ( $followupReq !== '' ){
                            echo "<br><b>Follow up required</b>: $followupReq <br>";
                        } 
                    } 

                    break;
            }
        }

		return $entry;
	}

	public function get_field_values_from_entry( $field, $entry ) {

		$values = array();

		foreach( $entry as $input_id => $value ) {
			$fid = intval( $input_id );
            if( $fid == $field['id'] )
            {
                $values[] = $value;
            }
		}
		return count( $values ) <= 1 ? $values[0] : $values;
	}

	public function set_submission_entry_id( $entry_id, $form ) {

		if( ! $this->is_applicable_form( $form['id'] ) || ! $this->get_entry_id() ) {
			return $entry_id;
		}

		add_filter( 'gform_use_post_value_for_conditional_logic_save_entry', '__return_true' );

		return $this->get_entry_id();
	}

	public function get_entry_id() {
		return rgget( $this->_args['query_arg'] );
	}

	public function is_applicable_form( $form ) {

		$form_id = isset( $form['id'] ) ? $form['id'] : $form;

		return ! $this->_args['form_id'] || $form_id == $this->_args['form_id'];
	}

}

# Configuration

new GW_Populate_Form( array(
    'form_id' => 12,
	'update'  => true
) );

/*

Deleting entries

In the database, run these queries:
truncate wp_a3t9xkcyny_gf_entry_meta;
truncate wp_a3t9xkcyny_gf_entry;
truncate wp_a3t9xkcyny_providers_table;

*/