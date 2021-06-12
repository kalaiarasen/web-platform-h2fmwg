<?php


class BaseController
{
    static function toJson($data = [], $status = 200, $errorMessage = '', $statusMessage = 'Success!', $errors = [])
    {
        http_response_code($status);
        header('Content-Type: application/json');
        $response = [
            'data' => $data,
            'status' => $errorMessage ? 'Error Occurred!' : $statusMessage,
            'status_code' => $status,
        ];
        if ($errorMessage) {
            $response['error'] = $errorMessage;
            $response['errors'] = $errors;
        }
        echo json_encode($response);
        die();
    }
}
