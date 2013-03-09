<?php  
class ControllerCommonHome extends Controller {
	private $error = array();
	public function index() {
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->load->language('common/login_index');

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/home.tpl';
		} else {
			$this->template = 'default/template/common/home.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);

		/* Login in Admin */
		if ($this->request->server['REQUEST_METHOD'] == 'POST'){
			$array_data = array(
				'redirect' => '',
				'error' => '',
				'success' => '',
				'user' => '',
				'pass' => ''
			);

			if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
				$this->session->data['token'] = md5(mt_rand());			
			
				if (isset($this->request->post['redirect'])) {				
					//$this->redirect($this->request->post['redirect'] . '&token=' . $this->session->data['token']);
					$array_data['redirect'] = html_entity_decode($this->request->post['redirect'] . '&token=' . $this->session->data['token']);
				} else {								
					//$this->redirect($this->url_admin->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));
					$array_data['redirect'] = html_entity_decode($this->url_admin->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));										
				}
			}

			if (((isset($this->request->get['token']) && (isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token']))))) {			
				$this->error['warning'] = $this->language->get('error_token');				
			}
			
			if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];				
				$array_data['error'] = $this->error['warning'];
			} else {
				$this->data['error_warning'] = '';
			}
			
			if (isset($this->session->data['success'])) {
	    		$this->data['success'] = $this->session->data['success'];    
				unset($this->session->data['success']);
				$array_data['success'] = $this->session->data['success'];
			} else {
				$this->data['success'] = '';
			}

			if (isset($this->request->post['username'])) {
				$this->data['username'] = $this->request->post['username'];
				$array_data['username'] = $this->request->post['username'];
			} else {
				$this->data['username'] = '';
			}
			
			if (isset($this->request->post['password'])) {
				$this->data['password'] = $this->request->post['password'];
				$array_data['password'] = $this->request->post['password'];
			} else {
				$this->data['password'] = '';
			}

			if (isset($this->request->get['route'])) {
				$route = $this->request->get['route'];
				
				unset($this->request->get['route']);
				
				if (isset($this->request->get['token'])) {
					unset($this->request->get['token']);
				}
				
				$url = '';
							
				if ($this->request->get) {
					$url .= http_build_query($this->request->get);
				}
				
				$this->data['redirect'] = html_entity_decode($this->url->link($route, $url, 'SSL'));
			}

			$json_val = json_encode($array_data);
			print_r($json_val);
		}else{
			$this->response->setOutput($this->render());
		}
		/* End Login in Admin */

		
	}

	private function validate() {
		if (isset($this->request->post['username']) && isset($this->request->post['password']) && !$this->user->login($this->request->post['username'], $this->request->post['password'])) {			
			$this->error['warning'] = $this->language->get('error_login');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>