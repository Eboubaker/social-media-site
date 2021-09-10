<?php
use Illuminate\Support\Facades\Storage;



(function (){
    $files = [];
    foreach(Storage::disk('seeds')->directories() as $folder)
    {
        if(Str::endsWith($folder, '_minified'))
        {
            continue;
        }
        if( ! file_exists(Storage::disk('seeds')->path($folder.'_minified')))
            mkdir(Storage::disk('seeds')->path($folder.'_minified'));
        foreach(Storage::disk('seeds')->files($folder) as $imagefile)
        {
            $imagefile = Storage::disk('seeds')->path($imagefile);
            $mime = mime_content_type($imagefile);
            if(Str::startsWith($mime, 'video'))
            {
                continue;
            }
            $image = Str::endsWith($mime, 'png') ? imagecreatefrompng($imagefile) : imagecreatefromjpeg($imagefile);
            $width = imagesx($image);
            $height = imagesy($image);
            
            $wperc = 768.0 / $width;
            $hperc = 1200.0 / $height;
            $perc = min($wperc, $hperc, 1);
            $perc = min(1.0, (1024.0 * 500) / filesize($imagefile));
            $new_width = $width * $perc;
            $new_height = $height * $perc;
            $thumb = imagecreatetruecolor( $new_width, $new_height );
            // Resize and crop
            imagecopyresampled( dst_image: $thumb,
                                src_image:$image,
                                dst_x:0,
                                dst_y:0,
                                src_x:0, 
                                src_y:0,
                                dst_width:$new_width,
                                dst_height: $new_height,
                                src_width:$width,
                                src_height: $height);
            
            imagejpeg($thumb, Storage::disk('seeds')->path($folder.'_minified/'.explode('.', basename($imagefile))[0].'.jpg'), 90);
            imagedestroy($image);
            imagedestroy($thumb);
            unset($image);
            unset($thumb);
        }
    }
})();

(function (){
    $files = [];
    foreach(Storage::disk('seeds')->files('english_people') as $file)
        $files[] = Storage::disk('seeds')->path($file);
    
    foreach($files as $imagefile)
    {
        $image = imagecreatefromjpeg($imagefile);
        $width = imagesx($image);
        $height = imagesy($image);
        $aspect = 1.0 * $width / $height;
        $required_aspect = 1.0;
        $required_width = 200.0;
        $required_height = 200.0;
    
        if ($aspect >= $required_aspect)
        {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $required_height;
            $new_width = $width / ($height / $required_height);
        }
        else
        {
            // If the thumbnail is wider than the image
            $new_width = $required_width;
            $new_height = $height / ($width / $required_width);
        }
        $thumb = imagecreatetruecolor( $required_width, $required_height );
        // Resize and crop
        imagecopyresampled( dst_image: $thumb,
                            src_image:$image,
                            dst_x:0 - ($new_width - $required_width) / 2, // Center the image horizontally
                            dst_y:0, // Center the image vertically
                            src_x:0, 
                            src_y:0,
                            dst_width:$new_width,
                            dst_height: $new_height,
                            src_width:$width,
                            src_height: $height);
            imagejpeg($thumb, Storage::disk('seeds')->path('english_people_minified/'.explode('.', basename($imagefile))[0].'.jpg'), 90);
        imagedestroy($image);
        imagedestroy($thumb);
        unset($image);
        unset($thumb);
    }
    
    
})();



