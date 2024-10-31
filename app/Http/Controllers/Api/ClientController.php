<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        try {
            $clients = Client::all();
            if ($clients->isEmpty()) {
                return new ClientResource(false, 'No clients found', null);
            }
            return new ClientResource(true, 'List Data Clients', $clients);
        } catch (\Exception $e) {
            return new ClientResource(false, 'Failed to fetch clients', null);
        }
    }
}
