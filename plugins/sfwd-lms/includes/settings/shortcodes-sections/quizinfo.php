<?php
if ( ( class_exists( 'LearnDash_Shortcodes_Section' ) ) && ( !class_exists( 'LearnDash_Shortcodes_Section_quizinfo' ) ) ) {
	class LearnDash_Shortcodes_Section_quizinfo extends LearnDash_Shortcodes_Section {

		function __construct( $fields_args = array() ) {
			$this->fields_args = $fields_args;

			$this->shortcodes_section_key 			= 	'quizinfo';
			$this->shortcodes_section_title 		= 	sprintf( _x( '%s Info', 'placeholder: Quiz', 'learndash' ), LearnDash_Custom_Label::get_label( 'quiz' ) );
			$this->shortcodes_section_type			=	1;
			$this->shortcodes_section_description	=	sprintf( _x( 'This shortcode displays information regarding %s attempts on the certificate. This shortcode can use the following parameters:', 'placeholders: quiz', 'learndash' ), LearnDash_Custom_Label::label_to_lower( 'quiz' ) );
			
			parent::__construct(); 
		}
		
		function init_shortcodes_section_fields() {
			$this->shortcodes_option_fields = array(
				'show' => array(
					'id'			=>	$this->shortcodes_section_key . '_show',
					'name'  		=> 	'show', 
					'type'  		=> 	'select',
					'label' 		=> 	__( 'Show', 'learndash' ),
					'help_text'		=>	sprintf( _x( 'This parameter determines the information to be shown by the shortcode.<br />cumulative - average for all %s of the %s.<br />aggregate - sum for all %s of the %s.', 'placeholders: quizzes, course, quizzes, course', 'learndash' ),
											LearnDash_Custom_Label::label_to_lower( 'quizzes' ), LearnDash_Custom_Label::label_to_lower( 'course' ),
											LearnDash_Custom_Label::label_to_lower( 'quizzes' ), LearnDash_Custom_Label::label_to_lower( 'course' ) ),
					'value' 		=> 	'ID',
					'options'		=>	array(
											'score'			=>	__( 'Score', 'learndash' ),
											'count'			=>	__( 'Count', 'learndash' ),
											'pass'			=>	__( 'Pass', 'learndash' ),
											'timestamp'		=>	__( 'Timestamp', 'learndash' ),
											'points'		=>	__( 'Points', 'learndash' ),
											'total_points'	=>	__( 'Total Points', 'learndash' ),
											'percentage'	=>	__( 'Percentage', 'learndash' ),
											'quiz_title'	=>	sprintf(_x( '%s Title', 'placeholder: Quiz', 'learndash' ), LearnDash_Custom_Label::get_label( 'quiz' ) ),
											'course_title'	=>	sprintf(_x( '%s Title', 'placeholder: Quiz', 'learndash' ), LearnDash_Custom_Label::get_label( 'course' ) ),
											'timespent'		=>	__( 'Time Spent', 'learndash' ),
										)
				),
				'format' => array(
					'id'			=>	$this->shortcodes_section_key . '_format',
					'name'  		=> 	'format', 
					'type'  		=> 	'text',
					'label' 		=> 	__( 'Format', 'learndash'),
					'help_text'		=>	__( 'This can be used to change the date format. Default: "F j, Y, g:i a" shows as <i>March 10, 2001, 5:16 pm</i>. See <a target="_blank" href="http://php.net/manual/en/function.date.php">the full list of available date formating strings  here.</a>', 'learndash' ),
					'value' 		=> 	'',
				),
			);
		
			if ( ( !isset( $this->fields_args['post_type'] ) ) || ( $this->fields_args['post_type'] != 'sfwd-certificates' ) ) {

				$this->shortcodes_option_fields['quiz'] = array(
					'id'			=>	$this->shortcodes_section_key . '_quiz',
					'name'  		=> 	'quiz', 
					'type'  		=> 	'number',
					'label' 		=> 	sprintf( _x( '%s ID', 'placeholder: Quiz', 'learndash' ), LearnDash_Custom_Label::get_label( 'quiz' ) ),
					'help_text'		=>	sprintf( _x( 'Enter single %s ID', 'placeholders: quiz', 'learndash' ), LearnDash_Custom_Label::get_label( 'quiz' ) ),
					'value' 		=> 	'',
					'class'			=>	'small-text',
					'required'		=>	'required'
				);
				
				$this->shortcodes_option_fields['user_id'] = array(
					'id'			=>	$this->shortcodes_section_key . '_user_id',
					'name'  		=> 	'user_id', 
					'type'  		=> 	'number',
					'label' 		=> 	__( 'User ID', 'learndash' ),
					'help_text'		=>	__('Enter specific User ID', 'learndash' ),
					'value' 		=> 	'',
					'class'			=>	'small-text',
					'required'		=>	'required'
				);
				
				$this->shortcodes_option_fields['time'] = array(
					'id'			=>	$this->shortcodes_section_key . '_time',
					'name'  		=> 	'time', 
					'type'  		=> 	'text',
					'label' 		=> 	__( 'Timestamp', 'learndash'),
					'help_text'		=>	sprintf( _x( 'Enter single %s attempt timestamp', 'placeholders: quiz', 'learndash' ), LearnDash_Custom_Label::get_label( 'quiz' ) ),
					'value' 		=> 	'',
					'required'		=>	'required'
				);
			}

			$this->shortcodes_option_fields = apply_filters( 'learndash_settings_fields', $this->shortcodes_option_fields, $this->shortcodes_section_key );
			
			parent::init_shortcodes_section_fields();
		}
		
		function show_shortcodes_section_footer_extra() {
			?>
			<script>
				jQuery(document).ready(function() {
					if ( jQuery( 'form#learndash_shortcodes_form_quizinfo select#quizinfo_show' ).length) {
						jQuery( 'form#learndash_shortcodes_form_quizinfo select#quizinfo_show').change( function() {
							var selected = jQuery(this).val();
							if ( selected == 'timestamp' ) {
								jQuery( 'form#learndash_shortcodes_form_quizinfo #quizinfo_format_field').slideDown();
							} else {
								jQuery( 'form#learndash_shortcodes_form_quizinfo #quizinfo_format_field').hide();
								jQuery( 'form#learndash_shortcodes_form_quizinfo #quizinfo_format_field input').val('');
							}
						});		
						jQuery( 'form#learndash_shortcodes_form_quizinfo select#quizinfo_show').change();
					} 
				});
			</script>
			<?php
		}
		
	}
}
