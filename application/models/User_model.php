<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    protected $table = 'user';
    protected $pk = 'id_user';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all()
    {
        $this->db->order_by($this->pk, 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->pk => $id])->row_array();
    }

    public function get_by_username($username)
    {
        return $this->db->get_where($this->table, ['username' => $username])->row_array();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where($this->pk, $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where($this->pk, $id);
        return $this->db->delete($this->table);
    }

    public function is_username_exists($username, $exclude_id = null)
    {
        if ($exclude_id) {
            $this->db->where($this->pk . ' !=', $exclude_id);
        }
        $this->db->where('username', $username);
        return $this->db->get($this->table)->num_rows() > 0;
    }
}
