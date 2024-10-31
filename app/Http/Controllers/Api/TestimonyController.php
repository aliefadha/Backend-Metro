<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonyResource;
use App\Models\Testimony;
use Illuminate\Http\Request;

class TestimonyController extends Controller
{
    public function index()
    {
        try {
            $testimonies = Testimony::all();
            if ($testimonies->isEmpty()) {
                return new TestimonyResource(false, 'No testimonies found', null);
            }
            return new TestimonyResource(true, 'List Data Testimonies', $testimonies);
        } catch (\Exception $e) {
            return new TestimonyResource(false, 'Failed to fetch testimonies', null);
        }
    }
}
