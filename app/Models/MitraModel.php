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
    protected $allowedFields    = ['name', 'tubes_borrowed', 'address', 'user_id', 'verified'];

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

    public function get_mitra(){
        return $this->db->table('mitras')
        ->select('mitras.*, users.email, users.username')
        ->join('users', 'users.id = mitras.user_id')
        ->get()
        ->getResult();
    }

    public function get_mitra_by_id(int $id){
        return $this->db->table('mitras')
        ->select('mitras.*, users.email, users.username')
        ->join('users', 'users.id = mitras.user_id')
        ->where(['mitras.id' => $id])
        ->get()
        ->getResult();
    }
}
