<?php

/**
 * ====================================
 * Shortcode for Hosted By
 * ====================================
 */

if (! function_exists('hostedBy')) {
    function hostedBy()
    {
        $hostedBy = (function_exists("get_field") && $value = get_field('standalone_page')) ? $value : '';


        if ($hostedBy) {
            // hosted by === Internal
            $hostName = (function_exists("get_field") && $value = get_field('host_name')) ? $value : 'Kinetica';
        } else {
            // hosted by === External
            $hostName = (function_exists("get_field") && $value = get_field('host_name')) ? $value : '';
        }

        ob_start();

        if ($hostName) {
            echo 'Hosted By' . ' ' . $hostName;
        }


        return ob_get_clean();
    }
    add_shortcode('hostedBy', 'hostedBy');
}

/**
 * ====================================
 * Shortcode for events hubspot form
 * ====================================
 */

if (! function_exists('eventHubspotForm')) {
    function eventHubspotForm()
    {
        $formID = get_field('hsform_id');
        ob_start();

        if (! empty($formID)) { ?>
            <div id="form_title"></div>
            <!-- [if lte IE 8]><script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script><![endif]-->
            <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
            <script>
                hbspt.forms.create({
                    region: "na1",
                    portalId: '2461428',
                    formId: '<?= get_field('hsform_id') ?>',
                    onFormSubmitted: function() {
                        jQuery("#form_title").html('Thank you!');
                    },
                    onFormReady: function($form) {
                        console.log($form);
                        let style = '<style>';

                        // Form title
                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .form-title { 
                                margin-block: 0 3rem; 
                            }
                            `;

                        // Two column row
                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .form-columns-2:not(:first-of-type) { 
                                margin-top: 1.5rem; 
                            }
                            `;

                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .form-columns-2 { 
                                display: grid; 
                                grid-template-columns: 1fr 1fr; 
                                gap: 1.5rem; 
                            }
                            `;

                        // Make the label + input field take up the full width
                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .form-columns-2 .hs-form-field { 
                                width: 100%; 
                            }
                            `;

                        // Make the fieldset take up the full width
                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> fieldset { 
                                width: 100%; 
                                max-width: none; 
                            }
                            `;

                        // Spacing of one column rows
                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .form-columns-1 { 
                                margin-top: 1.5rem;
                            }
                            `;

                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .form-columns-1:last-of-type { 
                                margin-top: 2rem;
                            }
                            `;

                        // input field(s)
                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> input:not([type=image]):not([type=submit]):not([type=button]):not([type=radio]):not([type=checkbox]):not([type=file]) {
                                padding: 1.25rem; 
                                margin-top: 0.75rem; 
                                background: var(--e-global-color-d77e5e1); 
                                border: 1px solid #FFFFFF26; 
                                height:auto;
                                color: #fff; 
                                width: 100%;
                            } 
                            form#hsForm_<?= get_field('hsform_id') ?> textarea { 
                                background-color: var(--e-global-color-d77e5e1) !important; 
                                min-height: 100px;
                                border: 1px solid #FFFFFF26; 
                                width: 100%; 
                                margin-top: 0.75rem;
                            }
                            form#hsForm_<?= get_field('hsform_id') ?> input:not([type=image]):not([type=submit]):not([type=button]):not([type=radio]):not([type=checkbox]):not([type=file]):placeholder {
                                color: #8C8F92;
                            } 
                            form#hsForm_<?= get_field('hsform_id') ?> textarea:placeholder { 
                                color: #8C8F92;
                            }
                            `;

                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .input { 
                                margin-right: 0;
                            }
                        `;

                        // label
                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .hs-form-field label:not(.hs-error-msg) {
                                color: #fff; 
                                font-family: var( --e-global-typography-primary-font-family ), Sans-serif; 
                                font-weight: 600; 
                                margin-bottom: 3rem;
                                }
                            `;

                        // hs-error-msg
                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .hs-form-field label.hs-error-msg {
                                font-size: 0.875rem; 
                                font-family: var( --e-global-typography-primary-font-family ), Sans-serif, monospace; 
                                color: red; 
                                margin-top: 5px;
                                }
                            `;

                        // submit button
                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .hs-button { 
                                width: 100%; 
                                background: var(--e-global-color-primary); 
                                color: white; 
                                padding: 0.844rem; 
                                font-size: 1.125rem; 
                                font-weight: 500; 
                                height: auto;
                                line-height: 1.6;
                                border: 0; 
                                transition: background 0.4s ease-out;
                            } 
                            form#hsForm_<?= get_field('hsform_id') ?> .hs-button:hover {
                                background: var(--e-global-color-0af7ad1);
                            }
                        `;

                        // link
                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> a:link { 
                                color: #C08CE8; 
                                transition: all 0.5s ease; 
                            } 
                            form#hsForm_<?= get_field('hsform_id') ?> a:link:hover { 
                                opacity: 0.5;
                            }
                            `;

                        // Remove bullets from all lists
                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> ul { 
                                padding: 0; 
                                list-style-type: none;
                            }
                            `;

                        // checkbox
                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .hs-form-booleancheckbox label { 
                                display: flex; 
                                align-items: center; 
                                gap: 0.5rem; 
                            }
                            `;

                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .hs-form-booleancheckbox input { 
                                margin: 0;
                            }
                            `;

                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .hs-form-booleancheckbox label span { 
                                color: #dfdfdf; 
                                font-weight: 400;
                            }
                            `;

                        // Dropdown
                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .form-columns-1 select { 
                                background-color: var(--e-global-color-d77e5e1) !important; 
                                color: #dfdfdf; 
                                padding: 1.25rem; 
                                width: 100%; 
                                border: none; 
                                border-right: 20px solid transparent; 
                                border-radius: 4px;
                            }
                            `;

                        style +=
                            `form#hsForm_<?= get_field('hsform_id') ?> .form-columns-1 .input:has(select) { 
                                margin-top: 0.75rem;  
                                border: 1px solid #FFFFFF3a; 
                                border-radius: 4px; 
                            }
                            `;

                        style +=
                            `@media screen and (max-width: 640px) {
                                form#hsForm_ff139243-f34e-4c5d-abcf-18bba60f89c8 .form-columns-2 {
                                grid-template-columns: 1fr;
                                }
                            }
                            `;

                        style += '</style>';

                        // Add a heading
                        $form.prepend(
                            '<h3 class="form-title">' + 'Contact Us' + '</h3>'
                        )

                        $form.prepend(style);
                    }
                });
            </script>
        <?php } else { ?>
            <div class="jz_note">No Hubspot Form ID Entered... Can't Create Form. &#x1F615;</div>
<?php }

        return ob_get_clean();
    }
    add_shortcode('eventHubspotForm', 'eventHubspotForm');
}

/**
 * ====================================
 * Shortcode for events speaker
 * ====================================
 */

if (! function_exists('eventSpeaker')) {
    function eventSpeaker()
    {
        $speakers = (function_exists("get_field") && $value = get_field('speakers')) ? $value : '';

        ob_start();

        if ($speakers) {

            wp_enqueue_style('single-event');

            echo '<ul class="event-speakers">';

            foreach ($speakers as $id) {

                // profile picture
                $imageID = (function_exists("get_field") && $value = get_field('photo', $id)) ? $value : '';

                // name
                $name = get_the_title($id);

                //designation
                $designation = (function_exists("get_field") && $value = get_field('designation', $id)) ? $value : '';

                echo '<li class="item">';

                if ($imageID) {
                    echo "<div class=\"photo\">wp_get_attachment_image($imageID, 'medium')</div>";
                }

                echo '<div class="detail">';

                echo "<div class=\"name\">$name</div>";

                if ($designation) {
                    echo "<div class=\"designation\">$designation</div>";
                }

                echo '</div>';

                echo '</li>';
            }

            echo '</ul>';
        }

        return ob_get_clean();
    }
    add_shortcode('eventSpeaker', 'eventSpeaker');
}

/**
 * ====================================
 * Check if event is past the date
 * ====================================
 */

if (! function_exists('is_event_active')) {
    function is_event_active()
    {
        $eventLastDate = (function_exists("get_field") && $value = get_field('event_end_date')) ? $value : '';

        // Current date in 'j F, Y' format
        $currentDate = date('j F, Y');

        // Create DateTime objects
        $eventDateTime = DateTime::createFromFormat('j F, Y', $eventLastDate);
        $currentDateTime = DateTime::createFromFormat('j F, Y', $currentDate);

        // Compare the dates
        if ($eventDateTime < $currentDateTime) {
            // Event has expired
            return false;
        } else {
            // Event is still active
            return true;
        }
    }

    add_shortcode('isEventActive', 'is_event_active');
}


/**
 * ====================================
 * Check if condition matches to
 * display registration form
 * ====================================
 */
if (! function_exists('show_registration_form')) {
    function show_registration_form()
    {
        $hostedBy = (function_exists("get_field") && $value = get_field('standalone_page')) ? $value : '';

        if (is_event_active() && $hostedBy) {
            // display internal registration form
            return 'yes';
        } else {
            // hide form
            return 'no';
        }
    }

    add_shortcode('showRegistrationForm', 'show_registration_form');
}

/**
 * ====================================
 * Check if condition matches to
 * display registration button
 * ====================================
 */

if (! function_exists('show_registration_button')) {
    function show_registration_button()
    {
        $hostedBy = (function_exists("get_field") && $value = get_field('standalone_page')) ? $value : '';

        if (is_event_active() && ! $hostedBy) {
            // display external registration button
            return 'yes';
        } else {
            // hide button
            return 'no';
        }
    }

    add_shortcode('showRegistrationButton', 'show_registration_button');
}

/**
 * ====================================
 * Check if condition matches to
 * display Contact us for video section
 * ====================================
 */

if (! function_exists('past_recording_contact_internal')) {
    function past_recording_contact_internal()
    {
        $hostedBy = (function_exists("get_field") && $value = get_field('standalone_page')) ? $value : '';
        $recordingAvailableOn = (function_exists("get_field") && $value = get_field('recording_available_on')) ? $value : 0;
        $external_recording_url = (function_exists("get_field") && $value = get_field('external_recording_url')) ? $value : 0;

        if ((! is_event_active() && $hostedBy && ! $recordingAvailableOn) || (! is_event_active() && ! $hostedBy && ! $external_recording_url)) {
            // display past_recording_contact_internal section
            return 'yes';
        } else {
            // hide
            return 'no';
        }
    }

    add_shortcode('pastRecordingContactInternal', 'past_recording_contact_internal');
}

/**
 * ====================================
 * Check if condition matches to
 * display watch video section
 * ====================================
 */

if (! function_exists('past_recording_watchvideo_internal')) {
    function past_recording_watchvideo_internal()
    {
        $hostedBy = (function_exists("get_field") && $value = get_field('standalone_page')) ? $value : '';
        $recordingAvailableOn = (function_exists("get_field") && $value = get_field('recording_available_on')) ? $value : 0;

        if (! is_event_active() && $hostedBy && $recordingAvailableOn) {
            // display past_recording_contact_internal section
            return 'yes';
        } else {
            // hide
            return 'no';
        }
    }

    add_shortcode('pastRecordingWatchvideoInternal', 'past_recording_watchvideo_internal');
}

/**
 * ====================================
 *  embed video
 * ====================================
 */

if (! function_exists('embed_recording')) {
    function embed_recording()
    {
        $recordingAvailableOn = (function_exists("get_field") && $value = get_field('recording_available_on')) ? $value : 0;

        $youtube_id = (function_exists("get_field") && $value = get_field('youtube_id')) ? $value : '';

        $wistia_id = (function_exists("get_field") && $value = get_field('wistia_id')) ? $value : '';

        $embed_code = (function_exists("get_field") && $value = get_field('embed_code')) ? $value : '';

        if ($recordingAvailableOn == 'youtube' && ! empty($youtube_id)) {

            echo wp_oembed_get('http://www.youtube.com/watch?v=' . $youtube_id);
        } elseif ($recordingAvailableOn == 'wistia' && ! empty($wistia_id)) {

            echo "<script>if(preGPU.getURLParameter(\"turnstile-time\")>0){var turnstile_time=preGPU.getURLParameter(\"turnstile-time\");window._wq=window._wq||[],_wq.push({id:\"cw7hpa345c\",options:{plugin:{\"requireEmail-v1\":{time:turnstile_time}}}})}</script>";

            echo "<script src='https://fast.wistia.com/embed/medias/" . $wistia_id . ".jsonp' async></script><script src='https://fast.wistia.com/assets/external/E-v1.js' async></script><div class='wistia_responsive_padding' style='padding:56.25% 0 0 0;position:relative;'><div class='wistia_responsive_wrapper' style='height:100%;left:0;position:absolute;top:0;width:100%;'><div class='wistia_embed wistia_async_" . $wistia_id . " videoFoam=true' style='height:100%;width:100%'>&nbsp;</div></div></div>";
        } elseif ($recordingAvailableOn == 'other' && ! empty($embed_code)) {
            echo $embed_code;
        }
    }

    add_shortcode('embedRecording', 'embed_recording');
}

/**
 * ====================================
 *  embed video Resources
 * ====================================
 */

if (! function_exists('embed_recording_resources')) {
    function embed_recording_resources()
    {
        $recordingAvailableOn = (function_exists("get_field") && $value = get_field('recording_available_on')) ? $value : 0;

        $youtube_link = (function_exists("get_field") && $value = get_field('youtube_link')) ? $value : '';

        $wistia_id = (function_exists("get_field") && $value = get_field('wistia_id')) ? $value : '';

        $embed_code = (function_exists("get_field") && $value = get_field('embed_code')) ? $value : '';

        if ($recordingAvailableOn == 'youtube' && ! empty($youtube_link)) {

            echo wp_oembed_get($youtube_link);
        } elseif ($recordingAvailableOn == 'wistia' && ! empty($wistia_id)) {

            echo "<script>if(preGPU.getURLParameter(\"turnstile-time\")>0){var turnstile_time=preGPU.getURLParameter(\"turnstile-time\");window._wq=window._wq||[],_wq.push({id:\"cw7hpa345c\",options:{plugin:{\"requireEmail-v1\":{time:turnstile_time}}}})}</script>";

            echo "<script src='https://fast.wistia.com/embed/medias/" . $wistia_id . ".jsonp' async></script><script src='https://fast.wistia.com/assets/external/E-v1.js' async></script><div class='wistia_responsive_padding' style='padding:56.25% 0 0 0;position:relative;'><div class='wistia_responsive_wrapper' style='height:100%;left:0;position:absolute;top:0;width:100%;'><div class='wistia_embed wistia_async_" . $wistia_id . " videoFoam=true' style='height:100%;width:100%'>&nbsp;</div></div></div>";
        } elseif ($recordingAvailableOn == 'other' && ! empty($embed_code)) {
            echo $embed_code;
        }
    }

    add_shortcode('embedRecordingResources', 'embed_recording_resources');
}

/**
 * ====================================
 * Check if condition matches to
 * display watch video section external
 * ====================================
 */

if (! function_exists('past_recording_watchvideo_external')) {
    function past_recording_watchvideo_external()
    {
        $hostedBy = (function_exists("get_field") && $value = get_field('standalone_page')) ? $value : '';
        $external_recording_url = (function_exists("get_field") && $value = get_field('external_recording_url')) ? $value : 0;

        if (! is_event_active() && ! $hostedBy && $external_recording_url) {
            // display past_recording_contact_external section
            return 'yes';
        } else {
            // hide
            return 'no';
        }
    }

    add_shortcode('pastRecordingWatchvideoExternal', 'past_recording_watchvideo_external');
}


/**
 * ====================================
 * Event Button text based on condition
 * ====================================
 */
if (! function_exists('event_button_text')) {
    function event_button_text()
    {

        $event_type = (function_exists("get_field") && $value = get_field('event_type')) ? $value : '';
        $upcoming_button_text = (function_exists("get_field") && $value = get_field('upcoming_button_text')) ? $value : '';
        $past_button_text = (function_exists("get_field") && $value = get_field('past_button_text')) ? $value : '';

        if (is_event_active() && $event_type === 97) {
            return $upcoming_button_text ? $upcoming_button_text : 'Register';
        }

        if (! is_event_active() && $event_type === 97) {
            return $past_button_text ? $past_button_text : 'Watch Now';
        }

        return $past_button_text ? $past_button_text : 'Learn More';
    }

    add_shortcode('eventButtonText', 'event_button_text');
}
