<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function interviewAssessment(Request $request)
    {
        $title = "Form Builder";

        if ($request->isMethod('post') && $request->ajax()) {
            $schema = $request->input('schema', []);
            if (is_string($schema)) {
                $schema = json_decode($schema, true);
            }
            
            // Render the preview form containing Blade components
            $html = view('includes.preview-form', ['schema' => $schema])->render();
            return response()->json(['html' => $html]);
        }

        return view('form', compact('title'));
    }
}
