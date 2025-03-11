<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactService
{
    protected $apiUrl;

    /**
     * Inisialisasi ContactService dengan URL API.
     */
    public function __construct(string $apiUrl = null)
    {
        $this->apiUrl = $apiUrl ?: config('services.contacts_api.base_uri');
    
        // Debugging: Log API URL yang digunakan
        Log::info("ContactService initialized with API URL: " . ($this->apiUrl ?? 'NULL'));
    
        if (!$this->apiUrl) {
            Log::error('API URL is not set in ContactService.');
            throw new \Exception("API URL is not set. Check .env and config/services.php.");
        }
    }

    /**
     * Mengambil semua kontak dari API.
     *
     * @return array
     */
    public function getAllContacts()
    {
        try {
            $response = Http::timeout(10)->get($this->apiUrl);

            if ($response->successful() && isset($response['code']) && $response['code'] === 'SUCCESS' && is_array($response['data'])) {
                return $response['data'];
            }
        } catch (\Exception $e) {
            $this->logError('getAllContacts', [], $e);
        }

        return [];
    }

    /**
     * Mengambil kontak berdasarkan ID.
     *
     * @param  int  $id
     * @return array|null
     */
    public function getContactById($id)
    {
        try {
            $response = Http::timeout(10)->get("{$this->apiUrl}/{$id}");

            if ($response->successful() && isset($response['code']) && $response['code'] === 'SUCCESS' && is_array($response['data'])) {
                return $response['data'];
            }
        } catch (\Exception $e) {
            $this->logError('getContactById', ['id' => $id], $e);
        }

        return null;
    }

    /**
     * Membuat kontak baru melalui API.
     *
     * @param  array  $data
     * @return array|null
     */
    public function createContact(array $data)
    {
        try {
            $response = Http::timeout(10)->post($this->apiUrl, $data);

            if ($response->successful() && isset($response['code']) && $response['code'] === 'CREATED' && is_array($response['data'])) {
                return $response['data'];
            }
        } catch (\Exception $e) {
            $this->logError('createContact', $data, $e);
        }

        return null;
    }

    /**
     * Mengupdate kontak berdasarkan ID.
     *
     * @param  int    $id
     * @param  array  $data
     * @return array|null
     */
    public function updateContact($id, array $data)
    {
        try {
            $response = Http::timeout(10)->put("{$this->apiUrl}/{$id}", $data);

            if ($response->successful() && isset($response['code']) && $response['code'] === 'SUCCESS' && is_array($response['data'])) {
                return $response['data'];
            }
        } catch (\Exception $e) {
            $this->logError('updateContact', ['id' => $id, 'data' => $data], $e);
        }

        return null;
    }

    /**
     * Menghapus kontak berdasarkan ID.
     *
     * @param  int  $id
     * @return string|null
     */
    public function deleteContact($id)
    {
        try {
            $response = Http::timeout(10)->delete("{$this->apiUrl}/{$id}");

            if ($response->successful() && isset($response['code']) && $response['code'] === 'SUCCESS') {
                return $response['code'];
            }
        } catch (\Exception $e) {
            $this->logError('deleteContact', ['id' => $id], $e);
        }

        return null;
    }

    /**
     * Fungsi untuk logging error.
     *
     * @param string $method
     * @param array $data
     * @param \Exception $e
     */
    private function logError($method, array $data, \Exception $e)
    {
        Log::channel('stderr')->error("Exception in {$method}", [
            'data' => $data,
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
}
