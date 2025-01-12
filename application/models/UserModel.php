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
        $email = $this->postGet('email');
        $password = $this->postGet('password');

        $this->db->select("u.*, p.firstname, p.lastname");
        $this->db->where('email', $email);
        $this->db->where('password', md5($password));
        $this->db->join('nk_personal_info p', 'p.user_id = u.id', 'left');
        $res = $this->db->get('nk_users u');

        foreach ($res->result() as $user) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $user->firstname . " " . $user->lastname;
            $_SESSION['user_id'] = $user->id;
            return true;
        }
        return false;
    }

    function getUserData($userId) {
        $data = array();
        $this->db->select('p.firstname, p.lastname, nk_users.email');
        $this->db->from("nk_users");
        $this->db->join("nk_personal_info p", "p.user_id = nk_users.id", "left");
        $this->db->where('nk_users.id', $userId);
        $res = $this->db->get();

        foreach ($res->result() as $row){
            $data = array(
                'firstname' => $row->firstname,
                'lastname' => $row->lastname,
                'email' => $row->email,
            );

            break;
        }

        return $data;
    }

    function updateProfile($userId){
        $newPassword = $this->postGet('newPassword');
        $confirmedPassword = $this->postGet('confirmedPassword');
        $password = $this->postGet('currentPassword');
        $passwordValid = false;

        $this->db->where('id', $userId);
        $this->db->where('password', md5($password));
        $res = $this->db->get('nk_users');

        foreach ($res->result() as $user) {
            $passwordValid = true;
            break;
        }

        if ($passwordValid && $newPassword == $confirmedPassword) {
            $personalInfoData = array(
                'firstname' => $this->postGet('fname'),
                'lastName' => $this->postGet('lname'),
            );

            $this->db->where('user_id', $userId);
            $personalInfoUpdate = $this->db->update('nk_personal_info', $personalInfoData);

            if (!$personalInfoUpdate){
                return "An error found. Please try again later!";
            }

            if ($newPassword != '') {
                $usersData['password'] = md5($newPassword);

                $this->db->where('id', $userId);
                $usersInfoUpdate = $this->db->update('nk_users', $usersData);

                if (!$usersInfoUpdate){
                    return "An error found. Please try again later!";
                }
            }
        } else {
            return (!$passwordValid) ? 'Invalid Current Password' : "New passwords do not match!";
        }

        return true;
    }
}