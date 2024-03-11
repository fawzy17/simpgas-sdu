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
    protected $allowedFields    = ['name', 'category', 'size', 'weight', 'stock'];

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
            ->select('tabungs.*, COALESCE(SUM(peminjamans.amount), 0) AS total_borrowed')
            ->join('peminjamans', 'tabungs.id = peminjamans.tabung_id', 'LEFT')
            ->groupBy('tabungs.id')
            ->get()
            ->getResult();
    }
}
