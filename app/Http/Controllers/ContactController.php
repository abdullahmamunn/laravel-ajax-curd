<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getIndex()
    {
        return view('contact',compact('data'));
    }

    public function getData()
    {
        $data = Contact::latest()->get();
        return response()->json($data,200);
    }

    public function postStore(Request $request)
    {
        $request->validate([
           'name' => 'required',
           'email' => 'required|unique:contacts',
           'phone' => 'required',
        ]);
        $newContact = new Contact;
        $newContact->name = $request->name;
        $newContact->email = $request->email;
        $newContact->phone = $request->phone;
        $newContact->save();
        return response()->json($newContact,200);
    }

    public function contactEdit($id)
    {
         $contact = Contact::find($id);
         if ($contact){
             return response()->json($contact,200);
         }
         else{
             return response()->json('Data not found');
         }
    }

    public function contactUpdate(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:contacts',
            'phone' => 'required',
        ]);

        $contact = Contact::findorFail($id);
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->save();
        return response()->json($contact,200);
    }

    public function contactDelete($id)
    {
        $delete_contact = Contact::destroy($id);
        return response()->json($delete_contact,200);
    }
}
