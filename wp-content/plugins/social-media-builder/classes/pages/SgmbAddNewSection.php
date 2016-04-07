<?php

class SgmbAddNewSection
{
	public function init()
	{
		$data = $this->getData();
		$theme = isset($data['options'])?$data['options']['socialTheme']:SGMB_DEFAULT_THEME;
		SgmbAddNewSection::renderScripts($theme);
		$this->render();
	}

	public function render()
	{
		$data = $this->getData();
		require_once(SGMB_VIEW.'sgmb_buttons_create.php');
	}

	public static function createSelect($fieldName, $selectedKey, $data, $optionType, $buttonName = null, $showOptionsGroup = true)
	{
		if(@$data['options']['fontSize'] == '') {
			@$data['options']['fontSize'] = '14';
		}
		if(@$data['options']['sgmbDropdownLabelFontSize'] == '') {
			@$data['options']['sgmbDropdownLabelFontSize'] = '14';
		}
		$html = "<select  name='".$fieldName."' class ='input-width-static selectOption js-social-btn-icon' data-social-button='".$buttonName."'";
		if($optionType == 'sgmbSelectedPosts') {
			$html .= "multiple='multiple'>";
		}
		else {
			$html .= ">";
		}
		
		foreach ($selectedKey as $key => $value) {
			if(!is_array($value)) {
				$html .= "<option value = '$value'" ;
				if($buttonName == 'fbLike') { 
					if($value == @$data['buttonOptions'][$buttonName][$optionType]) {
						$html .= "selected";
					}
				}
				// if multi select element
				if($optionType == 'sgmbSelectedPosts') { 
					if(@$data['options'][$optionType] != null) {
						foreach (@$data['options'][$optionType] as  $option) {
							if($option == $value) {  
								$html .= "selected"; 
							}
						}
					}
					else {
						foreach ($selectedKey as $option) {
							if($option == $value) {  
								$html .= "selected"; 
							}
						}
					}
				}
				elseif($value == @$data['options'][$optionType]) { 
					$html .= "selected";
				}
				$html .= ">$value</option>";
			}
			else {
				if(SGMB_PRO == 0 && $showOptionsGroup == true) {
					$html .='<optgroup label="'.$key.'">';
				}
				foreach ($value as $option) {
					$html .= "<option value = '$option'" ;

					if(SGMB_PRO == 0 && $key == 'Pro' && $showOptionsGroup == true) {
						$html .= "disabled";
					}
					if($buttonName == 'fbLike') { 
						if($option == @$data['buttonOptions'][$buttonName][$optionType]) {
							$html .= "selected";
						}
					}
					if($option == @$data['options'][$optionType]) { 
						$html .= "selected"; 
					}
					$html .= ">$option</option>";
				}
				if(SGMB_PRO == 0 && $showOptionsGroup == true) {
					$html .='</optgroup>';
				}
			}
		}
		$html .= "</select>";
		return $html;
	}

	public function getData()
	{
		$data = array();
		if (isset($_GET['id'])) {
			$id = intval(sanitize_text_field($_GET['id']));
			$result = SGMBButton::findById($id);
			if ($result) {
				$data['id'] = $result->getId();
				$data['title'] = $result->getTitle();
				$data['options'] = json_decode($result->getOptions(), true);
				$data['buttonOptions'] = json_decode($data['options']['buttons'],true);
				foreach ($data['buttonOptions'] as $key => $value) {
					$data['button'][] = $key;
				}
			}
		}
		return $data;
	}

	public function renderOptions($name)
	{
		$data = $this->getData();
		include(SGMB_VIEW.'option-pages/'.$name.'.php');
	}

	public static function renderScripts($themeType )
	{
		if($themeType == null) {
			$themeType = SGMB_DEFAULT_THEME;
		}
		wp_register_style('sgmb_dropdown_style', SGMB_URL.'css/widget/simple.dropdown.css');
		wp_enqueue_style('sgmb_dropdown_style');
		wp_register_style('sgmb_tab_theme_style', SGMB_URL.'css/themes/pepper-grinder/jquery-ui.css');
		wp_enqueue_style('sgmb_tab_theme_style');
		wp_register_style('sgmb_social3_style', SGMB_URL.'css/jssocial/jquery-ui.structure.css');
		wp_enqueue_style('sgmb_social3_style');
		wp_register_style('sgmb_tab_vertical_style', SGMB_URL.'css/widget/tabs_vertical_style.css');
		wp_enqueue_style('sgmb_tab_vertical_style');
		wp_register_style('sgmb_drag_style', SGMB_URL.'css/widget/drag_style.css');
		wp_enqueue_style('sgmb_drag_style');
		wp_register_style('sgmb_social1_style', SGMB_URL.'css/jssocial/font-awesome.min.css');
		wp_enqueue_style('sgmb_social1_style');
		wp_register_style('sgmb_social2_style', SGMB_URL.'css/jssocial/jssocials.css');
		wp_enqueue_style('sgmb_social2_style');
		wp_register_style('sgmb_widget_style', SGMB_URL.'css/widget/widget-style.css');
		wp_enqueue_style('sgmb_widget_style');
		wp_register_style('jssocials_theme_tm', SGMB_URL.'css/widget/jssocials-theme-'.$themeType.'.css');
		wp_enqueue_style('jssocials_theme_tm');
		wp_register_style('sgmb_button_animate',  SGMB_URL.'css/animate.css');
		wp_enqueue_style('sgmb_button_animate');

		wp_register_script('sgmb-classWidget-scripts', SGMB_URL.'js/addNewSection/SGMBWidget.js', array('jquery','jquery-ui-core','jquery-ui-tabs','jquery-ui-draggable','jquery-ui-droppable','jquery-ui-accordion'),null);
		wp_enqueue_script('sgmb-classWidget-scripts');
		wp_register_script('sgmb-classDrag-scripts', SGMB_URL.'js/addNewSection/SGMBButtonPanel.js', array('jquery'),null);
		wp_enqueue_script('sgmb-classDrag-scripts');
		wp_register_script('sgmb-class-scripts', SGMB_URL.'js/addNewSection/SGMB.js', array('jquery'),null);
		wp_enqueue_script('sgmb-class-scripts');
		wp_register_script('sgmb-dropdown-scripts', SGMB_URL.'js/simple.dropdown.js', array('jquery'),null);
		wp_enqueue_script('sgmb-dropdown-scripts');
		wp_register_script('sgmb-jssocial1-scripts', SGMB_URL.'js/jssocials.min.js', array('jquery'),null);
		wp_enqueue_script('sgmb-jssocial1-scripts');
		wp_register_script('sgmb-classLive-scripts', SGMB_URL.'js/addNewSection/SGMBLivePreview.js', array('jquery'),null);
		wp_enqueue_script('sgmb-classLive-scripts');
	}
}
