<?php

namespace StatamicMave\Fieldtypes;

use Statamic\Fields\Fieldtype;

use Firebase\JWT\JWT;

class MaveFieldtype extends Fieldtype
{
    public function preload() 
    {
        $key = env("MAVE_KEY"); // mave.io API key
        $payload = array(
            "sub" => env("MAVE_SUB"), // mave.io collection id
            "exp" => time() + 3600, // Current epoch plus 3600 seconds
        );

        $jwt = JWT::encode($payload, $key, 'HS256');

        return [
            'maveApi' => $jwt,
            'maveTheme' => env("MAVE_THEME"),
        ];
    }

    /**
     * The blank/default value.
     *
     * @return array
     */
    public function defaultValue()
    {
        return null;
    }

    /**
     * Pre-process the data before it gets sent to the publish page.
     *
     * @param mixed $data
     * @return array|mixed
     */
    public function preProcess($data)
    {
        return $data;
    }

    /**
     * Process the data before it gets saved.
     *
     * @param mixed $data
     * @return array|mixed
     */
    public function process($data)
    {
        return $data;
    }
}
