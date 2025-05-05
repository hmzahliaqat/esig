<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplacePdfRequest;
use App\Http\Requests\ShareDocumentRequest;
use App\Http\Requests\UploadDocumentRequest;
use App\Models\DocumentField;
use App\Models\sharedDocuments;
use App\Services\DocumentService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    protected $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }


    public function index()
    {
        $documents = Document::where('user_id', Auth::id())->get();

        return Inertia::render('Document/Document', [
            'documents' => $documents,
        ]);
    }


    public function upload(UploadDocumentRequest $request)
    {
        try {
            $document = $this->documentService->store(
                $request->file('file'),
                $request->title,
                Auth::id()
            );

            return response()->json($document, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function show($id, $employeeId = null)
    {
        $document = null;

        if($employeeId != 0){
           $shared_document = $this->documentService->getSharedDocument($id, $employeeId);
              if($shared_document === 404){
                abort(404);
              }

           $document = $shared_document['document'];
        }else{
            $document = Document::findOrFail($id);
        }

        return Inertia::render('Document/DocumentPreview', [
            'document' => $document,
            'employee_id' => $employeeId,
        ]);
    }

    public function edit($id, $employeeId = null)
    {
        $document = null;

        if($employeeId != 0){
           $shared_document = $this->documentService->getSharedDocument($id, $employeeId);
              if($shared_document === 404){
                abort(404);
              }

           $document = $shared_document['document'];
        }else{
            $document = Document::findOrFail($id);
        }

        return Inertia::render('Document/DocumentEdit', [
            'document' => $document,
            'employee_id' => $employeeId,
        ]);
    }


    public function share(ShareDocumentRequest $request)
    {
        try {
            $document = Document::findOrFail($request->id);

            $existingShare = SharedDocuments::where([
                'document_id' => $request->id,
                'employee_id' => $request->employee['id']
            ])->first();

            if ($existingShare && $existingShare->isExpired()) {
                $existingShare->delete();
            }

            $alreadyShared = sharedDocuments::where(['document_id' => $request->id, 'employee_id' => $request->employee['id']])
                ->first();

            if ($alreadyShared) {
                return response()->json(['message' => 'Document Already Shared'], 500);
            }

            $this->documentService->shareWithEmployee($request->id, $request->employee);

            return response()->json(['message' => 'Email sent successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function replacePdf(ReplacePdfRequest $request)
    {
        try {
            $this->documentService->replacePdf($request->file('file'), $request->input('filepath'));
            return response()->json(['message' => 'File replaced successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function saveSharedPdf(Request $request)
    {
        try {
            $signedDocument = $this->documentService->saveSignedDocument(
                $request->file('file'),
                $request->document_id,
                $request->employee_id,
            );

            return response()->json(['message' => 'Document saved successfully', 'document' => $signedDocument]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function track()
    {

        $users = sharedDocuments::with('user', 'document', 'employee')->get();

        $totalSharedDocumentCount = sharedDocuments::get()->count();
        $totalSignedDocumentCount = sharedDocuments::where('status', 1)->get()->count();
        $totalPendingDocumentCount = sharedDocuments::where('status', 0)->get()->count();

        return Inertia::render('Document/TrackDocument', [
            'users' => $users,
            'totalDocuments' => $totalSharedDocumentCount,
            'totalSignedDocuments' => $totalSignedDocumentCount,
            'totalPendingDocuments' => $totalPendingDocumentCount,
        ]);
    }

    public function remindEmail(Request $request)
    {

        $this->documentService->reminderEmail($request->id, $request->employee);

        return response()->json('reminder email sent');
    }


    public function delete(Request $request)
    {
        if ($request->has('ids')) {
            Document::whereIn('id', $request->ids)->delete();
            return response()->json('Documents deleted', 200);
        }

        $document =  Document::find($request->id);
        $document->delete();
        return response()->json('Document deleted', 200);
    }
}
