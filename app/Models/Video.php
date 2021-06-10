<?php

namespace App\Models;

use App\Models\Traits\HasStorageUrl;
use App\Models\Traits\ModelTraits;
use Exception;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Video
 *
 * @property int $id
 * @property string $videoable_type
 * @property int $videoable_id
 * @property string $sha256
 * @property int $type
 * @property int $width
 * @property int $height
 * @property int $seconds
 * @property int $size
 * @property string|null $origin_name
 * @property string $extension
 * @property float|null $sfw_score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $reason_deleted
 * @property-read mixed $created
 * @property-read string $file_name
 * @property-read string $real_path
 * @property-read string $url
 * @property-write mixed $temporary_file_location
 * @property-read Model|\Eloquent $videoable
 * @method static \Database\Factories\VideoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video newQuery()
 * @method static \Illuminate\Database\Query\Builder|Video onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereOriginName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereReasonDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereSeconds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereSfwScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereSha256($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereVideoableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereVideoableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|Video withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Video withoutTrashed()
 * @mixin \Eloquent
 */
class Video extends Model
{
    use HasFactory, 
    ModelTraits, 
    HasStorageUrl,
    SoftDeletes;

    public $storage = 'videos';
    protected $guarded = [];


    public function videoable()
    {
        return $this->morphTo();
    }

    public static function extractAttributesFromFile(string $path)
    {
        $stream = app('ffprobe')->streams($path)->first()->all();
        $format = app('ffprobe')->format($path)->all();
        $mime = mime_content_type($path);
        $ret = [
            "width" => $stream['width'],
            "height" => $stream['height'],
            'mime' => $mime,
            'duration' => $format['duration'],
            'size' => $format['size'],
            'extension' => explode('/', $mime)[1],
        ];
        if($format['probe_score'] < 50)
        {
            throw new Exception('probe_score < 50 for:' . $path);
        }
        foreach($ret as $key => $v)
        {
            if(empty($v))
            {
                throw new Exception("$key is empty $key => $v");
            }
        }
        return $ret;
    }
}
