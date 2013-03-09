<?php

class ControllerModuleFeatured extends Controller {

    protected function index($setting) {
        $this->language->load('module/featured');

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['button_cart'] = $this->language->get('button_cart');

        $this->load->model('catalog/product');
        
        $this->load->model('catalog/category');
        
        $this->load->model('catalog/manufacturer');

        $this->load->model('tool/image');

        $this->data['products'] = array();

        $products = explode(',', $this->config->get('featured_product'));

        if (empty($setting['limit'])) {
            $setting['limit'] = 5;
        }

        $products = array_slice($products, 0, (int) $setting['limit']);        
        foreach ($products as $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);            
            $categories = $this->model_catalog_product->getCategories($product_id);            
            $category_id = $categories ? $categories[0]['category_id'] : "";                       
            $product_category = $categories ? $this->model_catalog_category->getCategory($categories[0]['category_id']) : null;
            $product_category_name = $product_category ? $product_category['name'] : "";
            $product_category_parent_id = $product_category ? $product_category['parent_id'] : "";            
            if ($product_info) {                
                if ($product_info['image']) {
                    $image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
                } else {
                    $image = false;
                }
                
                if($product_info['manufacturer_id']){
                    $manufacturer = $this->model_catalog_manufacturer->getManufacturer($product_info['manufacturer_id']);                   
                    $manufacturer_image = $manufacturer ? HTTP_IMAGE.$manufacturer['image'] : "";
                }

                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $price = false;
                }

                if ((float) $product_info['special']) {
                    $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                } else {
                    $special = false;
                }

                if ($this->config->get('config_review_status')) {
                    $rating = $product_info['rating'];
                } else {
                    $rating = false;
                }

                $parent_id = $product_category_parent_id;
                if ($product_category_parent_id == 62){
                    $parent_id = $category_id;
                }

                $this->data['products'][] = array(
                    'product_id' => $product_info['product_id'],
                    'thumb' => $image,
                    'name' => $product_info['name'],
                    'category' => $product_category_name,
                    'price' => $price,
                    'special' => $special,
                    'rating' => $rating,
                    'reviews' => sprintf($this->language->get('text_reviews'), (int) $product_info['reviews']),
                    'href' => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
                    'href_category' => $this->url->link('product/category', 'path=' . $category_id),
                    'href_category_parent' => $this->url->link('product/category', 'path=' . $parent_id),
                    'manufacturer_img' => $manufacturer_image
                );
            }            
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featured.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/featured.tpl';
        } else {
            $this->template = 'default/template/module/featured.tpl';
        }

        $this->render();
    }

}

?>