<?php

class User_m extends CI_Model
{
    // Constructor to initialize the model
    function __construct()
    {
        // Call the Model constructor from the parent class
        parent::__construct();
    }

    // Function to check user login credentials
    public function check_login($username_or_email, $password)
    {
        // Use query to check if the input is either a username or an email
        $this->db->where("(employee_username = '$username_or_email' OR employee_email = '$username_or_email')");
        $this->db->where('employee_password', $password);

        $query = $this->db->get('employee'); // Check in the employee table

        if ($query->num_rows() == 1) {
            return $query->row(); // Return user data if a match is found
        } else {
            return false; // Return false if no match is found
        }
    }
}
