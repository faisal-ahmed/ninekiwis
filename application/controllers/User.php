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

        $data = array(
            'hide_menu' => 'login'
        );

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if ($this->UserModel->login()) {
                $this->redirectLoggedInUser();
            } else {
                $data['error'] = 'Invalid Username or password.';
            }
        } else {
            $data['notification'] = 'Please enter your username and password to login.';
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

    public function forgotPassword(){
        $this->redirectLoggedInUser();
        $data = array();

        if (strtolower($this->input->method()) == 'post'){
            if ($this->UserModel->forgetPassword()){
                $data['success'] = 'An email has been sent to your email address. Please follow the instruction in your email to gain access to your account again.';
            } else {
                $data['error'] = 'There is no account matching with that email. Please enter correct email.';
            }
        }

        $this->viewLoad('landing/forgot_password', $data);
    }

    public function updateProfile(){
        $this->redirectPublicUser();
        $data = array();

        if (strtolower($this->input->method()) == 'post'){
            if ( ($error = $this->UserModel->updateProfile($this->getUserId())) !== true ){
                $data['error'] = $error;
            } else {
                $data['success'] = 'Your profile has been updated successfully.';
            }
        }

        $data['userData'] = $this->UserModel->getUserData($this->getUserId());
        $data['role'] = $this->getUserRole();

        $this->viewLoad('common/userProfile', $data);
    }
}
