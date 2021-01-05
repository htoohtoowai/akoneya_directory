<?php
namespace App\Repositories;

class ResponseRepository
{
    public function __construct()
    {
        $this->createStatusCode = config('http_status.created');
        $this->successStatusCode = config('http_status.success');
        $this->badRequestStatusCode = config('http_status.badRequest');
        $this->notFoundStatusCode = config('http_status.badRequest');
        $this->unauthorizedStatusCode = config('http_status.unauthorized');

        $this->successMsg = config('message.successMsg');
        $this->notFoundMsg = config('message.notFoundMsg');
        $this->unauthorisedMsg = config('message.notFoundMsg');
    }

    public function jsonResponse($data, $statusCode, $message)
    {
        return response()->json([
            'result' => $data,
            'statusCode' => $statusCode,
            'message'=> $message
        ], $statusCode);
    }

    public function successResponse($data, $successStatusCode, $message)
    {
        return $this->jsonResponse($data, $successStatusCode, $message);
    }

    public function failResponse($data, $failStatusCode, $message)
    {
        return $this->jsonResponse($data, $failStatusCode, $message);
    }
}
