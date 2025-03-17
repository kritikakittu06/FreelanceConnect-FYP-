<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;

class ClientFreelancerProfileController extends Controller
{
    public function show($id)
    {
        $freelancer = User::query()->where('id', $id)
            ->where('role', UserRole::FREELANCER)
            ->with(['projects', 'freelanceProjects', 'reviews'])
            ->firstOrFail();

        return view('clientFreelancer.profile', compact('freelancer'));
    }
}
