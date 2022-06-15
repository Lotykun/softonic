<?php

namespace App\Object;


class ApiErrorResponse
{
    /**
     * Error code
     *
     * @var integer
     */
    private $code;

    /**
     * Error message
     *
     * @var string
     */
    private $message;


    public function __construct($code, $message = "")
    {
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
