<?php

namespace App\Http\Controllers;

use App\Jobs\PoemJobs\Database\GetRandomPoemJob;

class GetRandomPoemController extends Controller
{
    public function get()
    {
        return response()->json(GetRandomPoemJob::dispatchSync());
    }
}
