<?php

namespace App\Http\Controllers;

use App\Jobs\PoemJobs\Database\GetPoemOfWriter;
use Exception;

class GetPoemOfWriterController extends Controller
{
    public function get()
    {

        try {
            $this->validateRequest();
        } catch (Exception $exception) {
            return ['error' => true, 'message' => $exception->getMessage()];
        }
        return response()->json(GetPoemOfWriter::dispatchSync(request()->get(request()->get('by')), request()->get('by')));
    }

    /**
     * @throws Exception
     */
    protected function validateRequest(): void
    {
        $checkBy = request()->validate(['by' => 'required']);
        if (!$checkBy) {
            throw new Exception('By is required');
        }
        if (request()->get('by') === 'writerId' && !request()->validate(['writerId' => 'required'])) {
            throw new Exception('Writer ID Is Required');
        }
        if (request()->get('by') === 'writerName' && !request()->validate(['writerName' => 'required'])) {
            throw new Exception('Writer Name Is Required');
        }
    }


}
