<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_penjualan_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Ambil laporan penjualan, opsional filter tanggal
     * Mengembalikan array objek (result) sehingga view dapat mengakses ->TanggalPenjualan, ->NamaPelanggan, ->TotalHarga
     */
    public function getLaporan($tanggal_mulai = null, $tanggal_selesai = null)
    {
    // sertakan PelangganID agar view bisa memutuskan label (Umum atau nama member)
    $this->db->select('penjualan.PenjualanID, penjualan.TanggalPenjualan, penjualan.PelangganID, pelanggan.NamaPelanggan, penjualan.TotalHarga');
        $this->db->from('penjualan');
        $this->db->join('pelanggan', 'penjualan.PelangganID = pelanggan.PelangganID', 'left');

        if (!empty($tanggal_mulai)) {
            $this->db->where('TanggalPenjualan >=', $tanggal_mulai);
        }
        if (!empty($tanggal_selesai)) {
            $this->db->where('TanggalPenjualan <=', $tanggal_selesai);
        }

        $this->db->order_by('TanggalPenjualan', 'DESC');
        $this->db->order_by('penjualan.PenjualanID', 'DESC');
        return $this->db->get()->result();
    }

    public function getById($id)
    {
        $this->db->select('penjualan.*, pelanggan.NamaPelanggan');
        $this->db->from('penjualan');
        $this->db->join('pelanggan', 'penjualan.PelangganID = pelanggan.PelangganID', 'left');
        $this->db->where('penjualan.PenjualanID', $id);
        return $this->db->get()->row();
    }

    public function getDetails($penjualan_id)
    {
        $this->db->select('dp.*, p.NamaProduk, p.Harga');
        // ganti nama tabel menjadi detailpenjualan sesuai DB
        $this->db->from('detailpenjualan dp');
        $this->db->join('produk p', 'dp.ProdukID = p.ProdukID', 'left');
        $this->db->where('dp.PenjualanID', $penjualan_id);
        return $this->db->get()->result();
    }
}
