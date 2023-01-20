<?php

namespace App\Http\Controllers;

use App\Jobs\PoemJobs\Database\SearchPoem;
use Exception;

class SearchByTitlePoemController extends Controller
{
    public function get()
    {

        try {
            $this->validateRequest();
        } catch (Exception $exception) {
            return ['error' => true, 'message' => $exception->getMessage()];
        }
        return response()->json(SearchPoem::dispatchSync(request()->get('query')));
    }

    /**
     * @throws Exception
     */
    protected function validateRequest(): void
    {
        if (!request()->validate(['query' => 'required'])) {
            throw new Exception('Search Query is required');
        }
    }


}
