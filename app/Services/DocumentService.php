<?php

namespace App\Services;

use App\Mail\ShareDocumentMail;
use App\Models\Document;
use App\Models\Employee;
use App\Models\sharedDocuments;
use App\Models\SignedDocuments;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use setasign\Fpdi\Tcpdf\Fpdi;

class DocumentService
{
    /**
     * Store a new document in the system
     */
    public function store(UploadedFile $file, ?string $title, int $userId): Document
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $path = $file->store('documents', 'public');

        $title = $title ?? pathinfo($originalName, PATHINFO_FILENAME);

        $pageCount = 1;
        $pdfPath = $path;

        if ($extension === 'pdf') {
            $pageCount = $this->getPdfPageCount($path);
        } elseif (in_array($extension, ['doc', 'docx'])) {
            $pdfPath = $this->convertWordToPdf($path);
            $pageCount = $this->getPdfPageCount($pdfPath, 'private');
        } elseif ($extension === 'txt') {
            $pdfPath = $this->convertTextToPdf($path);
            $pageCount = $this->getPdfPageCount($pdfPath, 'private');
        }

        return Document::create([
            'title' => $title,
            'file_path' => $path,
            'pdf_path' => $pdfPath,
            'page_count' => $pageCount,
            'file_type' => $extension,
            'user_id' => $userId
        ]);
    }

    /**
     * Replace a PDF file
     */
    public function replacePdf(UploadedFile $file, string $filepath): bool
    {
        $fileName = basename($filepath);
        $documentsPath = public_path('storage/documents');
        $existingFilePath = $documentsPath . DIRECTORY_SEPARATOR . $fileName;

        if (!file_exists($existingFilePath)) {
            throw new \Exception('File not found.');
        }

        unlink($existingFilePath);
        $file->move($documentsPath, $fileName);

        return true;
    }

    /**
     * Get PDF page count
     */
    private function getPdfPageCount(string $path, string $disk = 'public'): int
    {
        $pdf = new Fpdi();
        return $pdf->setSourceFile(storage_path("app/{$disk}/" . $path));
    }





    public function shareWithEmployee(int $documentId, array $employee): sharedDocuments
    {
        $sharedDocument = sharedDocuments::create([
            'user_id' => $employee['user_id'],
            'document_id' => $documentId,
            'employee_id' => $employee['id'],
            'access_hash' => hash('sha256', Str::random(40) . time() . config('app.key')),
            'status' => 0,
        ]);

        Mail::to($employee['email'])->send(new ShareDocumentMail($documentId, $employee['id'], 'mail'));

        return $sharedDocument;
    }


    public function reminderEmail(int $documentId, array $employee){

        Mail::to($employee['email'])->send(new ShareDocumentMail($documentId, $employee['id'], 'reminder'));

    }



    /**
     * Save a signed PDF document
     */
    public function saveSignedDocument(UploadedFile $file, int $documentId, int $employeeId)
    {
        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $storagePath = 'documents/signed';
        $path = $file->storeAs($storagePath, $fileName, 'public');

        $SharedDocument = sharedDocuments::where(['document_id'=>$documentId, 'employee_id'=>$employeeId])->first();

        if(!$SharedDocument){
           return response()->json('Document not found', 404);
        }

        $SharedDocument->file_path = $path;
        $SharedDocument->pdf_path = $path;
        $SharedDocument->status = 1;
        $SharedDocument->signed_at= now();
        $SharedDocument->save();
    }














    /**
     * Convert Word document to PDF
     */
    private function convertWordToPdf(string $wordPath): string
    {
        $phpWord = \PhpOffice\PhpWord\IOFactory::load(storage_path('app/' . $wordPath));
        $pdfWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');

        $pdfPath = 'documents/' . basename($wordPath, '.' . pathinfo($wordPath, PATHINFO_EXTENSION)) . '.pdf';
        $pdfWriter->save(storage_path('app/private/' . $pdfPath));

        return $pdfPath;
    }

    /**
     * Convert text file to PDF
     */
    private function convertTextToPdf(string $textPath): string
    {
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle(basename($textPath));
        $pdf->SetHeaderData('', 0, basename($textPath), '');
        $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->AddPage();

        $textContent = file_get_contents(storage_path('app/' . $textPath));
        $pdf->writeHTML(nl2br(htmlspecialchars($textContent)), true, false, true, false, '');

        $pdfPath = 'documents/' . basename($textPath, '.txt') . '.pdf';
        $pdf->Output(storage_path('app/private/' . $pdfPath), 'F');

        return $pdfPath;
    }
}