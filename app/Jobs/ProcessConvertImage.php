<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Models\DuckImage;

class ProcessConvertImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file;
    public $typeTarget;
    public $image_quality = 100;
    public $target_dir;
    public $only_name1;
    public $diskImagePath;
    public $imageId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($typeTarget, $target_dir, $only_name1, $diskImagePath, $imageId)
    {
        $this->typeTarget = $typeTarget;
        $this->target_dir = $target_dir;
        $this->only_name1 = $only_name1;
        $this->diskImagePath = $diskImagePath;
        $this->imageId = $imageId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get image
        $this->file = Storage::path($this->diskImagePath);

        // start covert image
        $binary = imagecreatefromstring(file_get_contents($this->file));
        $newName = $this->only_name1 . '.' . $this->typeTarget;

        ob_start(); //Tạo một bộ đệm đầu ra mới và thêm nó vào đầu ngăn xếp.

        // convert image
        switch ($this->typeTarget) {
            case "webp":
                imagewebp($binary, $this->target_dir . $this->only_name1 . '.' . $this->typeTarget, $this->image_quality);
                imagewebp($binary, NULL, 100);
                break;
            case "gif":
                imagegif($binary, $this->target_dir . $this->only_name1 . '.' . $this->typeTarget);
                imagegif($binary, NULL);
                break;
            case "png":
                imagepng($binary, $this->target_dir . $this->only_name1 . '.' . $this->typeTarget);
                imagepng($binary, NULL);
                break;
            default: //jpeg
                imagejpeg($binary, $this->target_dir . $this->only_name1 . '.' . $this->typeTarget, $this->image_quality);
                imagejpeg($binary, NULL, 100);
        }

        $cont = ob_get_contents(); //  Trả về nội dung của bộ đệm đầu ra trên cùng.
        ob_end_clean(); // - Trả về tất cả nội dung của bộ đệm đầu ra trên cùng & xóa nội dung khỏi bộ đệm.
        imagedestroy($binary);
        $content = imagecreatefromstring($cont);
        $output = $this->target_dir . $newName;

        switch ($this->typeTarget) {
            case "webp":
                imagewebp($content, $output);
                break;
            case "gif":
                imagegif($content, $output);
                break;
            case "png":
                imagepng($content, $output);
                break;
            default: //jpeg
                imagejpeg($content, $output);
        }
        imagedestroy($content);

        // update database
        $duckImage = DuckImage::find($this->imageId);
        $duckImage->size_after = filesize($output);
        $duckImage->save();
    }
}
