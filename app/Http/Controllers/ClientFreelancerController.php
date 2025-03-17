<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;

class ClientFreelancerController extends Controller
{
    public function index(Request $request)
    {
        // Start with all freelancers
        $query = User::query()
             ->withAvg('reviews', 'rating')
             ->withCount(['reviews'])
             ->where('role', UserRole::FREELANCER);

        if ($request->filled('skills')) {
            $query->where('skills', 'LIKE', '%' . $request->skills . '%');
        }

        if ($request->filled('experience')) {
            $query->where('experience', 'LIKE', '%'.$request->experience.'%');
        }

        if ($request->filled('budget')) {
            // If the budget is numeric (like 5000), compare it to numeric values
            if (is_numeric($request->budget)) {
                $query->where('project_budget', '=', (int) $request->budget);
            }
            // If the budget is "According to project demand", include those freelancers
            else{
                $query->where('project_budget', 'LIKE', '%'.$request->budget.'%');
            }
        }

        if ($request->filled('location')) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }
        $freelancers = $query->paginate(9);
        return view('clientFreelancer.index', compact('freelancers'));
    }
}
