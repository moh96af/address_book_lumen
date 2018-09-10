<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'phone' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "error", "message" => $validator->errors()], 400);
        }

        $contact = new Contact;
        $contact->firstName = $request->input('firstName');
        $contact->lastName = $request->input('lastName');
        $contact->phone = $request->input('phone');
        $contact->email = $request->input('email');

        $contact->save();

        return response()->json(["status" => "success", "message" => "Created Successfully"]);

    }

    public function update($id, Request $request)
    {

        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json(["status" => "error", "message" => "Contact not found"]);
        }

        $contact->update($request->all());

        return response()->json(["status" => "success", "message" => "Updated Successfully"]);

    }

    public function delete($id)
    {

        $contact = Contact::find($id);

        if ($contact) {
            $contact->delete();

            return response()->json(["status" => "success", "message" => "Deleted Successfully"]);


        }
        return response()->json(["status" => "error", "message" => "Contact not found"]);

    }

    public function showAllContacts()
    {

        return response()->json(Contact::all());

    }

    public function showOneContact($id)
    {
        $contact = Contact::find($id);

        if ($contact) {

            return response()->json($contact);

        }
        return response()->json(["status" => "error", "message" => "Contact not found"]);

    }
}