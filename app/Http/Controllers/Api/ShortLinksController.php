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

        // if not set provider param, tinyurl will use as default
        switch ($request->provider) {
            case "bit.ly":
                $res = $client->post("https://api-ssl.bitly.com/v4/shorten", [
                    "headers" => [
                        "Authorization" => "Bearer " . env("BITLY_API"),
                        "Content-Type" => "application/json"
                    ],
                    "json" => [
                        "long_url" => $request->url
                    ]
                ]);

                if ($res->getStatusCode() !== 200 and $res->getStatusCode() !== 201) {
                    return response()->json([
                        "error" => "Remote server error: " . $res->getReasonPhrase(),
                    ], 400);
                }

                $link = json_decode($res->getBody())->link;
                break;
            default:
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

                $link = json_decode($res->getBody())->data->tiny_url;
                break;
        }

        return response()->json([
            "url" => $request->url,
            "link" => $link
        ]);
    }
}
