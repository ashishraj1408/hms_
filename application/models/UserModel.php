<?php defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_user($data) {
        $data['employee_password'] = password_hash($data['employee_password'], PASSWORD_BCRYPT);
        return $this->db->insert('employee', $data);
    }

    public function is_email_taken($email) {
        $this->db->where('employee_email', $email);
        $query = $this->db->get('employee');
        return $query->num_rows() > 0;
    }

    public function get_user_by_email_or_username($login_identifier) {
        $this->db->where('employee_email', $login_identifier);
        $this->db->or_where('employee_username', $login_identifier);
        $query = $this->db->get('employee');

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return false;
    }
}

