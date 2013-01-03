<?php
class ControllerModuleFacebook extends Controller {
	protected function index($setting) {

		$this->language->load('facebook/facebook'); 
		$this->data['heading_title'] = $this->language->get('heading_title');

		if(!$this->customer->isLogged()){

			if(!isset($this->fbconnect)){			
				require_once(DIR_SYSTEM . 'facebook/facebook.php');
				$this->fbconnect = new Facebook(array(
					'appId'  => $this->config->get('facebook_apikey'),
					'secret' => $this->config->get('facebook_apisecret'),
				));
			}

			$this->data['facebook_url'] = $this->fbconnect->getLoginUrl(
				array(
					'scope' => 'email,user_birthday,user_location,user_hometown',
					'redirect_uri'  => $this->url->link('facebook/facebook', '', 'SSL')
				)
			);

			if($this->config->get('facebook_button_' . $this->config->get('config_language_id'))){
				$this->data['facebook_button'] = html_entity_decode($this->config->get('facebook_button_' . $this->config->get('config_language_id')));
			}

			else $this->data['facebook_button'] = $this->language->get('heading_title');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/facebook.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/facebook.tpl';
			} else {
				$this->template = 'default/template/module/facebook.tpl';
			}

			$this->render();

		}
	}
}
?>