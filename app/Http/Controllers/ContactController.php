<?php

/**
 * Author: Tri Wicaksono
 * Website: https://triwicaksono.com
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContactService;
use Illuminate\Routing\Controller;

class ContactController extends Controller
{
    protected $contactService;

    /**
     * Inject ContactService dependency.
     *
     * @param  ContactService  $contactService
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Display a listing of the contacts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all contacts using ContactService
        $contacts = $this->contactService->getAllContacts();
        
        // Return the view with contact data
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new contact.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Return the view for creating a contact
        return view('contacts.create');
    }

    /**
     * Store a newly created contact in the API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name'    => 'required|max:255',
            'email'   => 'required|email:rfc,dns',
            'phone'   => 'required|max:20',
            'message' => 'required|max:500',
        ]);

        // Create a new contact with validated data
        $contact = $this->contactService->createContact($validatedData);

        // Check if contact creation was successful
        if ($contact) {
            return redirect()->route('contacts.index')
                             ->with('success', 'Contact created successfully.');
        }

        // Redirect back with error if contact creation failed
        return back()->withErrors(['error' => 'Failed to create contact.'])->withInput();
    }

    /**
     * Display the specified contact.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        // Retrieve contact by ID
        $contact = $this->contactService->getContactById($id);

        // If contact exists, display it; otherwise, redirect with error
        if ($contact) {
            return view('contacts.show', compact('contact'));
        }

        return redirect()->route('contacts.index')
                         ->withErrors(['error' => 'Contact not found.']);
    }

    /**
     * Show the form for editing the specified contact.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        // Retrieve contact by ID for editing
        $contact = $this->contactService->getContactById($id);

        // If contact exists, show edit form; otherwise, redirect with error
        if ($contact) {
            return view('contacts.edit', compact('contact'));
        }

        return redirect()->route('contacts.index')
                         ->withErrors(['error' => 'Contact not found.']);
    }

    /**
     * Update the specified contact in the API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name'    => 'required|max:255',
            'email'   => 'required|email:rfc,dns',
            'phone'   => 'required|max:20',
            'message' => 'required|max:500',
        ]);

        // Update contact with validated data
        $contact = $this->contactService->updateContact($id, $validatedData);

        // Check if update was successful
        if ($contact) {
            return redirect()->route('contacts.index')
                             ->with('success', 'Contact updated successfully.');
        }

        // Redirect back with error if update failed
        return back()->withErrors(['error' => 'Failed to update contact.'])->withInput();
    }

    /**
     * Remove the specified contact from the API.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Attempt to delete contact by ID
        $success = $this->contactService->deleteContact($id);

        // Check if deletion was successful
        if ($success) {
            return redirect()->route('contacts.index')
                             ->with('success', 'Contact deleted successfully.');
        }

        // Redirect back with error if deletion failed
        return back()->withErrors(['error' => 'Failed to delete contact.']);
    }
}