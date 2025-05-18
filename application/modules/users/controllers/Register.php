<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller {

    var $data;

    public function __construct() {
        parent::__construct();
        $this->data         = array(
            'page_content'  => FALSE
        );
        $this->load->model('users/User_model');
    }

    public function index() {
        $this->data['meta_keywords']    = '';
        $this->data['meta_description'] = '';
        $this->data['meta_title']       = 'Register';
        $this->data['template']         = 'home';

        $this->data['site_name']        = config_item('site_name');
        $this->data['css']              = config_item('css');
        $this->data['js']               = config_item('js');

        $page = 'register';

        if ( ! file_exists('application/modules/users/views/'.$page.'.php') )
        {
            // Whoops, we don't have a page for that!
            return show_404();
        }

        $this->data['menu'] = config_item('menu');
        $this->data['page_name'] = $page;

        $this->data['page_content'] = $this->load->view($page, $this->data, TRUE);
        $this->load->view('template', $this->data);
    }

    public function create_password($user_id) {
        $this->data['meta_keywords']    = '';
        $this->data['meta_description'] = '';
        $this->data['meta_title']       = 'Create Password';
        $this->data['template']         = 'home';

        $this->data['site_name']        = config_item('site_name');
        $this->data['css']              = config_item('css');
        $this->data['js']               = config_item('js');

        $user = $this->User_model->get($user_id);
        if (!$user) {
            show_404();
        }

        if ($_POST) {
            $password = $this->input->post('password', true);

            // Basic validation (customize as needed)
            if (strlen($password) < 6) {
                $this->data['error'] = 'Password must be at least 6 characters.';
            } else {
                $hashed = password_hash($password, PASSWORD_BCRYPT);
                $this->User_model->update($user_id, ['password_hash' => $hashed]);

                $this->session->set_flashdata('success', 'Your registration has been successful.');
                redirect('/log-in');
            }
        }

        $page = 'create_password';
        if ( ! file_exists('application/modules/users/views/'.$page.'.php') )
        {
            // Whoops, we don't have a page for that!
            return show_404();
        }

        $this->data['menu'] = config_item('menu');
        $this->data['page_name'] = $page;

        $this->data['page_content'] = $this->load->view($page, $this->data, TRUE);
        $this->load->view('template', $this->data);

    }
}
