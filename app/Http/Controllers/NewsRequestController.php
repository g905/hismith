<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsRequest;
use Illuminate\Support\Facades\Http;

class NewsRequestController extends Controller {

    protected $nr;

    public function __construct($url) {
        $this->nr = new NewsRequest();
        $this->nr->url = $url;
        $this->nr->method = "get";
    }

    public function send() {
        if ($this->nr->method == "get") {
            $resp = Http::get($this->nr->url);
            $this->nr->response_code = $resp->status();
            $this->nr->response_body = $resp->body();
        }
        $this->nr->save();
        return $resp;
    }

}
