<?php

namespace App\Http\Controllers\superAdmin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Log;
use App\Models\sharedDocuments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SuperAdminController extends Controller
{



    public function index()
    {

        $auth_id = Auth::id();


        $total_companies = User::where('id', '!=', $auth_id)->count();
        $total_documents = Document::all()->count();
        $total_shared_documents = sharedDocuments::all()->count();
        $logs = Log::with('user', 'document')->orderBy('id', 'desc')->get();

        return Inertia::render('SuperAdmin/Dashboard', [
            'total_companies' => $total_companies,
            'total_documents' => $total_documents,
            'total_shared_documents' => $total_shared_documents,
            'logs' => $logs,
        ]);
    }



    public function getCompanies()
    {

        $companies = User::withCount(['employees', 'documents'])
            ->where('id', '!=', Auth::id())
            ->get();

        return Inertia::render('SuperAdmin/pages/Companies', [
            'companies' => $companies,
        ]);
    }
}
