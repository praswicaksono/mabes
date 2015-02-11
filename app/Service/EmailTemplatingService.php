<?php


namespace Mabes\Service;

/**
 * Class EmailTemplatingService
 * @package Mabes\Service\Command
 */
class EmailTemplatingService
{
    /**
     * @param $name
     * @param $data
     * @return mixed|string
     */
    public function template($name, $data)
    {
        $html = file_get_contents(APP_DIR . "/Templates/Email/{$name}.html");

        foreach ($data as $key => $value) {
            $html = str_replace("%" . strtoupper($key) . "%", $value, $html);
        }

        return $html;
    }
}

// EOF
