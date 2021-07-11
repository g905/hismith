<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class NewsRequest extends Model {

    use HasFactory;

    protected $table = "news_requests";

}
