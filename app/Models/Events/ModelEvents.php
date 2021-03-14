<?php


namespace App\Models\Events;


use App\Models\Morphs\Postable;
use App\Models\Morphs\PostableAttachement;
use App\Models\Morphs\Profileable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\AssignOp\Mod;

class ModelEvents
{
    public static function removeAssociatedFiles($model)
    {
        $f = Storage::disk($model->storage)->path($model->fileName);
        if (file_exists($f)) {
            unlink($f);
        }
    }
    public static function addSha256($model)
    {
        if(empty($model->sha256))
        {
            $model->setAttribute('sha256', hash('sha256',  Storage::disk($model->storage)->get($model->fileName)));
        }
    }
    public static function addPublicId($model)
    {
        if(empty($model->attributes['public_id']))
        {
            $tries = 3;
            $uuid = Str::uuid()->toString();
            while(--$tries > 0 && $model::where('public_id', $uuid)->count()>0)
            {
                $uuid = Str::uuid()->toString();
            }
            $model->setAttribute('public_id', $uuid);
        }
    }
    public static function addUuid($model)
    {
        if(empty($model->getAttribute($model->getKeyName())))
        {
            $tries = 3;
            $uuid = Str::uuid()->toString();
            while(--$tries > 0 && $model::find($uuid))
            {
                $uuid = Str::uuid()->toString();
            }
            $model->setAttribute($model->getKeyName(), $uuid);
        }
    }
}
