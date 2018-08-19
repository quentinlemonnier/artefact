<?php
/**
 * Add Photographer Name and URL fields to media uploader
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */
 
function be_attachment_field_credit( $form_fields, $post ) {
	$form_fields['be-photographer-name'] = array(
		'label' => 'Photographer Name',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'be_photographer_name', true ),
		'helps' => 'If provided, photo credit will be displayed',
	);
	
	$form_fields['be-photographer-url'] = array(
		'label' => 'Photographer URL',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'be_photographer_url', true ),
		'helps' => 'If provided, photographer name will link here',
	);
	
	return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'be_attachment_field_credit', 10, 2 );
/**
 * Save values of Photographer Name and URL in media uploader
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */
function be_attachment_field_credit_save( $post, $attachment ) {
	if( isset( $attachment['be-photographer-name'] ) )
		update_post_meta( $post['ID'], 'be_photographer_name', $attachment['be-photographer-name'] );
		
	if( isset( $attachment['be-photographer-url'] ) )
		update_post_meta( $post['ID'], 'be_photographer_url', $attachment['be-photographer-url'] );
	
	return $post;
}
add_filter( 'attachment_fields_to_save', 'be_attachment_field_credit_save', 10, 2 );