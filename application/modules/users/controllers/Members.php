<?php
class Members extends MY_Controller
{
    var $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('users/User_model');
        $this->load->library('session');
        $this->load->helper('url');

        // Protect the page
        if (!$this->session->userdata('logged_in')) {
            redirect('/log-in');
        }
    }

    public function index()
    {
        $this->data['users'] = $this->User_model->get_all();
        $this->data['meta_keywords']    = '';
        $this->data['meta_description'] = '';
        $this->data['meta_title']       = 'Members';
        $this->data['template']         = 'home';

        $this->data['site_name']        = config_item('site_name');
        $this->data['css']              = config_item('css');
        $this->data['js']               = config_item('js');

        $page = 'members';

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

    public function edit($id)
    {
        $user = $this->User_model->get_by_id($id);
        if (!$user) {
            return show_404();
        }

        $this->data['meta_keywords']    = '';
        $this->data['meta_description'] = '';
        $this->data['meta_title']       = 'Edit Member';
        $this->data['template']         = 'home';

        $this->data['site_name']        = config_item('site_name');
        $this->data['css']              = config_item('css');
        $this->data['js']               = config_item('js');

        $page = 'edit_user';

        if ( ! file_exists('application/modules/users/views/'.$page.'.php') )
        {
            // Whoops, we don't have a page for that!
            return show_404();
        }

        $this->data['menu'] = config_item('menu');
        $this->data['page_name'] = $page;

        if ($this->input->post()) {
            $updateData = [
                'name'  => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
            ];

            $this->User_model->update($id, $updateData);
            $this->session->set_flashdata('success', 'Member successfully updated.');
            redirect('/members');
        }

        $this->data['user'] = $user;
        $this->data['page_content'] = $this->load->view($page, $this->data, TRUE);
        $this->load->view('template', $this->data);
    }

    public function delete($id)
    {
        $this->User_model->delete($id);
        $this->session->set_flashdata('success', 'Member successfully deleted.');
        redirect('/members');
    }

    public function reset_password($id)
    {
        $this->data['meta_keywords']    = '';
        $this->data['meta_description'] = '';
        $this->data['meta_title']       = 'Reset Password';
        $this->data['template']         = 'home';

        $this->data['site_name']        = config_item('site_name');
        $this->data['css']              = config_item('css');
        $this->data['js']               = config_item('js');

        $page = 'reset_password';

        if ( ! file_exists('application/modules/users/views/'.$page.'.php') )
        {
            // Whoops, we don't have a page for that!
            return show_404();
        }

        $this->data['menu'] = config_item('menu');
        $this->data['page_name'] = $page;
        $user = $this->User_model->get($id);
        if (!$user) {
            show_404();
        }

        $this->data['user'] = $user;
        $this->data['page_content'] = $this->load->view($page, $this->data, TRUE);
        $this->load->view('template', $this->data);
    }

    public function process_reset_password($id)
    {
        $password = $this->input->post('password');
        $password_confirm = $this->input->post('password_confirm');

        if ($password !== $password_confirm) {
            $this->session->set_flashdata('error', 'Passwords do not match.');
            redirect('members/reset-password/' . $id);
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $this->User_model->update($id, ['password_hash' => $hashed]);

        $this->session->set_flashdata('success', 'Password successfully updated.');
        redirect('members');
    }

}
