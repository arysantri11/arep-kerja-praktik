<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $usersProfile_default = '';

    public function randomFileName($ekstension)
    {
        return time() . rand(100, 10000) . '.' . $ekstension;
    }

    // USERS
    // Profile
    public function usersProfile_pathFolder()
    {
        return public_path() . '/img/users/profile';
    }

    public function usersProfile_pathFile($namaFile)
    {
        return $this->usersProfile_pathFolder() . '/' . $namaFile;
    }

    // CALEG
    // Foto
    public function calegFoto_pathFolder()
    {
        return public_path() . '/img/caleg/foto';
    }

    public function calegFoto_pathFile($namaFile)
    {
        return $this->calegFoto_pathFolder() . '/' . $namaFile;
    }
}
