<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class AdminDashboardController extends Controller
{
    public function __construct()
    {

    }

    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view("admin-dashboard");
    }
}
