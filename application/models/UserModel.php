<?php
/**
 * Created by PhpStorm.
 * User: mohammadfaisalahmed
 * Date: 2/17/16
 * Time: 7:33 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'BaseModel.php';

class UserModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    function login()
    {
        $username = $this->postGet('username');
        $password = $this->postGet('password');

        $this->db->select("users.id, role.id as role_id");
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $this->db->join('role', 'role.id = users.role_id', 'left');
        $res = $this->db->get('users');

        foreach ($res->result() as $user) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user->id;
            $role = ($user->role_id == 1) ? ADMIN_ROLE_TITLE : STUDENT_ROLE_TITLE;
            $_SESSION['role'] = $role;
            return true;
        }
        return false;
    }

    function checkLoanStatus(){
        $student_id = $this->postGet('student_id');
        $this->db->select('loan.status');
        $this->db->from('loan');
        $this->db->join("personal_info p", "p.user_id = loan.user_id", "left");
        $this->db->where('p.student_id', $student_id);
        $this->db->order_by("loan.id", "desc");
        $res = $this->db->get();

        foreach ($res->result() as $key => $value){
            return $value->status . ".";
        }

        return false;
    }

    function newLoanApplication(){
        $genericErrorMessage = "An error found. Please try again later!";

        $data = $this->getData();
        if ( ($errorMessage = $this->validLoanApplicationData($data)) !== true ) return $errorMessage;

        /* User Information Creation Started */

        $userData = array(
            'username' => time(),
            'password' => md5($data['student_id']),
            'email' => $this->postGet('email'),
            'role_id' => '2',
            'created_time' => time(),
            'modified_time' => time(),
        );

        $userCreated = $this->db->insert('users', $userData);

        if (!$userCreated){
            return $genericErrorMessage;
        }

        $user_id = $this->db->insert_id();

        /* User Information Creation Ended */

        /* Personal Information Creation Ended */

        $personal_info_data = array(
            'user_id' => $user_id,
            'firstname' => $data['fname'] ,
            'lastname' => $data['lname'] ,
            'national_id' => $data['nid'] ,
            'student_id' => $data['student_id'] ,
            'student_cgpa' => $data['student_cgpa'] ,
            'present_address' => $data['students_present_address'],
            'permanent_address' => $data['students_permanent_address'],
            'phone' => $data['student_phone'],
            'completed_credits' => $data['completed_credits'],
            'last_semester' => $data['last_semester'],
            'taken_credits' => $data['taken_credits'],
            'next_semester' => $data['next_semester'],
            'previous_semester_gpa' => $data['previous_semester_gpa'],
        );

        $personal_info_created = $this->db->insert('personal_info', $personal_info_data);

        if (!$personal_info_created){
            return $genericErrorMessage;
        }

        /* Personal Information Creation Ended */

        /* Loan Application Creation Started */

        $loan_data = array(
            'user_id' => $user_id,
            'requested_amount' => $data['loan_amount'] ,
            'note' => $data['reason']
        );

        $loanApplicationSubmitted = $this->db->insert('loan', $loan_data);

        if (!$loanApplicationSubmitted){
            return $genericErrorMessage;
        }

        $loan_id = $this->db->insert_id();

        /* Loan Application Creation Ended */

        /* Loan Guarantor Creation Started */

        $loan_guarantor_data = array(
            'loan_id' => $loan_id ,
            'guarantor_name' => $data['gname'] ,
            'relation' => $data['relation'],
            'guarantor_contact_no' => $data['gphone'] ,
            'guarantor_address' => $data['gaddress']
        );

        $loan_guarantor_created = $this->db->insert('loan_guarantor', $loan_guarantor_data);

        if (!$loan_guarantor_created){
            return $genericErrorMessage;
        }

        /* Loan Guarantor Creation Ended */

        return true;
    }

    function validLoanApplicationData($data){
        if ( ($status = $this->validateRequired($data) !== true) ) return $status;
        if ( ($status = $this->validateEmail($data) !== true) ) return $status;
        return true;
    }

    function validateRequired($data){
        $required = array(
            'student_id', 'fname', 'lname', 'student_id', 'student_cgpa',
            'student_phone', 'students_present_address', 'loan_amount',
            'reason', 'gname', 'relation', 'gphone', 'gaddress',
        );

        foreach ($required as $key => $value) {
            if (!isset($data[$value]) || $data[$value] == '') {
                return ucwords(str_replace("_", " ", $value)) . " is required.";
            }
        }

        return true;
    }

    function validateEmail($data){
        $email = array('email');

        foreach ($email as $key => $value){
            if (!filter_var($data[$value], FILTER_VALIDATE_EMAIL)) {
                return ucwords(str_replace("_", " ", $value)) . " is invalid.";
            }
        }

        return true;
    }


    function getData(){
        $data = array();

        $data['fname'] = $this->postGet('fname');
        $data['lname'] = $this->postGet('lname');
        $data['nid'] = $this->postGet('nid');
        $data['student_id'] = $this->postGet('student_id');
        $data['student_cgpa'] = $this->postGet('student_cgpa');
        $data['student_phone'] = $this->postGet('student_phone');
        $data['students_present_address'] = $this->postGet('students_present_address');
        $data['students_permanent_address'] = $this->postGet('students_permanent_address');
        $data['loan_amount'] = $this->postGet('loan_amount');

        $data['reason'] = $this->postGet('reason');
        $data['gname'] = $this->postGet('gname');
        $data['relation'] = $this->postGet('relation');
        $data['gphone'] = $this->postGet('gphone');
        $data['gaddress'] = $this->postGet('gaddress');
        $data['email'] = $this->postGet('email');
        $data['completed_credits'] = $this->postGet('student_completed_credits');
        $data['last_semester'] = $this->postGet('last_semester_name');
        $data['taken_credits'] = $this->postGet('student_taken_credits');
        $data['next_semester'] = $this->postGet('next_semester_name');
        $data['previous_semester_gpa'] = $this->postGet('previous_semester_gpa');
        return $data;
    }
    function getUserData($userId) {
        $data = array();
        $this->db->select('p.firstname, p.lastname, users.email, p.phone');
        $this->db->from("users");
        $this->db->join("personal_info p", "p.user_id = users.id", "left");
        $this->db->where('users.id', $userId);
        $res = $this->db->get();

        foreach ($res->result() as $row){
            $data = array(
                'firstname' => $row->firstname,
                'lastname' => $row->lastname,
                'email' => $row->email,
                'phone' => $row->phone,
            );

            break;
        }

        return $data;
    }

    function updateProfile($userId){
        $newPassword = $this->postGet('newPassword');
        $confirmPassword = $this->postGet('confirmPassword');
        $password = $this->postGet('currentPassword');
        $passwordValid = false;

        $this->db->where('id', $userId);
        $this->db->where('password', md5($password));
        $res = $this->db->get('users');

        foreach ($res->result() as $user) {
            $passwordValid = true;
            break;
        }

        if ($passwordValid && $newPassword == $confirmPassword) {
            $personalInfoData = array(
                'firstname' => $this->postGet('fname'),
                'lastName' => $this->postGet('lname'),
                'phone' => $this->postGet('phone'),
            );

            $this->db->where('user_id', $userId);
            $personalInfoUpdate = $this->db->update('personal_info', $personalInfoData);

            if (!$personalInfoUpdate){
                return "An error found. Please try again later!";
            }

            $usersData = array(
                'email' => $this->postGet('email'),
            );

            if ($newPassword != '') {
                $usersData['password'] = md5($newPassword);
            }

            $this->db->where('id', $userId);
            $usersInfoUpdate = $this->db->update('users', $usersData);

            if (!$usersInfoUpdate){
                return "An error found. Please try again later!";
            }

        } else {
            return (!$passwordValid) ? 'Invalid Current Password' : "New Password doesn't match.";
        }

        return true;
    }

    function forgetPassword(){
        $email = $this->postGet('email');
        $userId = '';
        $emailData = array();

        $this->db->select("users.id, username, p.firstname, p.lastname");
        $this->db->join("personal_info p", "p.user_id = users.id", "left");
        $this->db->where('users.email', $email);
        $res = $this->db->get('users');

        foreach ($res->result() as $user) {
            $userId = $user->id;
            $emailData['name'] = $user->firstname . " " . $user->lastname;
            $emailData['username'] = $user->username;
            break;
        }

        if ($userId == '') {
            return false;
        }

        $newPassword = $this->randomPassword();
        $usersData['password'] = md5($newPassword);
        $emailData['password'] = $newPassword;

        $this->db->where('id', $userId);
        $usersInfoUpdate = $this->db->update('users', $usersData);

        if ($usersInfoUpdate){
            $this->sendEmail($email, 'IIT Loan Management',
                    "emailTemplate/loanApproved.php", $emailData);
            return true;
        } else {
            return 'An error occured. Please try again later.';
        }

    }
}