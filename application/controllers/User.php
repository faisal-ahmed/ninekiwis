<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base.php';

class User extends Base {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->redirectLoggedInUser();
        redirect('user/login', 'refresh');
    }

    public function login(){
        $this->redirectLoggedInUser();

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if ($this->UserModel->login()) {
                $this->redirectLoggedInUser();
            } else {
                $data['error'] = 'Invalid Email or password.';
            }
        } else {
            $data['notification'] = 'Please enter your email and password to login.';
        }

        $this->viewLoad('landing/login', $data);
    }

    public function logout(){
        if ($this->isLoggedIn()){
            session_destroy();
//            $this->session->sess_destroy();
        }
        redirect('user/login', 'refresh');
    }
}
