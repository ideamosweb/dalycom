<?php  
class ControllerCommonLoginIndex extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('common/login_index');

		/*if ($this->user->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {						
			$this->redirect($this->url_admin->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));
		}*/

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) { 
			$this->session->data['token'] = md5(mt_rand());			
		
			if (isset($this->request->post['redirect'])) {				
				$this->redirect($this->request->post['redirect'] . '&token=' . $this->session->data['token']);
			} else {								
				$this->redirect($this->url_admin->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		if ((isset($this->session->data['token']) && !isset($this->request->get['token'])) || ((isset($this->request->get['token']) && (isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token']))))) {			
			$this->error['warning'] = $this->language->get('error_token');
		}
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
    		$this->data['success'] = $this->session->data['success'];
    
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->request->post['username'])) {
			$this->data['username'] = $this->request->post['username'];
		} else {
			$this->data['username'] = '';
		}
		
		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
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
			
			$this->data['redirect'] = $this->url->link($route, $url, 'SSL');
		} else {
			$this->data['redirect'] = '';	
		}	

		//$this->response->setOutput($this->render());
		$this->redirect($this->url->link('common/home', '', ''));		
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