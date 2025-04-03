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
        $document = Document::findOrFail($id);

        $field = $this->getFields($id)->getData(true);


        return Inertia::render('Document/DocumentPreview', [
            'document' => $document,
            'employee_id' => $employeeId,
            'fields'=>$field['fields'],
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
                return response()->json('Document Already Shared');
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

        return Inertia::render('Document/TrackDocument' , [
            'users' => $users,
            'totalDocuments' => $totalSharedDocumentCount,
            'totalSignedDocuments' => $totalSignedDocumentCount,
            'totalPendingDocuments' => $totalPendingDocumentCount,
        ]);
    }




    public function saveFields(Request $request, $id , $shared = null)
    {


        $documentId = $request->documentId;
        $document = Document::findOrFail($documentId);

        // Authorize the user can modify this document
        // $this->authorize('update', $document);

        $fields = $request->input('fields');

        // First, delete any existing fields for this document
        DocumentField::where('document_id', $documentId)->delete();

        // Then save the new fields
        $savedFields = [];
        foreach ($fields as $field) {
            $savedField = DocumentField::create([
                'document_id' => $documentId,
                'type' => $field['type'],
                'position_x' => $field['position']['x'],
                'position_y' => $field['position']['y'],
                'page' => $field['page'],
                'width' => $field['size']['width'],
                'height' => $field['size']['height'],
                'value' => $field['value'] ?? null, // Store the value if it exists
                'metadata' => json_encode($field), // Store any additional data
            ]);

            $savedFields[] = $savedField;
        }

        return response()->json([
            'success' => true,
            'message' => 'Document fields saved successfully',
            'document_id' => $documentId,
            'fields_count' => count($savedFields)
        ]);
    }



    public function getFields($documentId)
    {
        $document = Document::findOrFail($documentId);

        // Authorize the user can view this document
        // $this->authorize('view', $document);

        $documentFields = DocumentField::where('document_id', $documentId)->get();

        $fields = $documentFields->map(function ($field) {
            return [
                'type' => $field->type,
                'position' => [
                    'x' => $field->position_x,
                    'y' => $field->position_y
                ],
                'page' => $field->page,
                'size' => [
                    'width' => $field->width,
                    'height' => $field->height
                ],
                'value' => $field->value,
                // Include any additional metadata that was stored
                'metadata' => json_decode($field->metadata)
            ];
        });

        return response()->json([
            'document_id' => $documentId,
            'fields' => $fields
        ]);
    }


    // public function saveSignedPdf(Request $request, $documentId)
    // {
    //     $document = Document::findOrFail($documentId);

    //     // Authorize the user can modify this document
    //     $this->authorize('update', $document);

    //     // Validate the request
    //     $request->validate([
    //         'signed_pdf' => 'required|file|mimes:pdf'
    //     ]);

    //     // Get the file
    //     $signedPdf = $request->file('signed_pdf');

    //     // Generate a unique filename
    //     $filename = 'signed_' . uniqid() . '.pdf';

    //     // Store the file
    //     $path = $signedPdf->storeAs('signed_documents', $filename, 'public');

    //     // Update the document record
    //     $document->signed_pdf_path = $path;
    //     $document->status = 'signed';
    //     $document->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Signed document saved successfully',
    //         'document_id' => $documentId,
    //         'signed_pdf_path' => $path
    //     ]);
    // }











    public function delete(Request $request)
    {
        if ($request->has('ids')) {
            Document::whereIn('id', $request->ids)->delete();
            return response()->json('Documents deleted', 200);
        }

        $document =  Document::find($request->id);
        return response()->json('Document deleted', 200);
    }
}
