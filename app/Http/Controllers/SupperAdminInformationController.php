<?php

namespace App\Http\Controllers;

use App\Models\GoogleDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupperAdminInformationController extends Controller
{

   //DOCUMENTS FUNCTION
    public function docs_index()
    {
        $documents = GoogleDoc::latest()->get();
        return view('SupperAdmin_dashboard.information.documents', compact('documents'));
    }
    public function docs_store(Request $request)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'google_docs_link' => [
                'required',
                'url',
                'regex:/^https:\/\/docs\.google\.com\/document\/d\/[a-zA-Z0-9_-]+/'
            ]
        ]);

        GoogleDoc::create($request->all());

        return redirect()->route('docs_index')->with('success', 'Document link added successfully.');
    }
    public function docs_update(Request $request, $id)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'google_docs_link' => [
                'required',
                'url',
                'regex:/^https:\/\/docs\.google\.com\/document\/d\/[a-zA-Z0-9_-]+/'
            ]
        ]);

        $document = GoogleDoc::findOrFail($id);
        $document->update($request->all());

        return redirect()->route('docs_index')->with('success', 'Document link updated successfully.');
    }

    public function docs_destroy($id)
    {
        $document = GoogleDoc::findOrFail($id);
        $document->delete();

        return redirect()->route('docs_index')->with('success', 'Document link deleted successfully.');
    }
    
    //COMPONENTS FUNCTION 


}
