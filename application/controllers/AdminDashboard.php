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

    protected function getErrors(){
        if ( ($error = $this->getSessionAttr('error')) != false){
            $this->unsetSessionAttr('error');
        }

        return $error;
    }

    public function allProducts()
    {
        $allProducts = array();
        $allProducts['application'] = $this->AdminModel->getProducts();
        $allProducts['menuTitle'] = 'All Products';
        $allProducts['item'] = 0;
        $allProducts['username'] = $this->getSessionAttr("username");
        $allProducts['error'] = $this->getErrors();
        $this->viewLoad('admin/dashboard', $allProducts);
    }
}