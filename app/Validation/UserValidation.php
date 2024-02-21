<?php

namespace App\Validation;

use App\Models\UserModel;

class UserValidation
{
    public function admin_valid_email($value, ?string &$error = "Email is not contain in database"): bool
    {
        $userModel = new UserModel();
        $user = $userModel->where('email', $value)->first();
        if(!$user || $user->role_id != 2) {
            // $error = lang('myerrors.user_valid_email');
            return false;
        }
        return true;
    }

    public function collaborator_valid_email($value, ?string &$error = "Email is not contain in database"): bool
    {
        $userModel = new UserModel();
        $user = $userModel->where('email', $value)->first();
        if($value) {
            if(!$user || $user->role_id != 3) {
                // $error = lang('myerrors.user_valid_email');
                return false;
            }
            return true;
        }
        return true;
    }
}
