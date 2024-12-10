<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AzureController extends Controller
{
    public function toggleStatus(Request $request)
    {
        $status = $request->input('is_active');
        DB::table('azures')->update(['is_active' => $status]);
        return response()->json(['message' => 'Status updated successfully']);
    }
}
