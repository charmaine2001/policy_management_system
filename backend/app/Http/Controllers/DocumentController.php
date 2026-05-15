<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function store(Request $request, Policy $policy)
    {
        $request->validate([
            'document' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $file = $request->file('document');
        $path = $file->store('documents/' . $policy->id, 'public');

        Document::create([
            'policy_id' => $policy->id,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }

    public function destroy(Document $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }
}
