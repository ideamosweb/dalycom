<?php

class ControllerInformationContactsoporte extends Controller {

    private $error = array();

    public function index() {
        $this->language->load('information/contactsoporte');

        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');
            $mail->setTo($this->config->get('config_email'));
            $mail->setFrom($this->request->post['email']);
            $mail->setSender($this->request->post['name']);
            $mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name'], $this->request->post['phone'], $this->request->post['company']), ENT_QUOTES, 'UTF-8'));
            $mail->setText(strip_tags(html_entity_decode($this->request->post['enquiry'], ENT_QUOTES, 'UTF-8')));
            $mail->send();

            $this->redirect($this->url->link('information/contactsoporte/success'));
        }        

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('information/contactsoporte'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_location'] = $this->language->get('text_location');
        $this->data['text_contact'] = $this->language->get('text_contact');
        $this->data['text_address'] = $this->language->get('text_address');
        $this->data['text_telephone'] = $this->language->get('text_telephone');
        $this->data['text_fax'] = $this->language->get('text_fax');

        $this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_email'] = $this->language->get('entry_email');
        $this->data['entry_phone'] = $this->language->get('entry_phone');
        $this->data['entry_company'] = $this->language->get('entry_company');
        $this->data['entry_asunto'] = $this->language->get('entry_asunto');
        $this->data['entry_enquiry'] = $this->language->get('entry_enquiry');
        $this->data['entry_captcha'] = $this->language->get('entry_captcha');

        if (isset($this->error['name'])) {
            $this->data['error_name'] = $this->error['name'];
        } else {
            $this->data['error_name'] = '';
        }

        if (isset($this->error['email'])) {
            $this->data['error_email'] = $this->error['email'];
        } else {
            $this->data['error_email'] = '';
        }
        
        if (isset($this->error['phone'])) {
            $this->data['error_phone'] = $this->error['phone'];
        } else {
            $this->data['error_phone'] = '';
        }
        
        if (isset($this->error['company'])) {
            $this->data['error_company'] = $this->error['company'];
        } else {
            $this->data['error_company'] = '';
        }

        if (isset($this->error['asunto'])) {
            $this->data['error_asunto'] = $this->error['asunto'];
        } else {
            $this->data['error_asunto'] = '';
        }

        if (isset($this->error['enquiry'])) {
            $this->data['error_enquiry'] = $this->error['enquiry'];
        } else {
            $this->data['error_enquiry'] = '';
        }

        if (isset($this->error['captcha'])) {
            $this->data['error_captcha'] = $this->error['captcha'];
        } else {
            $this->data['error_captcha'] = '';
        }

        $this->data['button_continue'] = $this->language->get('button_continue');

        $this->data['action'] = $this->url->link('information/contactsoporte');
        $this->data['store'] = $this->config->get('config_name');
        $this->data['address'] = nl2br($this->config->get('config_address'));
        $this->data['telephone'] = $this->config->get('config_telephone');
        $this->data['fax'] = $this->config->get('config_fax');

        if (isset($this->request->post['name'])) {
            $this->data['name'] = $this->request->post['name'];
        } else {
            $this->data['name'] = $this->customer->getFirstName();
        }

        if (isset($this->request->post['email'])) {
            $this->data['email'] = $this->request->post['email'];
        } else {
            $this->data['email'] = $this->customer->getEmail();
        }
        
        if (isset($this->request->post['phone'])) {
            $this->data['phone'] = $this->request->post['phone'];
        } else {
            $this->data['phone'] = '';
        }
        
        if (isset($this->request->post['company'])) {
            $this->data['company'] = $this->request->post['company'];
        } else {
            $this->data['company'] = '';
        }

        if (isset($this->request->post['asunto']) || isset($this->request->get['asunto'])) {
            if(isset($this->request->post['asunto']))
                $this->data['asunto'] = $this->request->post['asunto'];
            elseif (isset($this->request->get['asunto']))
                $this->data['asunto'] = $this->request->get['asunto'];            
        } else {
            $this->data['asunto'] = "";
        }

        if (isset($this->request->post['enquiry'])) {
            $this->data['enquiry'] = $this->request->post['enquiry'];
        } else {
            $this->data['enquiry'] = '';
        }

        if (isset($this->request->post['captcha'])) {
            $this->data['captcha'] = $this->request->post['captcha'];
        } else {
            $this->data['captcha'] = '';
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/contactsoporte.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/information/contactsoporte.tpl';
        } else {
            $this->template = 'default/template/information/contactsoporte.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );

        $this->response->setOutput($this->render());
    }

    public function success() {
        $this->language->load('information/contactsoporte');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('information/contactsoporte'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_message'] = $this->language->get('text_message');

        $this->data['button_continue'] = $this->language->get('button_continue');

        $this->data['continue'] = $this->url->link('common/home');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/success.tpl';
        } else {
            $this->template = 'default/template/common/success.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );

        $this->response->setOutput($this->render());
    }

    private function validate() {
        if (isset($this->request->post['name']) and (utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if (isset($this->request->post['email']) and !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
            $this->error['email'] = $this->language->get('error_email');
        }
        
        if (isset($this->request->post['phone']) and (utf8_strlen($this->request->post['phone']) < 1) || (utf8_strlen($this->request->post['phone']) > 12) || !intval($this->request->post['phone'])) {
            $this->error['phone'] = $this->language->get('error_phone');
        }
        
        if (isset($this->request->post['company']) and (utf8_strlen($this->request->post['company']) < 3) || (utf8_strlen($this->request->post['company']) > 112)) {
            $this->error['company'] = $this->language->get('error_company');
        }

        if (isset($this->request->post['asunto']) and (utf8_strlen($this->request->post['asunto']) < 3) || (utf8_strlen($this->request->post['asunto']) > 112)) {
            $this->error['asunto'] = $this->language->get('error_asunto');
        }

        if (isset($this->request->post['enquiry']) and (utf8_strlen($this->request->post['enquiry']) < 10) || (utf8_strlen($this->request->post['enquiry']) > 3000)) {
            $this->error['enquiry'] = $this->language->get('error_enquiry');
        }

        if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
            $this->error['captcha'] = $this->language->get('error_captcha');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function captcha() {
        $this->load->library('captcha');

        $captcha = new Captcha();

        $this->session->data['captcha'] = $captcha->getCode();

        $captcha->showImage();
    }

}

?>
