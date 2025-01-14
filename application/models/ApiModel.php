<?php
/**
 * Created by PhpStorm.
 * User: mohammadfaisalahmed
 * Date: 2/17/16
 * Time: 7:33 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'BaseModel.php';

class ApiModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    function getProducts(){
        $products = array();
        $this->db->select("p.*, c.name category_name");
        $this->db->from("nk_product p");
        $this->db->join("nk_category c", "c.id = p.category_id", "left");
        $res = $this->db->get('');

        foreach ($res->result() as $row) {
            $product = array(
                'product_id' => $row->id,
                'product_name' => $row->name,
                'description' => $row->description,
                'price' => $row->price,
                'stock' => $row->stock_quantity,
                'category_title' => $row->category_name,
                'sku' => $row->sku,
                'status' => $row->status,
                'image' => $row->image_url,
                'created_at' => $row->created_at,
            );
            $products[] = $product;
        }

        return $products;
    }

    function getProductByID(){
        $id = $this->getPost("id");
        $products = array();
        $this->db->select("p.*, c.name category_name");
        $this->db->from("nk_product p");
        $this->db->join("nk_category c", "c.id = p.category_id", "left");
        $this->db->where("p.id", $id);
        $res = $this->db->get('');

        foreach ($res->result() as $row) {
            $product = array(
                'product_id' => $row->id,
                'product_name' => $row->name,
                'description' => $row->description,
                'price' => $row->price,
                'stock' => $row->stock_quantity,
                'category_title' => $row->category_name,
                'sku' => $row->sku,
                'status' => $row->status,
                'image' => $row->image_url,
                'created_at' => $row->created_at,
            );
            $products[] = $product;
        }

        return $products;
    }

}