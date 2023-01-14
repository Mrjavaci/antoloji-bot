<?php

namespace App\Http\Controllers;

use App\Services\Database\GetPoemCountService;

class GetPoemCountController extends Controller
{
    function get()
    {
        return response()->json(['count' => GetPoemCountService::dispatchSync()]);
    }
}
