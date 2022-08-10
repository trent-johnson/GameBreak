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

        $collection = Cache::remember($username . '_collection',60*60*24, function () use ($username) {
            $response = Http::get('https://boardgamegeek.com/xmlapi2/collection?username=' . $username . '&subtype=boardgame&own=1');
            $xml = simplexml_load_string($response->getBody(), 'SimpleXMLElement', LIBXML_NOCDATA);
            $json = json_encode($xml);
            $array = json_decode($json, true);
            return collect($array);
        });
        //dd($collection);
        return view('collection.show', [
            'collection' => $collection,
            'username' => $username
        ]);
    }
}
