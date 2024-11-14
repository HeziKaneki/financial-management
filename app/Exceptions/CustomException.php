<?php
namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = "Đã xảy ra lỗi tùy chỉnh", $code = 400)
    {
        parent::__construct($message, $code);
    }

    public function render($request)
    {
        return response()->json(['error' => $this->message], $this->code);
    }
}
