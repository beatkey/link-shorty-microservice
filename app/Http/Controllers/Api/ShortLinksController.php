<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShortLinksRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ShortLinksController extends Controller
{
    public function index(ShortLinksRequest $request){
        $client = new Client();

        $res = $client->post("https://api.tinyurl.com/create", [
            "query" => [
                "api_token" => env("TINYURL_API")
            ],
            "json" => [
                "url" => $request->url
            ]
        ]);

        if ($res->getStatusCode() !== 200) {
            return response()->json([
                "error" => "Remote server error: " . $res->getReasonPhrase(),
            ], 400);
        }

        $res = json_decode($res->getBody())->data;

        return response()->json([
            "url" => $request->url,
            "link" => $res->tiny_url
        ]);
    }
}
