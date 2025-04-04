<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;


class ContactController extends Controller
{
    public function index()
    {
        return view('ClientsContact.contact');
    }
    public function submit(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Save the contact form submission to the database
Contact::create($validatedData);

        // Process the contact form submission
        Mail::send([], [], function ($message) use ($validatedData) {
            $message->to('kritikac206@gmail.com')
                    ->subject('New Contact Form Submission')
                    ->setBody(new \Symfony\Component\Mime\Part\TextPart('Contact Form Submission<p>Name: ' . $validatedData['name'] . '</p><p>Email: ' . $validatedData['email'] . '</p><p>Message: ' . $validatedData['message'] . '</p>', 'text/html'));
        });

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}