<?php

namespace App\Http\Controllers;


use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ContactController extends Controller
{
    public function sendMessage(ContactRequest $request)
    {
        $contact = new Contact([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ]);
        $contact->save();
        return response()->json(['message' => 'Contact request has been successfully submitted.'], 200);
    }
}
