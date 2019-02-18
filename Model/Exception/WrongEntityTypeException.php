<?php
/**
 * Created by PhpStorm.
 * User: hieunguyen
 * Date: 2/17/19
 * Time: 11:19 AM
 */

namespace Hieu\Firebase\Model\Exception;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;

class WrongEntityTypeException extends LocalizedException
{
    const MESSAGE = 'Wrong type of item';

    public function __construct(Phrase $phrase = null, \Exception $cause = null, int $code = 0)
    {
        if (empty($phrase)) {
            $phrase = new Phrase(self::MESSAGE);
        }
        parent::__construct($phrase, $cause, $code);
    }
}