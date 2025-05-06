<?php

namespace App\Http\Controllers\superAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SuperAdminController extends Controller
{



    public function index(){

        return Inertia::render('SuperAdmin/Dashboard');

    }



}
