<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'App\Entities\UserEntity';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'password', 'email', 'role_id', 'avatar'];

    // Dates
    protected $useTimestamps = true;
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

    // Get User
    public function getUsers($id_user_login)
    {
        return $this->db->table('users')
        ->select('users.*, roles.name role_name')
        ->join('roles', 'roles_id = user.role_id')
        ->whereNotIn('users.id', [$id_user_login])
        ->orderBy('users.createdAt', 'DESC')
        ->get()->getResult();
    }

    public function getUserByEmail($email)
    {
        return $this->db->table('users')
        ->select('users.*')
        ->join('roles', 'roles_id = user.role_id')
        ->where('email', $email)
        ->get()->getResult();
    }
}
