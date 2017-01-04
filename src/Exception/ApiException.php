<?php
namespace kiczek\infakt\Exception;

use Exception;

class ApiException extends \Exception {
    public function __construct($errors, $code = 0, Exception $previous = null)
    {
        $message = "System fakturowania zwrócił błędy:";
        foreach($errors as $fieldName => $fieldErrors) {
            $message .= "\n";
            $i = 0;
            foreach($fieldErrors as $fieldError) {
                $message .= $fieldError . (count($fieldErrors)>($i+1) ? "\n" : "");
                $i++;
            }
        }

        parent::__construct($message, $code, $previous);
    }

}