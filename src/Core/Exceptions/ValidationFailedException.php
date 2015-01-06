<?php namespace Acme\Core\Exceptions;

use Illuminate\Support\MessageBag;

class ValidationFailedException extends \Exception {

    protected $errors;

    function __constrcut($message, MessageBag $errors)
    {
        $this->errors = $errors;
        parent::__construct($message);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}