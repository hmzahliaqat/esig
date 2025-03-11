<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        $companyWithEmployees = User::with('employees')->first();
        $companyDocuments = Document::where('user_id' , 1)->get();
        return Inertia::render('Company/Layout/Layout', [
            'company' => $companyWithEmployees,
            'documents'=>$companyDocuments,
        ]);
    }
}
