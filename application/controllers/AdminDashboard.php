<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base.php';

class AdminDashboard extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->redirectPublicUser();
        $this->load->model('AdminModel');
    }

    public function index()
    {
        redirect('AdminDashboard/allProducts', 'refresh');
    }

    public function allProducts()
    {
        $allProducts = array();
        $allProducts['products'] = $this->AdminModel->getProducts();
        $allProducts['menuTitle'] = 'All Products';
        $allProducts['menuHighlight'] = 0;
        $allProducts['username'] = $this->getSessionAttr("username");
        $this->viewLoad('admin/dashboard', $allProducts);
    }

    public function addProduct()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if (($error = $this->AdminModel->addProduct()) === TRUE) {
                $data['success'] = 'Product has been added successfully.';
            } else {
                $data['error'] = $error;
            }
        }

        $data['category'] = $this->AdminModel->getCategory();
        $data['menuTitle'] = 'Add A Product';
        $data['menuHighlight'] = 1;
        $data['username'] = $this->getSessionAttr("username");
        $this->viewLoad('admin/add_product', $data);
    }
}