<?php


namespace App\Models\Traits;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;

trait HasStorageFile
{
    private string $att_fileName;
    private string $att_realPath;
    private string $att_temp;
    
    private bool $fileTrashed = false;
    private string $trashName;


    public static function bootHasStorageFile()
    {
        static::deleting(function($storable){
            try
            {
                $storable->trashFile();
                if($storable->isForceDeleting())
                {
                    $storable->deleteTrashed();
                }
            }catch(\Throwable $e)
            {
                report($e);
            }
            
        });
        static::restored(function($storable){
            $storable->restoreFile();
        });
        static::created(function($storable){
            $storable->copyTemporaryFileToStorage();
        });
        static::creating(function($storable){
            if(empty($storable->getAttribute('sha256')))
            {
                $location = null;
                if(empty($storable->getKey) && !empty($storable->att_temp))
                {
                    $location = $storable->att_temp;
                }else{
                    $location = Storage::disk($storable->storage)->get($storable->fileName);
                }
                $storable->setAttribute('sha256', hash('sha256',  $location));
            }
        });
    }

    public function fileTrashed()
    {
        return $this->fileTrashed;
    }
    public function getFileNameAttribute(): string
    {
        if(empty($att_fileName))
            $this->att_fileName = $this->getKey() .".". $this->getAttribute('extension');
        return $this->att_fileName;
    }
    public function getRealPathAttribute(): string
    {
        if(empty($att_realPath))
            $this->att_realPath = Storage::disk($this->storage)->path($this->fileName);
        return $this->att_realPath;
    }
    private function getTrashName():string
    {
        if(empty($this->trashName))
        {
            $this->trashName = str_replace('\\', '.', $this::class) . "." . $this->getKey();
        }
        return $this->trashName;
    }
    public function trashFile(): bool
    {
        try {
            $disk = Storage::disk($this->storage);
            $file = $disk->path($this->fileName);
            $trashFullName = Storage::disk('trash')->path($this->getTrashName());
            if(file_exists($file))
            {
                $this->fileTrashed = File::move($file, $trashFullName);
                return $this->fileTrashed;
            }
        }catch(\Throwable $e)
        {
            report($e);
        }
        return false;
    }
    public function deleteTrashed():bool
    {
        try {
            return Storage::disk('trash')->delete($this->getTrashName());
        }catch(\Throwable $e)
        {
            report($e);
        }
        return false;
    }
    public function restoreFile():bool
    {
        $trashedFile = Storage::disk('trash')->path($this->getTrashName());
        if(file_exists($trashedFile))
        {
            try{
                if(File::move($trashedFile, $this->realPath))
                {
                    $this->fileTrashed = false;
                    $this->trashName = null;
                    return true;
                }else{
                    throw new \Exception("File Not Restored");
                }
            }catch(\Throwable $e)
            {
                report($e);
                return false;
            }
        }
    }
    public function setTemporaryFileLocationAttribute($fullPath)
    {
        $this->att_temp = $fullPath;
    }
    public function copyTemporaryFileToStorage()
    {
        if(empty($this->att_temp))
        {
            throw new FileNotFoundException("FILE `" . $this->att_temp . "` DOES NOT EXIST");
        }
        if(!rename($this->att_temp, $this->realPath))
        {
            throw new CannotWriteFileException("Cannot copy temp file $this->att_temp of model ".class_basename($this)." to storage $this->realPath");
        }
    }
}