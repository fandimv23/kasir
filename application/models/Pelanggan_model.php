<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan_model extends CI_Model
{
    private $table = 'pelanggan';

    public function get_all()
    {
        return $this->db->get('pelanggan')->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['PelangganID' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('PelangganID', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('PelangganID', $id);
        return $this->db->delete($this->table);
    }
}
