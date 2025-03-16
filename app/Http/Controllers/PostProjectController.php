<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostProject;

class PostProjectController extends Controller
{
    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'freelancer_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:1',
            'deadline' => 'required|date|after:today',
        ]);

        PostProject::create([
            'freelancer_id' => $request->freelancer_id,
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $request->budget,
            'deadline' => $request->deadline,
        ]);

        return response()->json(['success' => true, 'message' => 'Project posted successfully!']);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['success' => false, 'errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Something went wrong!'], 500);
    }
}

}
