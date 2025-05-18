<?php

class Users extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('users/User_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function register() {
        if ($_POST) {
            $name  = $this->input->post('name', true);
            $email = $this->input->post('email', true);
            $phone = $this->input->post('phone', true);

            // Save user without password for now
            $user_id = $this->User_model->create([
                'name'     => $name,
                'email'    => $email,
                'phone'    => $phone,
                'password_hash' => null // will be set later
            ]);

            if ($user_id) {
                redirect("register/create_password/$user_id");
            } else {
                $data['error'] = 'Registration failed. Try again.';
            }
        }

        $this->load->view('template', [
            'page' => 'users/register',
        ]);
    }
}
