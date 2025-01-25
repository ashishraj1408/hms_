<?php defined('BASEPATH') or exit('No direct script access allowed');

class RegisterController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function register() {
        $this->load->view('register');
    }

    public function register_submit() {
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|is_unique[employee.employee_username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[employee.employee_email]');
        $this->form_validation->set_rules('firstname', 'Firstname', 'required|min_length[3]');
        $this->form_validation->set_rules('lastname', 'Lastname', 'required|min_length[2]');
        $this->form_validation->set_rules('phonenumber', 'Phonenumber', 'required|min_length[10]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('register');
        } else {
            $data = array(
                'employee_username' => $this->input->post('username'),
                'employee_email' => $this->input->post('email'),
                'employee_firstname' => $this->input->post('firstname'),
                'employee_lastname' => $this->input->post('lastname'),
                'employee_telephone' => $this->input->post('phonenumber'),
                'employee_password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            );

            if ($this->UserModel->insert_user($data)) {
                $this->session->set_flashdata('message', 'Registration successful!');
                redirect('registersuccess');
            } else {
                $this->session->set_flashdata('error', 'There was a problem with registration. Please try again.');
                redirect('register');
            }
        }
    }

    public function registersuccess() {
        $this->load->view('registersuccess');
    }

    public function login() {
        $this->load->view('login');
    }

    public function check_email() {
        $email = $this->input->post('email');

        if ($this->UserModel->is_email_taken($email)) {
            echo 'taken';
        } else {
            echo 'available';
        }
    }
}


