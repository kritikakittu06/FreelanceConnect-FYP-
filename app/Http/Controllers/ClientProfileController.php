<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ClientProfileController extends Controller
{
    // Show the profile edit form
    public function edit()
    {
        $client = Auth::user();
        return view('clientDashboard.editprofile', compact('client'));
    }

    // Handle the profile update request
    public function update(Request $request)
    {
        $client = Auth::user();

        if (!$client instanceof User) {
            return back()->withErrors(['error' => 'User not found or not authenticated']);
        }

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'location' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Update user details
        $client->name = $request->name;
        $client->email = $request->email;
        $client->location = $request->location;

        // Handle the profile image update
        if ($request->hasFile('profile_image')) {
            // Delete the old image if it exists
            if ($client->profile_image) {
                Storage::disk('public')->delete($client->profile_image);
            }

            // Store the new image
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $client->profile_image = $imagePath;
        }

        // Save the changes
        $client->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }
}
