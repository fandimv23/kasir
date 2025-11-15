<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    // total nilai penjualan hari ini
    public function get_total_penjualan_hari_ini()
    {
        $tanggal = date('Y-m-d');
        $this->db->select_sum('TotalHarga');
        $this->db->where('TanggalPenjualan', $tanggal);
        $query = $this->db->get('penjualan')->row();
        return $query ? $query->TotalHarga : 0;
    }

    // jumlah transaksi hari ini
    public function get_jumlah_transaksi_hari_ini()
    {
        $tanggal = date('Y-m-d');
        $this->db->where('TanggalPenjualan', $tanggal);
        return $this->db->count_all_results('penjualan');
    }

    // jumlah barang aktif
    public function get_jumlah_barang_aktif()
    {
        $this->db->from('produk');
        $this->db->where('Stok >', 0);
        return $this->db->count_all_results();
    }

    // jumlah pelanggan
    public function get_jumlah_pelanggan()
    {
        return $this->db->count_all_results('pelanggan');
    }

    // produk dengan stok = 0 (tidak aktif)
    public function get_produk_tidak_aktif()
    {
        $this->db->select('ProdukID, NamaProduk, Harga, Stok');
        $this->db->from('produk');
        $this->db->where('Stok', 0);
        $this->db->order_by('NamaProduk', 'ASC');
        return $this->db->get()->result_array();
    }

    // produk dengan stok > 0 (aktif)
    public function get_produk_aktif()
    {
        $this->db->select('ProdukID, NamaProduk, Harga, Stok');
        $this->db->from('produk');
        $this->db->where('Stok >', 0);
        $this->db->order_by('NamaProduk', 'ASC');
        return $this->db->get()->result_array();
    }
}
