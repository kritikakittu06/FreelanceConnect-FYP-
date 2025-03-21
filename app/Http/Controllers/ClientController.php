<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostProject;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $freelancerId = Auth::id();

        $projects = PostProject::where('freelancer_id', $freelancerId)
            ->where('status', 'pending') // Only show unaccepted projects
            ->get();

        return view('clients.index', compact('projects'));
    }

    public function accept($id)
    {
        $project = PostProject::where('id', $id)
            ->where('freelancer_id', Auth::id())
            ->firstOrFail();

        $project->update(['status' => 'accepted']);

        return redirect()->route('freelancer.projects')->with('success', 'Project accepted successfully!');
    }

    public function reject($id)
    {
        $project = PostProject::where('id', $id)
            ->where('freelancer_id', Auth::id())
            ->firstOrFail();

        $project->update(['status' => 'rejected']);

        return redirect()->route('freelancer.projects')->with('error', 'Project rejected.');
    }


}
