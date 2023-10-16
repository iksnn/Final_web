<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Mail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string',
            'mail' => 'required|email',
            'subject' => 'nullable|string',
            'comment' => 'required|string',
        ]);

        // Send the email
        FacadesMail::send('emails.contact', [
            'name' => $request->input('name'),
            'email' => $request->input('mail'),
            'subject' => $request->input('subject'),
            'message' => $request->input('comment'),
        ], function ($message) use ($request) {
            $message->from($request->input('mail'), $request->input('name'));
            $message->to('your@email.com'); // Replace with your email address
            $message->subject($request->input('subject', 'Contact Form Submission'));
        });

        // Optionally, you can add a success message or redirect back to the contact page.
        // You can also handle any errors that may occur during email sending.

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
