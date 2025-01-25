<?php defined('BASEPATH') or exit('No direct script access allowed');

class YourController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->library('form_validation');
        $this->load->library('session'); // Load session library for flashdata
    }

    // Load the registration view
    public function register() {
        $this->load->view('register');
    }

    // Handle the registration form submission
    public function register_submit() {
        // Set validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|is_unique[employee.employee_username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[employee.employee_email]');
        $this->form_validation->set_rules('firstname', 'Firstname', 'required|min_length[3]');
        $this->form_validation->set_rules('lastname', 'Lastname', 'required|min_length[2]');
        $this->form_validation->set_rules('phonenumber','Phonenumber','required|min_length[10]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, show error message using flashdata
            $this->session->set_flashdata('error', validation_errors());
            redirect('register'); // Redirect back to the registration page to show errors
        } else {
            // Validation passed, insert user into the database
            $data = array(
                'employee_username' => $this->input->post('username'),
                'employee_email' => $this->input->post('email'),
                'employee_firstname' => $this->input->post('firstname'),
                'employee_lastname' => $this->input->post('lastname'),
                'employee_telephone' => $this->input->post('phonenumber'),
                'employee_password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT), // Hash password
            );

            // Insert user into the database
            if ($this->UserModel->insert_user($data)) {
                // Registration successful, set flashdata success message
                $this->session->set_flashdata('message', 'Registration successful!');
                redirect('login');
            } else {
                // Registration failed, show a generic error
                $this->session->set_flashdata('error', 'There was a problem with registration. Please try again.');
                redirect('register');
            }
        }
    }

    // Load the login view (Optional)
    public function login() {
        $this->load->view('login');
    }

    // AJAX handler to check if email is already in use
    public function check_email() {
        $email = $this->input->post('email');

        if ($this->UserModel->is_email_taken($email)) {
            echo 'taken';  // Return 'taken' if the email is already registered
        } else {
            echo 'available';  // Return 'available' if the email is not found
        }
    }
}
