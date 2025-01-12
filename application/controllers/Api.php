<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base.php';

class Api extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api');
    }

    public function index()
    {
        exit('No action');
    }

    public function getAllProducts()
    {
        $allProducts = array();
        $allProducts['products'] = $this->AdminModel->getProducts();
        $allProducts['menuTitle'] = 'All Products';
        $allProducts['menuHighlight'] = 0;
        $allProducts['username'] = $this->getSessionAttr("username");
    }
}