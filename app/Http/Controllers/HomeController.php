<?php

namespace App\Http\Controllers;

use App\Models\ImportUser;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index():\Inertia\Response
    {
        return Inertia::render('Welcome', [
            'totalUsers' => ImportUser::count()
        ]);
    }
}
