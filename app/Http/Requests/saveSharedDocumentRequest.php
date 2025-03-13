<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class saveSharedDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:pdf',
            'document_id' => 'required|exists:documents,id',
            'employee_id' => 'required',
            'shared_document_id' => 'required|exists:shared_documents,id'
        ];
    }
}
