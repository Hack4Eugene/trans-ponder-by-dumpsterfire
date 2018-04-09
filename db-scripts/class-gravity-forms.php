<?php

	if ( $checked ) 
        {
            $fields = self::get_all_form_fields( $form_id );

            $code_providerName = (string)self::find_field($fields, 'Provider Name');
            $providerName = filter_var($entry[$code_providerName],FILTER_SANITIZE_STRING);

            $code_officeName = (string)self::find_field($fields, 'Office / Clinic Name (if applicable)');
            if($code_officeName) {$officeName = filter_var($entry[$code_officeName],FILTER_SANITIZE_STRING);}

            $code_streetAddress = (string)self::find_field($fields, 'Address (Street Address)');
            if($code_streetAddress) {$streetAddress = filter_var($entry[$code_streetAddress],FILTER_SANITIZE_STRING);}

            $code_addressLine = (string)self::find_field($fields, 'Address (Address Line 2)');
            if($code_addressLine) {$addressLine = filter_var($entry[$code_addressLine],FILTER_SANITIZE_STRING);}

            $code_city = (string)self::find_field($fields, 'Address (City)');
            if($code_city) {$city = filter_var($entry[$code_city],FILTER_SANITIZE_STRING);}

            $code_state = (string)self::find_field($fields, 'Address (State)');
            if($code_state) {$state = filter_var($entry[$code_state],FILTER_SANITIZE_STRING);}

            $code_zip = (string)self::find_field($fields, 'Address (ZIP Code)');
            if($code_zip) {$zip = filter_var($entry[$code_zip],FILTER_SANITIZE_STRING);}

            $code_country = (string)self::find_field($fields, 'Address (Country)');
            if($code_country) {$country = filter_var($entry[$code_country],FILTER_SANITIZE_STRING);}

            $code_phone = (string)self::find_field($fields, 'Phone');
            if($code_phone) {$phone = filter_var($entry[$code_phone],FILTER_SANITIZE_STRING);}

            $code_email = (string)self::find_field($fields, 'Email');
            if($code_email) {$email = filter_var($entry[$code_email],FILTER_SANITIZE_STRING);}

            $code_url = (string)self::find_field($fields, 'Website');
            if($code_url) {$url = filter_var($entry[$code_url],FILTER_SANITIZE_URL);}

            $code_feedback = (string)self::find_field($fields, 'Your Feedback');
            if($code_feedback) {$feedback = filter_var($entry[$code_feedback],FILTER_SANITIZE_STRING);}

            $code_acceptedInsurance = (string)self::find_field($fields, 'What providers do they take (optional)?');
            if($code_acceptedInsurance) {$acceptedInsurance = filter_var($entry[$code_acceptedInsurance],FILTER_SANITIZE_STRING);}

            $code_scaleDesc = (string)self::find_field($fields, 'Describe the sliding scale program (optional)');
            if($code_scaleDesc) {$scaleDesc = filter_var($entry[$code_scaleDesc],FILTER_SANITIZE_STRING);}

            $code_trainer = (string)self::find_field($fields, 'Who delivered the training?');
            if($code_trainer) {$trainer = filter_var($entry[$code_trainer],FILTER_SANITIZE_STRING);}

            $code_optionsMf = (string)self::find_field($fields, 'Tell us what options are available beyond M or F.');
            if($code_optionsMf) {$optionsMf = filter_var($entry[$code_optionsMf],FILTER_SANITIZE_STRING);}

            $code_additionalComments = (string)self::find_field($fields, 'Additional Comments');
            if($code_additionalComments) {$additionalComments = filter_var($entry[$code_additionalComments],FILTER_SANITIZE_STRING);}

            $code_firstName = (string)self::find_field($fields, 'Name of Admin who reviewed this listing (First)');
            if($code_firstName) {$firstName = filter_var($entry[$code_firstName],FILTER_SANITIZE_STRING);}

            $code_lastName = (string)self::find_field($fields, 'Name of Admin who reviewed this listing (Last)');
            if($code_lastName) {$lastName = filter_var($entry[$code_lastName],FILTER_SANITIZE_STRING);}

            $code_neededFollowup = (string)self::find_field($fields, 'What is needed for further follow up?');
            if($code_neededFollowup) {$neededFollowup = filter_var($entry[$code_neededFollowup],FILTER_SANITIZE_STRING);}

            $code_adminListingComments = (string)self::find_field($fields, 'What needs to be done with this listing?');
            if($code_adminListingComments) {$adminListingComments = filter_var($entry[$code_adminListingComments],FILTER_SANITIZE_STRING);}

            $code_postTitle = (string)self::find_field($fields, 'Post Title');
            if($code_postTitle) {$postTitle = filter_var($entry[$code_postTitle],FILTER_SANITIZE_STRING);}

            $code_postTags = (string)self::find_field($fields, 'Post Tags');
            if($code_postTags) {$postTags = filter_var($entry[$code_postTags],FILTER_SANITIZE_STRING);}

            $code_postBody = (string)self::find_field($fields, 'Post Body');
            if($code_postBody) {$postBody = filter_var($entry[$code_postBody],FILTER_SANITIZE_STRING);}
        }
        
        