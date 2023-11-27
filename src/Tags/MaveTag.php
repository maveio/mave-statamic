<?php

namespace StatamicMave\Tags;

use Statamic\Tags\Tags;
use Statamic\Fields\Value;
 
class MaveTag extends Tags
{
    protected static $handle = 'mave';

    public function wildcard($fieldName)
    {
        /**
         * @var Value $fieldValue
         */
        $fieldValue = array_get($this->context, $fieldName);

        if (!$fieldValue) {
            return null;
        }

        $rawValue = $fieldValue->raw();

        if (is_array($rawValue) && array_key_exists('body', $rawValue)) {
            return $this->renderSVG($rawValue);
        } else {
            return $rawValue;
        }
    }
}