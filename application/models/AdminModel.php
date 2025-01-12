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
        $data = array();
        $this->db->select("p.*, c.name category_name");
        $this->db->from("nk_product p");
        $this->db->join("nk_category c", "c.id = p.category_id", "left");
        $res = $this->db->get('');

        foreach ($res->result() as $row) {
            $currentApplication = array(
                'product_name' => $row->name,
                'description' => $row->description,
                'price' => $row->price,
                'stock' => $row->stock_quantity,
                'category_title' => $row->category_name,
                'sku' => $row->sku,
                'status' => $row->status,
                'image' => $row->image_url,
                'created_at' => date("jS F, Y", $row->created_at),
            );
            $data[] = $currentApplication;
        }

        return $data;

    }

    function updateApplication($loan_application_user_id){
        $action = $this->postGet('action');
        if ($action == 'updateTenor') {
            $data = array(
                'tenor' => $this->postGet('updateTenor') . " (New Increased Deadline)",
            );

            $this->db->where("id", $this->postGet('loan_id'));
            $this->db->update('loan', $data);
        } else if ($action == 'addTransaction') {
            $data = array(
                'loan_id' => $this->postGet('loan_id'),
                'amount' => $this->postGet('amount'),
                'type' => PAYMENT_FROM_STUDENT,
                'date' => strtotime($this->postGet('date')),
            );

            $this->db->insert('transaction', $data);

            $query = "UPDATE loan SET remaining_amount = (remaining_amount - " . $this->postGet('amount') . ") WHERE id = " . $this->postGet('loan_id') . ";";
            $query_res = $this->db->query($query);
        } else if ($action == 'statusUpdate') {
            $data = array(
                'status' => $this->postGet('status'),
            );

            if ($data['status'] == EXISTING_LOAN) {
                $data['approved_date'] = time();
                $data['approved_amount'] = $this->postGet('approved_amount');
                $data['remaining_amount'] = $this->postGet('approved_amount');
                $data['tenor'] = $this->postGet('tenor');
            }

            $this->db->where('user_id', $loan_application_user_id);
            $this->db->update('loan', $data);

            if ($data['status'] == EXISTING_LOAN) {
                /* Adding the New Transaction Start */
                $data = array(
                    'loan_id' => $this->postGet('loan_id'),
                    'amount' => $this->postGet('approved_amount'),
                    'type' => LOAN_TO_STUDENT,
                    'date' => time(),
                );

                $this->db->insert('transaction', $data);
                /* Adding the New Transaction End */

                $emailData = array('password' => $this->randomPassword());

                /* Setting Users New Password Start */
                $data = array(
                    'password' => md5($emailData['password']),
                );

                $this->db->where('id', $loan_application_user_id);
                $this->db->update('users', $data);
                /* Setting Users New Password End */

                /* Getting information of User Start */
                $this->db->select("email, username, p.firstname, p.lastname");
                $this->db->join("personal_info p", "p.user_id = users.id", "left");
                $this->db->where("users.id", $loan_application_user_id);
                $res = $this->db->get("users");
                $to = 0;

                foreach ($res->result() as $key => $value) {
                    $emailData['name'] = $value->firstname . " " . $value->lastname;
                    $emailData['username'] = $value->username;
                    $to = $value->email;
                    break;
                }
                /* Getting information of User Start */

                $emailData['tenor'] = $this->postGet('tenor');

                $this->sendEmail($to, 'Congratulation! Your IIT Study Loan has been approved.',
                    "emailTemplate/loanApproved.php", $emailData);
            }
        }

        return true;
    }
}