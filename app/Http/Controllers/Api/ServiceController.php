<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\List_;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            $services = Service::all();
            if ($services->isEmpty()) {
                return new ServiceResource(false, 'No services found', null);
            }
            return new ServiceResource(true, 'List Data Services', $services);
        } catch (\Exception $e) {
            return new ServiceResource(false, 'Failed to fetch services', null);
        }
    }
}
