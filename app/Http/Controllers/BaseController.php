<?php

namespace App\Http\Controllers;

class BaseController
{
    /**
     * Return a standard success json response
     *
     * @param string $message Optional message to include in the success reseponse
     *
     * @author Okiemute Omuta <iamkheme@gmail.com>
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse(string $message = null)
    {   
        $return['success'] = true;
        
        if ($message) {
            $return['message'] = $message;
        }

        return response()->json($return);
    }

    /**
     * Return a standard error json response
     *
     * @param string $message Optional message to include in the error reseponse
     *
     * @author Okiemute Omuta <iamkheme@gmail.com>
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(string $message = null, int $code = 400)
    {   
        $return['success'] = false;
        $return['message'] = $message;

        return response()->json($return, $code);
    }

    /**
     * Return a standard json response with mixed data
     *
     * @param mixed $data Data to include in JSON response
     * @param int   $code HTTP status code to include 
     *
     * @author Okiemute Omuta <iamkheme@gmail.com>
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse($data, int $code)
    {
        return response()->json($data, $code);
    }
}
