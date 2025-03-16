<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ClientFreelancerController extends Controller
{
    public function index(Request $request)
    {
        // Start with all freelancers
        $query = User::query()->where('role', 'freelancer');
//            ->has('reviews') // Only freelancers with reviews
//            ->with(['reviews' => function ($query) {
//                $query->whereNotNull('review')->where('review', '!=', '');
//            }, 'reviews.client']);


        // Apply filters based on search input
        if ($request->filled('skills')) {
            $query->where('skills', 'LIKE', '%' . $request->skills . '%');
        }

        if ($request->filled('experience')) {
            $query->where('experience', '>=', $request->experience);
        }

        if ($request->filled('budget')) {
            // If the budget is numeric (like 5000), compare it to numeric values
            if (is_numeric($request->budget)) {
                $query->where('project_budget', '=', (int) $request->budget);
            }
            // If the budget is "According to project demand", include those freelancers
            elseif (strtolower($request->budget) === 'according to project demand') {
                $query->where('project_budget', 'LIKE', '%According to project demand%');
            }
        }



        if ($request->filled('location')) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }

        // Fetch freelancers with pagination
        $freelancers = $query->paginate(12);

        return view('clientFreelancer.index', compact('freelancers'));
    }
}
