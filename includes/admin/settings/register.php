<?php
/**
 * Settings
 *
 * @package     EDD\DynamicIcon\Admin\Settings
 * @since       1.1.0
 */


// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Add settings section
 *
 * @since       1.1.0
 * @param       array $sections The existing extensions sections
 * @return      array The modified extensions settings
 */
function edd_dynamic_icon_add_settings_section( $sections ) {
	$sections['dynamic-icon'] = __( 'Dynamic Icon', 'edd-dynamic-icon' );

	return $sections;
}
add_filter( 'edd_settings_sections_extensions', 'edd_dynamic_icon_add_settings_section' );


/**
 * Add settings
 *
 * @since       1.0.0
 * @param       array $settings The existing plugin settings
 * @return      array The modified plugin settings
 */
function edd_dynamic_icon_add_settings( $settings ) {
	$new_settings = array(
		'dynamic-icon' => apply_filters( 'edd_dynamic_icon_settings', array(
			array(
				'id'   => 'edd_dynamic_icon',
				'name' => '<strong>' . __( 'Dynamic Icon', 'edd-dynamic-icon' ) . '</strong>',
				'desc' => '',
				'type' => 'header'
			),
			array(
				'id'   => 'edd_dynamic_icon_favicon',
				'name' => __( 'Favicon', 'edd-dynamic-icon' ),
				'desc' => __( 'If your theme doesn\'t natively support favicons, upload one here!', 'edd-dynamic-icon' ),
				'type' => 'upload'
			),
			array(
				'id'   => 'edd_dynamic_icon_color',
				'name' => __( 'Text Color', 'edd-dynamic-icon' ),
				'desc' => __( 'Specify the color for the icon text', 'edd-dynamic-icon' ),
				'type' => 'color',
				'std'  => '#ffffff'
			),
			array(
				'id'   => 'edd_dynamic_icon_background',
				'name' => __( 'Background Color', 'edd-dynamic-icon' ),
				'desc' => __( 'Specify the background color for the icon', 'edd-dynamic-icon' ),
				'type' => 'color',
				'std'  => '#ff0000'
			),
			array(
				'id'      => 'edd_dynamic_icon_style',
				'name'    => __( 'Font Style', 'edd-dynamic-icon' ),
				'desc'    => __( 'Set the style for the badge text', 'edd-dynamic-icon' ),
				'type'    => 'select',
				'std'     => 'bold',
				'options' => array(
					'normal' => __( 'Normal', 'edd-dynamic-icon' ),
					'italic' => __( 'Italic', 'edd-dynamic-icon' ),
					'bold'   => __( 'Bold', 'edd-dynamic-icon' )
				)
			),
			array(
				'id'      => 'edd_dynamic_icon_shape',
				'name'    => __( 'Badge Shape', 'edd-dynamic-icon' ),
				'desc'    => __( 'Specify the shape of the badge', 'edd-dynamic-icon' ),
				'type'    => 'select',
				'std'     => 'circle',
				'options' => array(
					'circle'    => __( 'Circle', 'edd-dynamic-icon' ),
					'rectangle' => __( 'Rectangle', 'edd-dynamic-icon' )
				)
			),
			array(
				'id'      => 'edd_dynamic_icon_animation',
				'name'    => __( 'Badge Animation', 'edd-dynamic-icon' ),
				'desc'    => __( 'Specify the animation for badge updates', 'edd-dynamic-icon' ),
				'type'    => 'select',
				'std'     => 'none',
				'options' => array(
					'none'    => __( 'None', 'edd-dynamic-icon' ),
					'slide'   => __( 'Slide', 'edd-dynamic-icon' ),
					'fade'    => __( 'Fade', 'edd-dynamic-icon' ),
					'pop'     => __( 'Pop', 'edd-dynamic-icon' ),
					'popFade' => __( 'Pop/Fade', 'edd-dynamic-icon' )
				)
			)
		) )
	);

	return array_merge( $settings, $new_settings );
}
add_filter( 'edd_settings_extensions', 'edd_dynamic_icon_add_settings' );
