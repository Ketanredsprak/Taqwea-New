<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;

/**
 * Method uploadFile
 *
 * @param UploadedFile $file       
 * @param string       $folder     
 * @param string       $permission 
 * @param array        $thumbnailOptions 
 *
 * @return void
 */
function uploadFile(
    UploadedFile $file,
    string $folder,
    string $permission = 'public',
    array $thumbnailOptions = []
) {
    $extention = getFileExtention($file);
    $filenameWithoutExt = getFileName($file) . time();
    $filenameWithoutExt = str_replace('.', '_', $filenameWithoutExt);
    $filename = $filenameWithoutExt . '.' . $extention;
    $file_path = $folder . '/' . $filename;
    $filesystem = config('filesystems.default');
    $key = "";
    if ($permission == "private") {
        $key = Storage::disk(config('filesystems.private'))
                ->putFileAs($folder, $file, $filename);
    } else if (!Storage::exists($file_path)) {
        $key = Storage::putFileAs($folder, $file, $filename);
    }

    if ($thumbnailOptions && getFileType($extention) == 'image') {
        $thumbnailPath = $folder . '/thumb/' . $filename;
        if (!Storage::exists($thumbnailPath)) {
            $thumb = createThumbnail(
                $file,
                $thumbnailOptions['width'],
                $thumbnailOptions['height']
            );
            Storage::put($thumbnailPath, $thumb);
        }
    }

    if ($thumbnailOptions
        && getFileType($extention) == 'video'
        && $filesystem == 'local'
    ) {
        $thumbnailPath = $folder . '/thumb/' . $filenameWithoutExt . '.jpeg';
        if (!Storage::exists($thumbnailPath)) {
            
            $thumb = createThumbnailFromVideo(
                $key,
                $thumbnailOptions['width'],
                $thumbnailOptions['height']
            );
            Storage::put($thumbnailPath, $thumb);
        }
    }
    return $key;
}

/**
 * Method checkImage
 *
 * @param string|null $fileName [explicite description]
 * @param string      $type     [explicite description]
 *
 * @return void
 */
function getImageUrl($fileName, string $type = "user", string $permission = 'public')
{
    if ($type == "document") {
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if ($ext == 'pdf') {
            $src = asset('assets/images/pdf-thumb.jpg');
        } else {
            $src = asset('assets/images/document-thumb.png');
        }
    } else {
        $src = url('assets/images/default-user.jpg');
    }
    if ($fileName) {
       
        if ($permission == "private") {
            $exists = Storage::disk(config('filesystems.private'))
                ->exists($fileName);
            if ($exists && $fileName) {
                $filesystem = config('filesystems.default');
                if ($filesystem === 'local') {
                    $src = Storage::url($fileName);
                } else {
                    $src = Storage::disk(\config('filesystems.private'))
                        ->temporaryUrl($fileName, now()->addSecond(3));
                }
            }  
        } else {
            $exists = Storage::exists($fileName);
            if ($exists && $fileName) {
                $src = Storage::url($fileName);
            }
        }
        
    }
    return $src;
}

/**
 * Method getThumbnailUrl
 *
 * @param string $fileName [explicite description]
 * @param string $type     [explicite description]
 *
 * @return string
 */
function getThumbnailUrl(string $fileName = null, $type = '')
{
    $src = url('assets/images/default-user.jpg');
    if ($fileName) {
        if (in_array($type, ["video", "image"])) {
            $thumbPath = getThumbPath($fileName);
            $exists = Storage::exists($thumbPath);
            if ($exists) {
                $src = Storage::url($thumbPath);
            }
        } else {
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            if ($ext == 'pdf') {
                return asset('assets/images/pdf-thumb.jpg');
            } else {
                return asset('assets/images/document-thumb.png');
            }
        }
    }
    return $src;
}

/**
 * Method deleteFile
 *
 * @param string|null $filePath [explicite description]
 *
 * @return bool
 */
function deleteFile($filePath): bool
{
    $exists = Storage::exists($filePath);
    if ($exists) {
        Storage::delete($filePath);
        $thumb = getThumbPath($filePath);
        if ($thumb && Storage::exists($thumb)) {
            Storage::delete($thumb);
        }
        return true;
    }
    return false;
}

/**
 * Method getThumbPath
 *
 * @param string $fileKey [explicite description]
 *
 * @return string
 */
function getThumbPath(string $fileKey): string
{
    $parts = explode('/', $fileKey);
    $mediaName = array_pop($parts);
    $nameParts = explode('.', $mediaName);
    $mediaExt = array_pop($nameParts);
    $thumbPath = implode('/', $parts);
    if (getFileType($mediaExt) == 'video') {
        $thumbPath .= '/thumb/' . $nameParts[0] . '.jpeg';
    } elseif (getFileType($mediaExt) == 'image') {
        $thumbPath .= '/thumb/' . $mediaName;
    }

    return $thumbPath;
}

/**
 * Method getFileName
 *
 * @param $file $file [explicite description]
 *
 * @return string
 */
function getFileName($file): string
{
    return pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
}

/**
 * Method getFileExtention
 *
 * @param $file $file [explicite description]
 *
 * @return string
 */
function getFileExtention($file): string
{
    return pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
}

/**
 * Create a thumbnail of specified size
 *
 * @param string $path 
 * @param int    $width 
 * @param int    $height 
 * 
 * @return void
 */
function createThumbnail($path, $width, $height)
{
    $image = Image::make($path)
        ->resize(
            $width,
            $height,
            function ($constraint) {
                $constraint->aspectRatio();
            }
        );
    return $image->stream();
}

/**
 * Method createThumbnailFromVideo
 *
 * @param string $video  [explicite description]
 * @param int    $width  [explicite description]
 * @param int    $height [explicite description]
 *
 * @return void
 */
function createThumbnailFromVideo(string $video, $width, $height)
{
    $filesystem = config('filesystems.default');
    $contents = FFMpeg::fromDisk($filesystem)
        ->open($video)
        ->getFrameFromSeconds(2)
        ->export()
        ->getFrameContents();

    return createThumbnail($contents, $width, $height);
}

/**
 * Get file type by url
 * 
 * @param String $ext 
 * 
 * @return String
 */
function getFileType($ext): string
{
    $fileType = "";
    $image = ['png', 'jpg', 'jpeg', 'svg'];
    $video = ['mp4', 'ogx', 'oga', 'ogv', 'ogg', 'webm', '3gp', 'mov'];
    $pdf = ['pdf'];
    $doc = ['doc', 'docx'];
    switch ($ext) {
        case in_array($ext, $image):
            $fileType = 'image';
            break;
        case in_array($ext, $video):
            $fileType = 'video';
            break;
        case in_array($ext, $pdf):
            $fileType = 'pdf';
            break;
        case in_array($ext, $doc):
            $fileType = 'doc';
            break;
        default:
            $fileType = 'default';
            break;
    }
    return $fileType;
}

/**
 * Method getExtensionFromKey
 *
 * @param string $key [explicite description]
 *
 * @return string
 */
function getExtensionFromKey(string $key): string
{
    return pathinfo($key, PATHINFO_EXTENSION);
}

/**
 * Method getFileTypeFromMime
 *
 * @param string $mimeType [explicite description]
 *
 * @return string
 */
function getFileTypeFromMime(string $mimeType)
{
    $fileType = "";
    $image = [
        'image/png', 'image/jpeg', 'image/gif', 'image/svg+xml'
    ];

    $pdf = [
        'application/pdf'
    ];

    $doc = [
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    $video = [
        'video/mp4', 'video/mpeg', 'video/ogg', 'video/mp2t',
        'video/webm', 'video/3gpp', 'video/3gpp2'
    ];

    switch ($mimeType) {
        case in_array($mimeType, $image):
            $fileType = 'image';
            break;
        case in_array($mimeType, $video):
            $fileType = 'video';
            break;
        case in_array($mimeType, $pdf):
            $fileType = 'pdf';
            break;
        case in_array($mimeType, $doc):
            $fileType = 'doc';
            break;
        default:
            $fileType = 'text';
            break;
    }

    return $fileType;
}

/**
 * Method saveFacebookAvatar
 *
 * @param string|null $url 
 * @param string      $folder 
 * @param string      $imageName 
 * 
 * @return void
 */
function saveFacebookAvatar(
    ?string $url,
    string $folder,
    string $imageName
) {
    try {
        $image = file_get_contents($url);
        $imageName = $folder . '/' . $imageName;
        Storage::put($imageName, $image);
        return $imageName;
    } catch (\Exception $th) {
        return '';
    }
}

/**
 * Method Put Permanent
 * 
 * @param string $key
 * @param string $value
 */
function putPermanentEnv($key, $value)
{
    $path = app()->environmentFilePath();
    file_put_contents(
        $path,
        preg_replace(
            "/^{$key}=.*/m",
            "{$key}={$value}",
            file_get_contents($path)
        )
    );
}
