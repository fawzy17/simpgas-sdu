<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table            = 'peminjamans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\PeminjamanEntity';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['loan_code', 'mitra_id', 'tabung_id', 'amount', 'approval', 'status'];

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

    public function get_peminjaman()
    {
        return $this->db->table('peminjamans')
            ->join('mitras', 'mitras.id = peminjamans.mitra_id')
            ->join('tabungs', 'tabungs.id = peminjamans.tabung_id')
            ->select('peminjamans.*, 
            mitras.name as mitra_name,
            tabungs.name as tabung_name,
            tabungs.id as tabung_id,
        ')->get()->getResult();
    }

    public function get_all_peminjaman_by_mitra()
    {
        return $this->db->table('peminjamans')
            ->select('peminjamans.mitra_id, peminjamans.tabung_id, mitras.name as mitra_name, tabungs.name as tabung_name, SUM(peminjamans.amount) as total_amount')
            ->join('mitras', 'mitras.id = peminjamans.mitra_id', 'LEFT')
            ->join('tabungs', 'tabungs.id = peminjamans.tabung_id', 'LEFT')
            ->where('peminjamans.status', 'done') // Hanya peminjaman yang telah di-approve
            ->groupBy('peminjamans.mitra_id, peminjamans.tabung_id')
            ->get()
            ->getResult();
    }

    public function get_total_borrowed()
    {
        return $this->db->table('peminjamans')
            ->where('status', 'done')
            ->selectSum('amount')
            ->get()
            ->getRow()
            ->amount;
    }

    public function get_peminjaman_per_month()
    {
        return $this->db->table('peminjamans')
            ->select("MONTHNAME(created_at) as month, YEAR(created_at) as year, SUM(amount) as total_amount")
            ->groupBy("YEAR(created_at), MONTH(created_at)")
            ->get()
            ->getResult();
    }

    public function get_month()
    {
        $query = $this->db->query("SELECT DISTINCT MONTHNAME(created_at) as month FROM peminjamans");
        $result = $query->getResult();

        $months = [];
        foreach ($result as $row) {
            // Konversi nama bulan ke format singkat (jan, feb, mar, dst.)
            $month = date('M', strtotime($row->month));
            $months[] = $month;
        }

        return $months;
    }
}
