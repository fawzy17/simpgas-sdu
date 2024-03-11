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
    protected $allowedFields    = ['loan_code', 'mitra_id', 'tabung_id', 'amount', 'approval'];

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
            tabungs.category as tabung_category,
            tabungs.size as tabung_size,
            tabungs.weight as tabung_weight,
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
}
