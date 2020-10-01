<?php

function ssbl_admin_header()
{
	// open wrap
	$htmlHeader = '<div class="ssbl-admin-wrap">';

	// navbar/header
	$htmlHeader .= '<nav class="navbar navbar-default">
					  <div class="container-fluid">
					    <div class="navbar-header">
					      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#ssbl-navbar-collapse">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </button>
					      <a class="navbar-brand" href="https://simplesharebuttons.com"><img src="'.plugins_url().'/simple-share-buttons-light/images/simplesharebuttons.png" alt="Simple Share Buttons Plus" class="ssbl-logo-img" /></a>
					    </div>

					    <div class="collapse navbar-collapse" id="ssbl-navbar-collapse">
					      <ul class="nav navbar-nav navbar-right">
					        <li><a href="https://wordpress.org/support/plugin/simple-share-buttons-light" target="_blank">Support</a></li>
						  </ul>
						</div>
					  </div>
					</nav>';

		// open container - closed in footer
		$htmlHeader .= '<div class="container">';

	// return
	return $htmlHeader;
}

function ssbl_admin_footer()
{
	// row
	$htmlFooter = '<footer class="row">';

		// col
		$htmlFooter .= '<div class="col-sm-12">';

			// link to show footer content
			$htmlFooter .= '<a href="https://simplesharebuttons.com" target="_blank">Simple Share Buttons Light</a> <span class="badge">'.SSBL_VERSION.'</span>';

		// close col
		$htmlFooter .= '</div>';

	// close row
	$htmlFooter .= '</footer>';

	// close container - opened in header
	$htmlFooter .= '</div>';

	// close ssbl-admin-wrap - opened in header
	$htmlFooter .= '</div>';

	// return
	return $htmlFooter;
}

function ssbl_admin_panel($arrSettings) {

	// include the forms helper
	include_once SSBL_ROOT.'/system/helpers/ssbl_forms.php';

	// prepare array of buttons
    $arrButtons = json_decode(get_option('ssbl_buttons'), true);

	// get the font family needed
	$htmlShareButtonsForm = '<style>'.ssbl_get_font_family().'</style>';

	// if left to right
	if (is_rtl()) {
    	// move save button
    	$htmlShareButtonsForm .= '<style>.ssbl-btn-save{left: 0!important;
                                        right: auto !important;
                                        border-radius: 0 5px 5px 0;}
                                </style>';
	}

	// add header
	$htmlShareButtonsForm .= ssbl_admin_header();

	// initiate forms helper
	$ssblForm = new ssblForms;

	// opening form tag
	$htmlShareButtonsForm .= $ssblForm->open(false);

	// heading
	$htmlShareButtonsForm .= '<h2>Simple Share Buttons Light</h2>';

	//======================================================================
	// 		CORE
	//======================================================================
	$htmlShareButtonsForm .= '<div>';

		// COLUMN --------------------------------
		$htmlShareButtonsForm .= '<div class="col-sm-12">';

			// locations array
			$locs = array(
				'Pages'	=> array(
					'value' => 'pages',
					'checked' => ($arrSettings['pages'] == 'Y'  ? true : false)
				),
				'Posts' => array(
					'value' => 'posts',
					'checked' => ($arrSettings['posts'] == 'Y'  ? true : false)
				),
			);
			// locations
			$opts = array(
				'form_group' 	=> false,
				'label' 		=> 'Locations',
				'tooltip'		=> 'Enable the locations you wish for share buttons to appear',
				'value'			=> 'Y',
				'checkboxes'	=> $locs
			);
			$htmlShareButtonsForm .= $ssblForm->ssbl_checkboxes($opts);

			// placement
            $opts = array(
                'form_group'	=> false,
                'type'       	=> 'select',
                'name'          => 'image_set',
                'label'        	=> 'Image Set',
                'tooltip'       => 'Select your preferred image set',
                'selected'      => $arrSettings['image_set'],
                'options'       => array(
                                        'Circle'    => 'circle',
                                        'Square'    => 'square',
                                    ),
            );
			$htmlShareButtonsForm .= $ssblForm->ssbl_input($opts);

            // share text
            $opts = array(
                'form_group'    => false,
                'type'          => 'text',
                'placeholder'	=> 'Keeping sharing simple...',
                'name'          => 'share_text',
                'label'        	=> 'Share Text',
                'tooltip'       => 'Add some custom text by your share buttons',
                'value'         => $arrSettings['share_text'],
            );
			$htmlShareButtonsForm .= $ssblForm->ssbl_input($opts);

			// networks
			$htmlShareButtonsForm .= '<label for="choices" class="control-label" data-toggle="tooltip" data-placement="right" data-original-title="Drag, drop and reorder those buttons that you wish to include">Networks</label>
										<div class="">';

				$htmlShareButtonsForm .= '<div class="ssbp-wrap ssbp--centred ssbp--theme-4">
												<div class="ssbp-container">
													<ul id="ssblsort1" class="ssbp-list ssblSortable">';
							$htmlShareButtonsForm .= getAvailableSSBL($arrSettings['selected_buttons']);
						$htmlShareButtonsForm .= '</ul>
												</div>
											</div>';
					$htmlShareButtonsForm .= '<div class="well">';
					$htmlShareButtonsForm .= '<div class="ssbl-well-instruction"><i class="fa fa-download"></i> Drop icons below</div>';
					$htmlShareButtonsForm .= '<div class="ssbp-wrap ssbp--centred ssbp--theme-4">
												<div class="ssbp-container">
													<ul id="ssblsort2" class="ssbl-include-list ssbp-list ssblSortable">';
							$htmlShareButtonsForm .= getSelectedSSBL($arrSettings['selected_buttons']);
						$htmlShareButtonsForm .= '</ul>
											</div>';
					$htmlShareButtonsForm .= '</div>';
				$htmlShareButtonsForm .= '</div>';
				$htmlShareButtonsForm .= '<input type="hidden" name="selected_buttons" id="selected_buttons" value="'.$arrSettings['selected_buttons'].'"/>';

			$htmlShareButtonsForm .= '</div>';

		// close col
		$htmlShareButtonsForm .= '</div>';

	// close off form with save button
	$htmlShareButtonsForm .= $ssblForm->close();

	// add footer
	$htmlShareButtonsForm .= ssbl_admin_footer();

	echo $htmlShareButtonsForm;
}

// get an html formatted of currently selected and ordered buttons
function getSelectedSSBL($strSelectedSSBL) {

	// variables
	$htmlSelectedList = '';
	$arrSelectedSSBL = '';

	// prepare array of buttons
	$arrButtons = json_decode(get_option('ssbl_buttons'), true);

	// if there are some selected buttons
	if ($strSelectedSSBL != '') {

		// explode saved include list and add to a new array
		$arrSelectedSSBL = explode(',', $strSelectedSSBL);

		// check if array is not empty
		if ($arrSelectedSSBL != '') {

			// for each included button
			foreach ($arrSelectedSSBL as $strSelected) {

				// add a list item for each selected option
				$htmlSelectedList .= '<li class="ssbl-option-item" id="'.$strSelected.'"><a href="javascript:;" class="ssbp-btn ssbp-'.$strSelected.'"></a></li>';
			}
		}
	}

	// return html list options
	return $htmlSelectedList;
}

function getAvailableSSBL($strSelectedSSBL)
{
	// variables
	$htmlAvailableList = '';
	$arrSelectedSSBL = '';

	// prepare array of buttons
	$arrButtons = json_decode(get_option('ssbl_buttons'), true);

	// explode saved include list and add to a new array
	$arrSelectedSSBL = explode(',', $strSelectedSSBL);

	// extract the available buttons
	$arrAvailableSSBL = array_diff(array_keys($arrButtons), $arrSelectedSSBL);

	// check if array is not empty
	if($arrSelectedSSBL != '')
	{
		// for each included button
		foreach($arrAvailableSSBL as $strAvailable)
		{
			// add a list item for each available option
			$htmlAvailableList .= '<li class="ssbl-option-item" id="'.$strAvailable.'"><a href="javascript:;" class="ssbp-btn ssbp-'.$strAvailable.'"></a></li>';
		}
	}

	// return html list options
	return $htmlAvailableList;
}

// get ssbl font family
function ssbl_get_font_family()
{
	return "@font-face {
				font-family: 'ssbp';
				src:url('".plugins_url()."/simple-share-buttons-light/sharebuttons/assets/fonts/ssbp.eot?xj3ol1');
				src:url('".plugins_url()."/simple-share-buttons-light/sharebuttons/assets/fonts/ssbp.eot?#iefixxj3ol1') format('embedded-opentype'),
					url('".plugins_url()."/simple-share-buttons-light/sharebuttons/assets/fonts/ssbp.woff?xj3ol1') format('woff'),
					url('".plugins_url()."/simple-share-buttons-light/sharebuttons/assets/fonts/ssbp.ttf?xj3ol1') format('truetype'),
					url('".plugins_url()."/simple-share-buttons-light/sharebuttons/assets/fonts/ssbp.svg?xj3ol1#ssbl') format('svg');
				font-weight: normal;
				font-style: normal;

				/* Better Font Rendering =========== */
				-webkit-font-smoothing: antialiased;
				-moz-osx-font-smoothing: grayscale;
			}";
}
