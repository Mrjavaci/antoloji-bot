<?php

namespace App\Http\Controllers;

use App\Services\Database\GetPoemCountService;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Get Poem Count", version="0.1")*
 */
class GetPoemCountController extends Controller
{
    /**
     * @OA\Get(
     *      path="/count-of-poems",
     *      operationId="GetPoemCount",
     *      tags={"Antoloji"},
     *      summary="Get Poem Count",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *             @OA\Examples(example="result", value={"count":72359}, summary="An result object."),
     *         )
     *      )
     * )
     */
    function get()
    {
        return response()->json(['count' => GetPoemCountService::dispatchSync()]);
    }
}
