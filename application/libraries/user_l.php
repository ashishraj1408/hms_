<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_l {

    public function __construct() {
        // You can initialize your library here if needed
    }

    public function login($user) {
        // Assuming $user is an object (not an array)
        $data = array(
            'uid' => $user->employee_id, // Accessing properties as an object
            'username' => $user->employee_username,
            'fullname' => $user->employee_firstname . " " . $user->employee_lastname,
            'department_name' => isset($user->department_name) ? $user->department_name : null // Check if department_name exists
        );

        $CI = &get_instance(); // Get the CodeIgniter instance
        $CI->session->set_userdata($data); // Set session data
    }

    public function logout() {
        $CI = &get_instance(); // Get the CodeIgniter instance
        $CI->session->sess_destroy(); // Destroy the session
    }
}
