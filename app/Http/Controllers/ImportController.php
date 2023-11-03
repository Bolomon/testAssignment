<?php

namespace App\Http\Controllers;

use App\Models\ImportUser;
use Illuminate\Http\Request;
use App\Contracts\ImportUsersContract;

class ImportController extends Controller
{
    public function import(ImportUsersContract $importUsersContract)
    {
        $importUsersContract->setUserModel(app(ImportUser::class));
        $importData = $importUsersContract->import(5000);
        return response()->json($importData);
    }
}
