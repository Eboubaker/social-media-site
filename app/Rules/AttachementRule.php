<?php

namespace App\Rules;

use App\Exceptions\HttpPermissionException;
use App\Models\Image;
use App\Models\Video;
use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use App\Models\Traits\Attachement;

class AttachementRule implements Rule
{
    /** @var \Illuminate\Support\Collection<Model implements Attachement> $models */
    private $models;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Model $pageable)
    {
        $this->models = Collection::make();
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
            $type = explode('/', mime_content_type($file->path()))[0];
            $attributes = [
                'origin_name' => $file->getClientOriginalName()
            ];
            if($type === 'image')
            {
                $attributes += Image::extractAttributesFromFile($file->path());
                $model = Image::make($attributes);
            }else if($type === 'video')
            {
                $attributes += Video::extractAttributesFromFile($file->path());
                $model = Video::make($attributes);
            }else{
                $this->failWithMessage('unsupported media type');
            }
            $model->setTemporaryFileLocationAttribute($file->path());
            $this->models[] = $model;
            return true;
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
        $this->message = $message;
    }
    private function failWithMessage($message)
    {
        $this->setMessage($message);
        throw new Exception($message);
    }
    public function getModels()
    {
        return $this->models;
    }
}
