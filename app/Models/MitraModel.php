<?php

namespace App\Models;

use CodeIgniter\Model;

class MitraModel extends Model
{
    protected $table            = 'mitras';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\MitraEntity';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'address', 'user_id', 'verified', 'pic_name', 'pic_contact'];

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

    public function get_mitra()
    {
        return $this->db->table('mitras')
            ->select('mitras.*, users.email, users.username, COALESCE(SUM(CASE WHEN peminjamans.status = "done" THEN peminjamans.amount ELSE 0 END), 0) AS total_tubes_borrowed')
            ->join('users', 'users.id = mitras.user_id')
            ->join('peminjamans', 'peminjamans.mitra_id = mitras.id', 'LEFT')
            ->groupBy('mitras.id')
            ->get()
            ->getResult();
    }

    public function get_verified_mitra()
    {
        return $this->db->table('mitras')
            ->where('verified', 1)
            ->countAllResults();
    }


    public function get_mitra_by_id(int $id)
    {
        return $this->db->table('mitras')
            ->select('mitras.*, users.email, users.username')
            ->join('users', 'users.id = mitras.user_id')
            ->where(['mitras.id' => $id])
            ->get()
            ->getResult();
    }
    public function get_mitra_by_user_id(int $id)
    {
        $result = $this->db->table('mitras')
            ->select('mitras.*, users.email, users.username')
            ->join('users', 'users.id = mitras.user_id')
            ->where(['users.id' => $id])
            ->get()
            ->getRow();

        return $result;
    }
}
