<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\JsonResponse;

class SponsorApiController extends Controller
{
    public function index(): JsonResponse
    {
        $sponsors = Sponsor::where('status', 'active')
            ->select('id', 'name', 'logo_path', 'website_url')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $sponsors,
        ]);
    }
}
