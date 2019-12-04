<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function show(Request $request)
    {
        
        $data['error'] = '';
        $data['code'] = 200;
        $data['message'] = 'contact info@website.com';
        return response()->json($data);
        
    }

}
