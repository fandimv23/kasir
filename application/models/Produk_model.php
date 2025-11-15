<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk_model extends CI_Model
{
    private $table = 'produk';

    public function get_all()
    {
        return $this->db->get('produk')->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['ProdukID' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('ProdukID', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('ProdukID', $id);
        return $this->db->delete($this->table);
    }

    public function get_harga($produk_id)
    {
        // Ganti 'id_produk' dengan 'ProdukID'
        $produk = $this->db->get_where('produk', ['ProdukID' => $produk_id])->row_array();
        return $produk ? $produk['Harga'] : 0;
    }

    public function kurangi_stok($produk_id, $jumlah)
    {
        // Ganti 'id_produk' dengan 'ProdukID'
        $this->db->set('Stok', 'Stok - ' . (int)$jumlah, FALSE);
        $this->db->where('ProdukID', $produk_id);
        $this->db->update('produk');
    }
}
