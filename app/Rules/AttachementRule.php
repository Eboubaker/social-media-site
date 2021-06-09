<?php

namespace App\Rules;

use App\Exceptions\HttpPermissionException;
use App\Models\Community;
use App\Models\Image;
use App\Models\Profile;
use App\Models\Video;
use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class AttachementRule implements Rule
{
    /** @var UploadedFile[] $parsedFiles */
    private $parsedFiles;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Model $pageable)
    {
        $this->parsedFiles = [];
        $this->pageable = $pageable;
        $this->message = "this attachement is not allowed";
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $index
     * @param  UploadedFile  $file
     * @return bool
     */
    public function passes($index, $file)
    {
        
        try{
            $mime = mime_content_type($file->path());
            list($type, $extension) = explode('/', $mime);
            
            if($type === 'video')
            {
                if($this->pageable instanceof Community && ! $this->pageable->allowsCurrent(config('permissions.communities.can-attach-videos-to-own-comment')))
                {
                    throw new HttpPermissionException("You don't have permissions to post images");
                }
                if($extension !== 'mp4'
                    || $file->getSize() > 1024 * 1024 * 300
                    
                )
                {
                    return false;
                }
                $this->parsedFiles[] = [
                    'extension' => $extension,
                    'mime' => $mime,
                    'origin_name' => $file->getClientOriginalName() ?: 'video_' . preg_replace('/[^\d]/', '_', strval(now())),
                    'size' => $file->getSize(),
                    'path' => $file->path(),
                    'model' => Video::class,
                ];
            }else if($type === 'image')
            {
                if($this->pageable instanceof Community && ! $this->pageable->allowsCurrent(config('permissions.communities.can-attach-images-to-own-comment')))
                {
                    throw new HttpPermissionException("You don't have permissions to post images");
                }
                if(!in_array($extension, ['png', 'jpg'])
                    || $file->getSize() > 1024 * 1024 * 30
                )
                {
                    return false;
                }
                
                list(0 => $width, 1 => $height, 2 => $type, 'mime' => $mime) = getimagesize($file->path());
                
                $this->parsedFiles[] = [
                    'extension' => $extension,
                    'mime' => $mime,
                    'origin_name' => $file->getClientOriginalName() ?: 'image_' . preg_replace('/[^\d]/', '_', strval(now())),
                    'size' => $file->getSize(),
                    'path' => $file->path(),
                    'type' => $type,
                    'width' => $width,
                    'height' => $height,
                    'model' => Image::class,
                ];
                if($file->getSize() < 1024 * 1024 && $extension !== 'png')
                {
                    goto nocompress;
                }
                if($extension === 'png' && $file->getSize() < 1024 * 1024)
                {
                    $percent = 1;
                }
                compress:
                
                    $percent = $percent ?? 1024 * 1024 / $file->getSize();
                    $newwidth = $width * $percent;
                    $newheight = $height * $percent;
                    
                    $reduced = imagecreatetruecolor($newwidth, $newheight);
                    $source = false;
                    
                    if($type == IMAGETYPE_JPEG)
                    {
                        $source = imagecreatefromjpeg($file->path());
                    }else if($type == IMAGETYPE_PNG)
                    {
                        $source = imagecreatefrompng($file->path());
                    }
                    
                    if( $source === false)
                    {
                        $this->failWithMessage("Could not read attachement: ".$file->getClientOriginalName());
                    }
                    // Resize
                    $success = imagecopyresized($reduced, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                    
                    if( ! $success)
                    {
                        $this->failWithMessage("Image is too large, could not reduce image size: ".$file->getClientOriginalName()) ;
                    }
                    
                    // Output
                    $success = imagejpeg($reduced, $file->path());
                    if( ! $success)
                    {
                        $this->failWithMessage("Image is too large, could not reduce image size");
                    }
                nocompress:
                    return true;
            }
        }catch(\Throwable $e)
        {
            if($e instanceof HttpPermissionException)
            {
                throw $e;
            }
            report($e);
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    private function setMessage($message)
    {
        dd('message Chaned To $message');
        $this->message = $message;
    }
    private function failWithMessage($message)
    {
        $this->setMessage($message);
        throw new Exception($message);
    }
    public function getParsed()
    {
        return $this->parsedFiles;
    }
}
