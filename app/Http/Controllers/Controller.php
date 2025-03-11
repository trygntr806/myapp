<?php

/**
 * Author: Tri Wicaksono
 * Website: https://triwicaksono.com
 */

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactService
{
    protected $apiUrl;

    /**
     * Initialize the ContactService with the API base URL from config.
     */
    public function __construct()
    {
        $this->apiUrl = config('services.contacts_api.base_uri');
    }

    /**
     * Retrieve all contacts from the API.
     *
     * @return array
     */
    public function getAllContacts()
    {
        $response = Http::get($this->apiUrl);

        if ($response->successful() && $response['code'] === 'SUCCESS' && is_array($response['data'])) {
            return $response['data'];
        }

        // Log detailed error information to stderr
        Log::channel('stderr')->error('Failed to get all contacts.', [
            'api_url' => $this->apiUrl,
            'status' => $response->status(),
            'body' => $response->body(),
            'response_data' => $response->json(),
        ]);

        return [];
    }

    /**
     * Retrieve a specific contact by ID from the API.
     *
     * @param  int  $id
     * @return array|null
     */
    public function getContactById($id)
    {
        $response = Http::get("{$this->apiUrl}/{$id}");

        if ($response->successful() && $response['code'] === 'SUCCESS' && is_array($response['data'])) {
            return $response['data'];
        }

        // Log detailed error information to stderr
        Log::channel('stderr')->error('Failed to get contact.', [
            'api_url' => $this->apiUrl,
            'status' => $response->status(),
            'body' => $response->body(),
            'response_data' => $response->json(),
        ]);

        return null;
    }

    /**
     * Create a new contact via the API.
     *
     * @param  array  $data
     * @return array|null
     */
    public function createContact(array $data)
    {
        $response = Http::post($this->apiUrl, $data);

        if ($response->successful() && $response['code'] === 'CREATED' && is_array($response['data'])) {
            return $response['data'];
        }

        // Log detailed error information to stderr
        Log::channel('stderr')->error('Failed to create contact.', [
            'api_url' => $this->apiUrl,
            'status' => $response->status(),
            'body' => $response->body(),
            'response_data' => $response->json(),
        ]);

        return null;
    }

    /**
     * Update an existing contact via the API.
     *
     * @param  int    $id
     * @param  array  $data
     * @return array|null
     */
    public function updateContact($id, array $data)
    {
        $response = Http::put("{$this->apiUrl}/{$id}", $data);

        if ($response->successful() && $response['code'] === 'SUCCESS' && is_array($response['data'])) {
            return $response['data'];
        }

        // Log detailed error information to stderr
        Log::channel('stderr')->error('Failed to update contact.', [
            'api_url' => $this->apiUrl,
            'status' => $response->status(),
            'body' => $response->body(),
            'response_data' => $response->json(),
        ]);

        return null;
    }

    /**
     * Delete a contact by ID via the API.
     *
     * @param  int  $id
     * @return string|null
     */
    public function deleteContact($id)
    {
        $response = Http::delete("{$this->apiUrl}/{$id}");

        if ($response->successful() && $response['code'] === 'SUCCESS') {
            return $response['code'];
        }

        // Log detailed error information to stderr
        Log::channel('stderr')->error('Failed to delete contact.', [
            'api_url' => $this->apiUrl,
            'status' => $response->status(),
            'body' => $response->body(),
            'response_data' => $response->json(),
        ]);

        return null;
    }
}