<?php

namespace App\Http\Controllers;

use App\Models\GameCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CollectionController extends Controller
{
    public function show(Request $request, $username) {
        return view('collection.show', [
            'username' => $username
        ]);
    }
}
