<?php

use App\Exceptions\NotInTransactionException;
use Illuminate\Support\Facades\DB;

if (!function_exists('mimetoextension'))
{
    function mimetoextension(string $mime)
    {
        return explode('/', $mime)[1];
    }
}
if (!function_exists('array_rename_key')) {
    function array_rename_key(&$array, $old_key, $new_key)
    {
        $array[$new_key] = $array[$old_key];
        unset($array[$old_key]);
    }
}

if (!function_exists('assertInTransaction')) {
    function assertInTransaction()
    {
        if(DB::connection()->transactionLevel() === 0)
        {
            throw new NotInTransactionException();
        }
    }
}

if(!defined("REASON_CASCADE"))
{
    define("REASON_CASCADE", "CASCADE");
}
if(!defined("REASON_DELETED_BY_OWNER"))
{
    define("REASON_DELETED_BY_OWNER", "DELETED_BY_OWNER");
}