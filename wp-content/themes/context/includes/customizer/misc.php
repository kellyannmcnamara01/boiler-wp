<?php

        function context_misc_customizer_section( $wp_customize ){

        /* Misc Settings
         * For each field you want in the customizer you need to set up an instance
         *
         * $wp_customize->add_setting($id, $args);
         *
         * More Info: https://codex.wordpress.org/Class_Reference%5CWP_Customize_Manager%5Cadd_setting
        ============================================= */
        $wp_customize->add_setting( 'context_header_show_search', [
           'default'            =>  'yes',
           'transport'          =>  'postMessage'
        ] );

        $wp_customize->add_setting( 'content_show_top_btn', [
            'default'           =>  'yes',
            'transport'         =>  'postMessage'
        ] );



        /* Misc Section
         * Create the section which the settings will live
         * The higher the priority the lower in the customize panel list
         * Needs to be called in an add_action( 'customize_register', 'ID' ); to be displayed
         *
         * function mytheme_add_section( $wp_customize ) {
                $wp_customize->add_section($id, $args);
           }
           add_action( 'customize_register', 'mytheme_add_section' );
         *
         * More Info: https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_section
        ============================================= */
        $wp_customize->add_section( 'context_misc_section', [
            'title'             =>  __( 'Miscellaneous Settings', 'context' ),
            'priority'          =>  30,
            'panel'             => 'context-panel'
        ] );



        /* Misc Controls
         * Create the input fields for the settings to allow customization
         * Default 'type' is text
         * 
         * $wp_customize->add_control($id, $args);
         *
         * More Info: https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
        ============================================= */
        $wp_customize->add_control( new WP_Customize_Control(
            $wp_customize,
            'context_header_show_search_input',
            array(
                'label'         =>  __( 'Show search in top bar', 'context' ),
                'section'       =>  'context_misc_section',
                'settings'      =>  'context_header_show_search',
                'type'          =>  'checkbox',
                'choices'       =>  [
                    'yes'       =>  'Yes'
                ]
            )
        ) );

        $wp_customize->add_control( new WP_Customize_Control(
            $wp_customize,
            'content_show_top_btn_input',
            array(
                'label'         =>  __( 'Show back to top button', 'context' ),
                'section'       =>  'context_misc_section',
                'settings'      =>  'content_show_top_btn',
                'type'          =>  'checkbox',
                'choices'       =>  [
                    'yes'       =>  'Yes'
                ]
            )
        ) );
    }

?>