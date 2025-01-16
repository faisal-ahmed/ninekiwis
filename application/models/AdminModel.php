<?php
/**
 * Created by PhpStorm.
 * User: mohammadfaisalahmed
 * Date: 2/17/16
 * Time: 7:33 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'BaseModel.php';

class AdminModel extends BaseModel
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

    function getCategory(){
        $category = array();
        $this->db->select("*");
        $this->db->from("nk_category");
        $res = $this->db->get('');

        foreach ($res->result() as $row) {
            $category[$row->id] = $row->name;
        }

        return $category;
    }

    function addProduct(){
        $filename = $_FILES['product_image']['name'];
        $config['file_name'] = time() . substr($filename, strrpos($filename, "."));
        $config['upload_path'] = './product_images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|tiff|heif|webp';
        $config['max_size'] = 4000;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('product_image')) {
            $error = $this->upload->display_errors();
            return $error;
        }
        $data = $this->upload->data();
        $uploaded_file_path = base_url() . "product_images/" . $data['file_name'];

        $data = array(
            'name' => $this->postGet('name'),
            'description' => $this->postGet('description'),
            'price' => $this->postGet('price'),
            'stock_quantity' => $this->postGet('stock_quantity'),
            'category_id' => $this->postGet('category_id'),
            'sku' => $this->postGet('sku'),
            'image_url' => $uploaded_file_path,
            'status' => $this->postGet('status')
        );

        $this->db->insert('nk_product', $data);

        return true;
    }
}