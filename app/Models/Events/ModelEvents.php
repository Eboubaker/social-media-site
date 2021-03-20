<?php


namespace App\Models\Events;


use App\Models\Image;
use App\Models\Morphs\Postable;
use App\Models\Morphs\PostableAttachement;
use App\Models\Morphs\Profileable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\AssignOp\Mod;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;

class ModelEvents
{
    public static function removeAssociatedFiles($model)
    {
        $disk = Storage::disk($model->storage);
        if ($disk->exists($model->fileName)) {
            $disk->delete($model->fileName);
        }
    }
    public static function addSha256($model)
    {
        if(empty($model->getAttribute('sha256')))
        {
            $model->setAttribute('sha256', hash('sha256',  Storage::disk($model->storage)->get($model->fileName)));
        }
    }
    public static function addPublicId($model)
    {
        if(empty($model->getAttribute('public_id')))
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
    public static function addStorageId($model)
    {
        if(empty($model->getAttribute('storage_id')))
        {
            $tries = 3;
            do {
                $sid = Str::uuid()->toString();
            }while(Storage::disk($model->storage)->exists($sid.'.'.$model->fileFormat) && --$tries > 0);
            $model->setAttribute('storage_id', $sid);
        }
    }
    public static function copyTempToStorage($model)
    {
        if(!empty($model->_tempFile)
            && !rename($model->_tempFile, Storage::disk($model->storage)->path($model->getAttribute('storage_id') . '.' . $model->fileFormat))) {
            throw new CannotWriteFileException("Cannot copy temp file of model ".class_basename($model)." to storage");
        }
    }
}
