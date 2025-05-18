<?php
class Login extends MY_Controller
{
    var $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('users/User_model');
        $this->load->library('session');
        $this->load->helper(['form', 'url']);
    }

    public function index()
    {
        $this->data['error'] = $this->session->flashdata('error');
        $this->data['meta_keywords']    = '';
        $this->data['meta_description'] = '';
        $this->data['meta_title']       = 'Login';
        $this->data['template']         = 'home';

        $this->data['site_name']        = config_item('site_name');
        $this->data['css']              = config_item('css');
        $this->data['js']               = config_item('js');

        $page = 'login';

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

    public function authenticate()
    {
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);

        $user = $this->User_model->get_by_email($email);

        if ($user && password_verify($password, $user->password_hash)) {
            $this->session->set_userdata([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'logged_in' => true
            ]);

            redirect('/members');
        } else {
            $this->session->set_flashdata('error', 'Invalid login credentials');
            redirect('/log-in');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
}
