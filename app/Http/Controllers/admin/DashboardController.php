<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Employee;
use App\Models\sharedDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{


    public function index()
    {

        $total_documents = Document::where('user_id', Auth::id())->count();
        $total_employees = Employee::where('user_id', Auth::id())->count();
        $pending_signatures = sharedDocuments::where(['user_id' => Auth::id(), 'status' => 0])->count();
        $completed_signatures = sharedDocuments::where(['user_id' => Auth::id(), 'status' => 1])->count();
        $documents_shared = sharedDocuments::where(['user_id' => Auth::id()])->count();

        $recent_documents = Document::with('user')->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return Inertia::render('Dashboard', [
            'total_documents' => $total_documents,
            'total_employees' => $total_employees,
            'pending_signatures' => $pending_signatures,
            'completed_signatures' => $completed_signatures,
            'documents_shared' => $documents_shared,
            'recent_documents' => $recent_documents,
        ]);
    }
}
