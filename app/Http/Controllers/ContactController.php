<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getIndex()
    {
        $data = Contact::latest()->get();
        return view('contact',compact('data'));
    }

    public function postStore(Request $request)
    {
        $newContact = new Contact;
        $newContact->name = $request->name;
        $newContact->email = $request->email;
        $newContact->phone = $request->phone;
        $newContact->save();
        return response()->json($newContact,200);
    }

    public function postEdit($id)
    {
         $contact = Contact::find($id);
         if ($contact){
             return response()->json($contact,200);
         }
         else{
             return response()->json('Data not found');
         }
    }

    public function postUpdate(Request $request,$id)
    {
        $contact = Contact::find(26);
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->save();
        return response()->json($contact,200);
    }
}
