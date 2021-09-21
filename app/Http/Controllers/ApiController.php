<?php
/**
 * Name: APIController
 * Author: Victor Wang
 * Created: 24/05/2021
 * Last Updated: 24/05/2021
 * Description: This controller controls the API requests
 */
namespace App\Http\Controllers;

// Native packages
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

// Jobs
use App\Jobs\InsertPageVisit;

class ApiController extends Controller
{
    //=============================== Public Functions ===============================//
    /**
     * This function is responsible for receiving API calls to record page visit
     *
     * @param  Request $request, this is the post body to this call
     * @return Response, this function will always return a json response
     */
    public function recordPageVisit(Request $request)
    {
        $request->validate(
            [
                'pageName' => ['required', 'string', Rule::in(['products', 'contact'])],
                'ipAddress' => ['required', 'string', 'max:20', 'regex:/^[0-9.]+$/u'],
                'visitedAt' => ['required', 'date_format:d-m-Y H:i:s']
            ]
        );
        try {
            $insertJobStatus = InsertPageVisit::dispatchNow(
                $request->pageName,
                $request->ipAddress,
                $request->visitedAt
            );

            if ($insertJobStatus) {
                Log::info(
                    "Endpoint record-page-visit has been successfully called with body\n"
                    . json_encode($request->all())
                );
                return response()->json(['message' => 'The site visit record has been saved']);
            } else {
                return response()->json(['errors' => 'An internal error happened'], 500);
            }
        } catch (\Throwable $e) {
            Log::error(
                "[".$e->getCode().'] "'.$e->getMessage().'" on line '
                .$e->getTrace()[0]['line'].' of file '.$e->getFile() . " with input\n" . json_encode($request->all())
            );
            return response()->json(['errors' => 'An internal error happened'], 500);
        }
    }
}
