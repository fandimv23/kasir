<?php
class Penjualan_model extends CI_Model
{

    public function insert_penjualan($data)
    {
        $this->db->insert('penjualan', $data);
        return $this->db->insert_id();
    }

    public function insert_detail($data)
    {
        $this->db->insert('detailpenjualan', $data);
    }
}
