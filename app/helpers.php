<?php


if (!function_exists('mimetoextension'))
{
    function mimetoextension(string $mime)
    {
        return explode('/', $mime)[1];
    }
}
