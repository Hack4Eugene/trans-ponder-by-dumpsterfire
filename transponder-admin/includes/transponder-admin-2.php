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
*   upon submission of the volunteer (form 3) and admin (form 5) forms.
*/	
add_action('init','transponder_db_scripts');

function transponder_db_scripts() {
    add_action('gform_after_submission_3', 'add_vol_entries_to_db', 10, 2);
    add_action('gform_after_submission_5', 'update_admin_entries_in_db', 10, 2);
}

function add_vol_entries_to_db($entry, $form)
{
    global $wpdb;

    $exists = $wpdb->get_results( 
        $wpdb->prepare(
            "SELECT lead_id FROM wp_a3t9xkcyny_providers_table WHERE lead_id = %d",
            $entry[44] 
        )
    );
    
    if (count($exists) > 0) {
        update_vol_entries_in_db($entry, $form);
        return;
    }

    //var_dump($entry);

    $wpdb->insert(
        'wp_a3t9xkcyny_providers_table',
        array(
        'lead_id'                   => $entry[44],        
        'is_provider_submitted'     => $entry[42],             
        'service_type'              => $entry[2],    
        'other_service_type'        => $entry[45],    
        'medical_type'              => $entry[3],    
        'mental_type'               => $entry[4],   
        'surgical_type'             => $entry[5],     
        'bodywork_type'             => $entry[6],     
        'other_provider_type'       => $entry[46],     
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
        'submitter_feedback'        => $entry[38],          
        'experience_rating'         => $entry[40],         
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
        'required_trainee_office'   => $entry['43.1'],         
        'required_trainee_caseWkr'  => $entry['43.2'],         
        'required_trainee_doctor'   => $entry['43.3'],         
        'required_trainee_admStaff' => $entry['43.4'],         
        'required_trainee_allStaff' => $entry['43.5'],         
        'required_trainee_other'    => $entry['43.6'],         
        'has_more_than_m_f'         => $entry[33],         
        'options_other_than_m_f'    => $entry[34],              
        'pronoun_requested'         => $entry[35],         
        'preferred_name_requested'  => $entry[36],                
        'can_prescribe_hormones'    => $entry[23],              
        'assist_letter_hormones'    => $entry['41.1'],         
        'assist_letter_identDocChng'=> $entry['41.2'],         
        'assist_letter_gdrAffSurg'  => $entry['41.3'],         
        'additional_comments'       => $entry[14],           
        'is_review_ready'           => $entry[37],
        'comm_id'                   => $entry[44]
        )
    );
}

function update_vol_entries_in_db($entry, $form)
{
    global $wpdb;

    $wpdb->update(
        'wp_a3t9xkcyny_providers_table',
        array(
        'is_provider_submitted'     => $entry[42],             
        'service_type'              => $entry[2],    
        'other_service_type'        => $entry[45],    
        'medical_type'              => $entry[3],    
        'mental_type'               => $entry[4],   
        'surgical_type'             => $entry[5],     
        'bodywork_type'             => $entry[6],     
        'other_provider_type'       => $entry[46],     
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
        'submitter_feedback'        => $entry[38],          
        'experience_rating'         => $entry[40],         
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
        'required_trainee_office'   => $entry['43.1'],         
        'required_trainee_caseWkr'  => $entry['43.2'],         
        'required_trainee_doctor'   => $entry['43.3'],         
        'required_trainee_admStaff' => $entry['43.4'],         
        'required_trainee_allStaff' => $entry['43.5'],         
        'required_trainee_other'    => $entry['43.6'],         
        'has_more_than_m_f'         => $entry[33],         
        'options_other_than_m_f'    => $entry[34],              
        'pronoun_requested'         => $entry[35],         
        'preferred_name_requested'  => $entry[36],                
        'can_prescribe_hormones'    => $entry[23],              
        'assist_letter_hormones'    => $entry['41.1'],         
        'assist_letter_identDocChng'=> $entry['41.2'],         
        'assist_letter_gdrAffSurg'  => $entry['41.3'],         
        'additional_comments'       => $entry[14],           
        'is_review_ready'           => $entry[37],
        'comm_id'                   => $entry[44]
        ),
        array('lead_id' => $entry[44])
    );
}

function update_admin_entries_in_db($entry, $form)
{
    global $wpdb;

    //var_dump($entry);

    $wpdb->update(
        'wp_a3t9xkcyny_providers_table',
        array(
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
        'post_title'                => $entry[52],  
        'post_body'                 => $entry[53], 
        'post_tags'                 => $entry[54], 
        'post_category'             => $entry[55],
        'comm_id'                   => $entry[57],
        'vol_id'                    => $entry[58]
        ),
        array('lead_id' => $entry[57])
    );
}