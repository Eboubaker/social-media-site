<?php


namespace App\Models\Funcs;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ModelFuncs

{
    public $funcs = [];
    public static $HasUuid = 'HasUuid';
    public static $HasSha256 = 'HasSha256';
    public static $UnlinkOnDelete = 'UnlinkOnDelete';
    public function __construct()
    {
        $this->funcs[self::$HasUuid] = static function($model){
            if(empty($model->attributes[$model::PKEY]))
            {
                $tries = 3;
                $uuid = Str::uuid()->toString();
                while(--$tries > 0 && $model::find($uuid))
                {
                    $uuid = Str::uuid()->toString();
                }
                $model->setAttribute($model::PKEY, $uuid);
            }
        };
        $this->funcs[self::$HasSha256] = static function($model){
            if(empty($model->sha256))
            {
                $model->setAttribute('sha256', hash('sha256',  Storage::disk($model->storage)->get($model->fileName)));
            }
        };
        $this->funcs[self::$UnlinkOnDelete] = static function($model){
            $f = Storage::disk($model->storage)->path($model->fileName);
            if(file_exists($f))
            {
                unlink($f);
            }
        };
    }
}
