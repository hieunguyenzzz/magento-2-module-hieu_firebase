<?php

namespace Hieu\Firebase\Model\Exception;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;

class FirebaseAuthenticationFailException extends LocalizedException
{
    const MESSAGE = 'Authentication Fail';

    public function __construct(Phrase $phrase = null, \Exception $cause = null, int $code = 0)
    {
        if (empty($phrase)) {
            $phrase = new Phrase(self::MESSAGE);
        }
        parent::__construct($phrase, $cause, $code);
    }
}