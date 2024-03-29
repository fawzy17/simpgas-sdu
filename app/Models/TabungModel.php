<?php

namespace App\Models;

use CodeIgniter\Model;

class TabungModel extends Model
{
    protected $table            = 'tabungs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\TabungEntity';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'category_id', 'stock'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function get_tabung()
    {
        return $this->db->table('tabungs')
            ->join('categories', 'categories.id = tabungs.category_id')
            ->select('tabungs.*, categories.name as category_name, categories.massa as category_massa')
            ->orderBy('tabungs.id', 'ASC') // Mengurutkan berdasarkan id secara ascending
            ->get()
            ->getResult();
    }

    public function get_total_stock()
    {
        return $this->db->table('tabungs')
            ->selectSum('stock')
            ->get()
            ->getRow()->stock;
    }


    public function get_detail_tabung()
    {
        return $this->db->table('tabungs')
            ->join('peminjamans', 'tabungs.id = peminjamans.tabung_id', 'LEFT')
            ->join('categories', 'tabungs.category_id = categories.id', 'LEFT')
            ->select('tabungs.*, 
                   COALESCE(SUM(CASE WHEN peminjamans.status = \'done\' THEN peminjamans.amount ELSE 0 END), 0) AS total_borrowed,
                   categories.name as category_name, categories.massa as category_massa')
            ->groupBy('tabungs.id')
            ->get()
            ->getResult();
    }

    public function get_tabung_by_id($id)
    {
        return $this->db->table('tabungs')
            ->select('tabungs.*, COALESCE(SUM(peminjamans.amount), 0) AS total_borrowed')
            ->where('tabungs.id', $id) // Specify the table for the 'id' column
            ->join('peminjamans', 'tabungs.id = peminjamans.tabung_id', 'LEFT')
            ->groupBy('tabungs.id')
            ->get()
            ->getResult();
    }

    public function get_stock_tabung_ready()
    {
        return $this->db->query('SELECT tabungs.*, categories.name as category_name, categories.massa as category_massa,
        (tabungs.stock - COALESCE((SELECT SUM(amount) FROM peminjamans WHERE peminjamans.status = "done" AND peminjamans.tabung_id = tabungs.id), 0)) AS stock_ready 
        FROM tabungs
        LEFT JOIN categories ON categories.id = tabungs.category_id')
            ->getResult();
    }
}
