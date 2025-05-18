<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function get_by_email($email)
    {
        return $this->db->get_where('users', ['email' => $email])->row();
    }

    public function get_all()
    {
        return $this->db->get('users')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('users', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('users', ['id' => $id]);
    }


}

