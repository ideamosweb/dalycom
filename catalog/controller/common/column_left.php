<?php

class ControllerCommonColumnLeft extends Controller {
    private $error = array();

    public function index() {
        $this->load->model('design/layout');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('catalog/information');

        if (isset($this->request->get['route'])) {
            $route = $this->request->get['route'];
        } else {
            $route = 'common/home';
        }

        $layout_id = 0;

        if (substr($route, 0, 16) == 'product/category' && isset($this->request->get['path'])) {
            $path = explode('_', (string) $this->request->get['path']);

            $layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
        }

        if (substr($route, 0, 15) == 'product/product' && isset($this->request->get['product_id'])) {
            $layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
        }

        if (substr($route, 0, 23) == 'information/information' && isset($this->request->get['information_id'])) {
            $layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
        }

        if (!$layout_id) {
            $layout_id = $this->model_design_layout->getLayout($route);
        }

        if (!$layout_id) {
            $layout_id = $this->config->get('config_layout_id');
        }

        $module_data = array();

        $this->load->model('setting/extension');

        $extensions = $this->model_setting_extension->getExtensions('module');

        $this->data['action'] = $this->url->link('common/home', '', '');

        foreach ($extensions as $extension) {
            $modules = $this->config->get($extension['code'] . '_module');

            if ($modules) {
                foreach ($modules as $module) {
                    if ($module['layout_id'] == $layout_id && $module['position'] == 'column_left' && $module['status']) {
                        $module_data[] = array(
                            'code' => $extension['code'],
                            'setting' => $module,
                            'sort_order' => $module['sort_order']
                        );
                    }
                }
            }
        }
        
        // Menu
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');

        $this->data['categories'] = array();

        $categories = $this->model_catalog_category->getCategories(0);        
        foreach ($categories as $category) {
            if ($category['top']) {
                $children_data = array();
                                

                $children = $this->model_catalog_category->getCategories($category['category_id']);
                
                foreach ($children as $child) {
                    $children2_data = array();
                    $data = array(
                        'filter_category_id' => $child['category_id'],
                        'filter_sub_category' => true
                    );
                    
                    // Level 2
                    $children2 = $this->model_catalog_category->getCategories($child['category_id']);
                    foreach ($children2 as $child2) {                   
                        $children2_data[] = array(
                            'name' => $child2['name'],
                            'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child2['category_id'])
                        );
                    }                    
                    $product_total = $this->model_catalog_product->getTotalProducts($data);

                    $children_data[] = array(
                        'name' => $child['name'] . ' (' . $product_total . ')',
                        'children_lv1' => $children2_data,
                        'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                    );                    
                }

                // Level 1
                $this->data['categories'][] = array(
                    'name' => $category['name'],
                    'children' => $children_data,                    
                    'column' => $category['column'] ? $category['column'] : 1,
                    'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
                );
            }
        }
        
        //print_r($this->data['categories']);

        $sort_order = array();

        foreach ($module_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $module_data);

        $this->data['modules'] = array();

        foreach ($module_data as $module) {
            $module = $this->getChild('module/' . $module['code'], $module['setting']);

            if ($module) {
                $this->data['modules'][] = $module;
            }
        }

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
    
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
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

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/column_left.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/column_left.tpl';
        } else {
            $this->template = 'default/template/common/column_left.tpl';
        }

        $this->render();
    }

}

?>