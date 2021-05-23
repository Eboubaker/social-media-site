<?php


namespace App\Models\Traits;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;

trait HasStorageFile
{
    use SoftDeletes;
    
    private string $att_fileName;
    private string $att_realPath;
    private string $att_sha256;
    private string $att_temp;
    
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
    public function removeFile(): bool
    {
        $disk = Storage::disk($this->storage);
        if ($disk->exists($this->fileName)) {
            return $disk->delete($this->fileName);
        }
        return false;
    }
    public function reCalculateSha256Attribute()
    {
        if(empty($this->getAttribute('sha256')))
        {
            $location = null;
            if(empty($this->getKey) && !empty($this->att_temp))
            {
                $location = $this->att_temp;
            }else{
                $location = Storage::disk($this->storage)->get($this->fileName);
            }
            $this->setAttribute('sha256', hash('sha256',  $location));
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