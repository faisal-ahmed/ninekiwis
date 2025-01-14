<?php
require_once 'Base.php';

class Api extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ApiModel');
    }

    public function index()
    {
        exit('No action');
    }

    public function getProducts()
    {
        $allProducts = array();
        $allProducts['products'] = $this->ApiModel->getProducts();
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($allProducts));
    }

    public function getProductByID()
    {
        $productByID = $this->ApiModel->getProductByID();
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($productByID));
    }
}