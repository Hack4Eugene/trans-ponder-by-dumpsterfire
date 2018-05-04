<?php
define("ITEM_ID", "13373220");
define("ENVATO_KEY", "5OAZOzhz4IGXSkE7BLmT5UQ7kjALip11");

/**
 * uncode functions and definitions
 *
 * @package uncode
 */

$ok_php = true;
if ( function_exists( 'phpversion' ) ) {
	$php_version = phpversion();
	if (version_compare($php_version,'5.3.0') < 0) $ok_php = false;
}
if (!$ok_php && !is_admin()) {
	$title = esc_html__( 'PHP version obsolete','uncode' );
	$html = '<h2>' . esc_html__( 'Ooops, obsolete PHP version' ,'uncode' ) . '</h2>';
	$html .= '<p>' . sprintf( wp_kses( 'We have coded the Uncode theme to run with modern technology and we have decided not to support the PHP version 5.2.x just because we want to challenge our customer to adopt what\'s best for their interests.%sBy running obsolete version of PHP like 5.2 your server will be vulnerable to attacks since it\'s not longer supported and the last update was done the 06 January 2011.%sSo please ask your host to update to a newer PHP version for FREE.%sYou can also check for reference this post of WordPress.org <a href="https://wordpress.org/about/requirements/">https://wordpress.org/about/requirements/</a>' ,'uncode', array('a' => 'href') ), '</p><p>', '</p><p>', '</p><p>') . '</p>';

	wp_die( $html, $title, array('response' => 403) );
}


/**
 * Load the main functions.
 */
require_once get_template_directory() . '/core/inc/main.php';

/**
 * Load envato-toolkit
 */
//require_once get_template_directory() . '/core/inc/envato-toolkit/init.php';

/**
 * Load the admin functions.
 */
require_once get_template_directory() . '/core/inc/admin.php';

/**
 * Load the uncode export file.
 */
require_once get_template_directory() . '/core/inc/export/uncode_export.php';

/**
 * Font system.
 */
require_once get_template_directory() . '/core/font-system/font-system.php';

/**
* Update helpers.
*/
require_once get_template_directory() . '/core/inc/update-helpers.php';

/**
* Ajax system.
*/
require_once get_template_directory() . '/core/inc/admin-pages/ajax.php';

/**
* Notification system.
*/
require_once get_template_directory() . '/core/inc/admin-pages/notifications.php';

/**
* Communication system.
*/
require_once get_template_directory() . '/core/inc/admin-pages/communication.php';

/**
* Patch system.
*/
require_once get_template_directory() . '/core/inc/admin-pages/patches.php';

/**
 * Load the color system.
 */
require_once get_template_directory() . '/core/inc/colors.php';

/**
 * Required: set 'ot_theme_mode' filter to true.
 */
require_once get_template_directory() . '/core/theme-options/assets/theme-mode/functions.php';

/**
 * Required: include OptionTree.
 */
load_template( get_template_directory() . '/core/theme-options/ot-loader.php' );

/**
 * Load the theme options.
 */
require_once get_template_directory() . '/core/theme-options/assets/theme-mode/theme-options.php';

/**
 * Load the main functions.
 */
require_once get_template_directory() . '/core/inc/performance.php';

/**

 * Load the theme meta boxes.
 */
require_once get_template_directory() . '/core/theme-options/assets/theme-mode/meta-boxes.php';

/**
 * Load TGM plugins activation.
 */
require_once get_template_directory() . '/core/plugins_activation/init.php';

/**
 * Load the media enhanced function.
 */
require_once( ABSPATH . WPINC . '/class-oembed.php' );
require_once get_template_directory() . '/core/inc/media-enhanced.php';

/**
 * Load the bootstrap navwalker.
 */
require_once get_template_directory() . '/core/inc/wp-bootstrap-navwalker.php';

/**
 * Load the bootstrap navwalker.
 */
require_once get_template_directory() . '/core/inc/uncode-comment-walker.php';

/**
 * Load menu builder.
 */
if ($ok_php) require_once get_template_directory() . '/partials/menus.php';

/**
 * Load header builder.
 */
if ($ok_php) require_once get_template_directory() . '/partials/headers.php';

/**
 * Load elements partial.
 */
if ($ok_php) require_once get_template_directory() . '/partials/elements.php';

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/core/inc/template-tags.php';

/**
 * Helpers functions.
 */
require_once get_template_directory() . '/core/inc/helpers.php';

/**
 * Customizer additions.
 */
require_once get_template_directory() . '/core/inc/customizer.php';

/**
 * Customizer WooCommerce additions.
 */
if (class_exists( 'WooCommerce' )) {
	require_once get_template_directory() . '/core/inc/customizer-woocommerce.php';
}

/**
 * Load one click demo
 */
require_once get_template_directory() . '/core/one-click-demo/init.php';

/**
 * Load Jetpack compatibility file.
 */
require_once get_template_directory() . '/core/inc/jetpack.php';

/**
 * Load gallery functions
 */
require_once get_template_directory() . '/core/inc/galleries.php';

add_action( 'after_setup_theme', 'uncode_related_post_call' );

//add_action('gform_after_submission_1', 'add_comm_entries_to_db', 10, 2);
add_action('gform_after_submission_3', 'add_vol_entries_to_db', 10, 2);
add_action('gform_after_submission_5', 'update_admin_entries_in_db', 10, 2);

if ( ! function_exists( 'uncode_related_post_call' ) ) :
/**
 * @since Uncode 1.5.0
 * Additional post type for related posts plugin
 */
function uncode_related_post_call() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'related-posts-for-wp/related-posts-for-wp.php' ) ) {
		require_once get_template_directory() . '/core/inc/related-posts.php';
	}
}
endif;
/*
This section is unecessary to enable the Pending Page update.
But it will be saved just in case there is value in uploading
community submitted resources to the custom database.
function add_comm_entries_to_db($entry, $form)
{
    global $wpdb;

    //var_dump($entry);

    $wpdb->insert(
        'wp_a3t9xkcyny_providers_table',
        array(
        'lead_id'                   => $entry['id'],        
        'is_provider_submitted'     => $entry[1],             
        'service_type'              => $entry[2],    
        'medical_type'              => $entry[3],    
        'mental_type'               => $entry[4],   
        'surgical_type'             => $entry[5],     
        'bodywork_type'             => $entry[6],     
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
        'submitter_feedback'        => $entry[13],          
        'experience_rating'         => $entry[16],         
        'accepts_ohp'               => $entry[17],   
        'accepts_private_insurance' => $entry[18],                 
        'accepted_insurance'        => $entry[19],          
        'accepts_medicare'          => $entry[20],        
        'accepts_scale_payments'    => $entry[21],              
        'scale_payment_desc'        => $entry[22],          
        'can_prescribe_hormones'    => $entry[23],              
        'assist_letter_hormones'    => $entry['24.1'],         
        'assist_letter_identDocChng'=> $entry['24.2'],         
        'assist_letter_gdrAffSurg'  => $entry['24.3'],         
        'additional_comments'       => $entry[14]
        )
    );
}
*/

function add_vol_entries_to_db($entry, $form)
{
    global $wpdb;

    //var_dump($entry);

    $wpdb->insert(
        'wp_a3t9xkcyny_providers_table',
        array(
        'lead_id'                   => $entry['id'],        
        'is_provider_submitted'     => $entry[42],             
        'service_type'              => $entry[2],    
        'medical_type'              => $entry[3],    
        'mental_type'               => $entry[4],   
        'surgical_type'             => $entry[5],     
        'bodywork_type'             => $entry[6],     
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

function update_admin_entries_in_db($entry, $form)
{
    global $wpdb;

    //var_dump($entry);

    $wpdb->update(
        'wp_a3t9xkcyny_providers_table',
        array(
        'is_provider_submitted'     => $entry[47],
        'service_type'              => $entry[2],    
        'medical_type'              => $entry[3],    
        'mental_type'               => $entry[4],   
        'surgical_type'             => $entry[5],     
        'bodywork_type'             => $entry[6],     
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
        'is_followup_needed'        => $entry[42],          
        'followup_needed'           => $entry[45],       
        'archive_listing'           => $entry[46],       
        'admin_listing_comments'    => $entry[44],              
        'post_title'                => $entry[52],  
        'post_body'                 => $entry[53], 
        'post_tags'                 => $entry[54], 
        'post_category'             => $entry[55],
        'comm_id'                   => $entry[57],
        'vol_id'                    => $entry[58]
        ),
        array('lead_id' => $entry[58])
    );
}