<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\LaptopRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function storeContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('contact.index')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', 'contact');
        }

        ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'new'
        ]);

        return redirect()->route('contact.index')
            ->with('success', 'Хабарламаңыз сәтті жіберілді! Біз сізге жауап береміз.')
            ->with('active_tab', 'contact');
    }

    public function storeLaptopRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_name' => 'required|string|max:100',
            'request_email' => 'required|email|max:100',
            'request_phone' => 'nullable|string|max:20',
            'budget' => 'nullable|numeric|min:0',
            'purpose' => 'required|string',
            'specifications' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('contact.index')
                ->withErrors($validator)
                ->withInput()
                ->with('active_tab', 'laptop');
        }

        LaptopRequest::create([
            'name' => $request->request_name,
            'email' => $request->request_email,
            'phone' => $request->request_phone,
            'budget' => $request->budget,
            'purpose' => $request->purpose,
            'specifications' => $request->specifications,
            'status' => 'new'
        ]);

        return redirect()->route('contact.index')
            ->with('success', 'Ноутбук сұранысыңыз сәтті жіберілді! Біз сізге жақын арада ұсыныспен хабарласамыз.')
            ->with('active_tab', 'laptop');
    }
}