<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ImportUsersContract {
    public function setUserModel(Model $userModel):void;
    public function import(int $count = 5000, int $page = 1):array;
}