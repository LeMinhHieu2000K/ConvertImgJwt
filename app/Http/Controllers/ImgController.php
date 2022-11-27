<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessConvertImage;
use App\Models\Img;
use App\Models\ImgAfter;
use App\Models\ImgClient;
use App\Models\DuckImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;
use Intervention\Image\Facades\Image;

class ImgController extends Controller
{
    // upload hình ảnh
    public function postUploadImg(Request $request)
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $size = $file->getSize();
                // cho vào file 
                $file->move('source/image', $filename);
                // khởi tạo đối tượng ảnh
                $imgData = new Img();
                $imgData->image = $filename;
                $imgData->extension = $extension;
                $imgData->size = $size;
                $imgData->formatSize = $this->formatSizeUnits($size);

                $imgData->save();
            }
            return response()->json([
                "status" => 200,
                "message" => "Upload successfully"
            ], 200);
        } else {
            return response()->json([
                "status" => 406,
                "message" => "Cannot find File(s) uploaded"
            ], 406);
        }
    }

    // Danh sách toàn bộ hình ảnh
    public function getImageData()
    {
        $imgData = Img::all();
        return response()->json([
            "status" => 200,
            "message" => "Data Img",
            "data" => $imgData
        ]);
    }

    // Xóa hình ảnh
    public function deleteImg(Request $request, $id)
    {
        $target_dir = 'source/image/';
        $name_img = Img::where('id', $id)->first();
        unlink($target_dir . $name_img->image);
        $delete_Img = Img::where('id', $id)->delete();
        return response()->json([
            "status" => 200,
            "message" => "Data Img Delete successfully",
        ]);
    }

    // Convert ảnh
    public function convertImageData(Request $request, $image_quality = 100)
    {
        $request->validate([
            "typecanchuyen" => "required",
            "id_img" => "required"
        ]);
        $id_img = $request->id_img;
        for ($m = 0; $m < count($id_img); $m++) {
            $Img = Img::where('id', $id_img[$m])->first();
            $nameImg = $Img->image; // tên ban đầu
            $typeOriginal =  $Img->extension; // kiểu ban đầu
        }

        $typeTarget = $request->typecanchuyen; // kiểu cần chuyển
        $count = 0;
        $idImg = $request->id_img;
        foreach ($idImg as $id) {
            $count++;
        }

        for ($i = 0; $i < $count; $i++) {
            $nameImg;
            $typeOriginal;
            $typeTarget[$i];
            $dir = 'source/image/'; // đường dẫn ban đầu
            $target_dir = "source/convert/"; // đường dẫn lưu trữ ảnh đã convert
            $image = $dir . $nameImg[$i]; // tạo ảnh
            $date = getdate();
            $ngay = $date['mday'] . $date['mon'] . $date['year'];
            $only_name = basename($image, '.' . $typeOriginal);
            $only_name1 = $only_name . '_' . $ngay . '_' . $i;
            $ImgClient_dir = 'source/ImgClient/';
            $imgClient = $ImgClient_dir . $nameImg[$i];

            if ($typeTarget[$i] == 'gif') {
                $binary = imagecreatefromstring(file_get_contents($image));
                $binarySecond = imagecreatefromstring(file_get_contents($image));
                imageGif($binary, $target_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
                imageGif($binarySecond, $ImgClient_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
                $ten_moi = $only_name1 . '.' . $typeTarget[$i];

                ob_start(); //Tạo một bộ đệm đầu ra mới và thêm nó vào đầu ngăn xếp.
                imagegif($binary, NULL, 100);
                $cont = ob_get_contents(); //  Trả về nội dung của bộ đệm đầu ra trên cùng.
                ob_end_clean(); // - Trả về tất cả nội dung của bộ đệm đầu ra trên cùng & xóa nội dung khỏi bộ đệm.
                imagedestroy($binary);
                $content = imagecreatefromstring($cont);
                $output = $target_dir . $ten_moi;
                imagegif($content, $output);
                imagedestroy($content);

                ob_start(); //Tạo một bộ đệm đầu ra mới và thêm nó vào đầu ngăn xếp.
                imagegif($binarySecond, NULL, 100);
                $cont = ob_get_contents(); //  Trả về nội dung của bộ đệm đầu ra trên cùng.
                ob_end_clean(); // - Trả về tất cả nội dung của bộ đệm đầu ra trên cùng & xóa nội dung khỏi bộ đệm.
                imagedestroy($binarySecond);
                $content = imagecreatefromstring($cont);
                $output = $ImgClient_dir . $ten_moi;
                imagegif($content, $output);
                imagedestroy($content);
            }

            if ($typeTarget[$i] == 'webp') {
                $binary = imagecreatefromstring(file_get_contents($image));
                $binarySecond = imagecreatefromstring(file_get_contents($image));
                imagewebp($binary, $target_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
                imagewebp($binarySecond, $ImgClient_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
                $ten_moi = $only_name1 . '.' . $typeTarget[$i];

                ob_start(); //Tạo một bộ đệm đầu ra mới và thêm nó vào đầu ngăn xếp.
                imagewebp($binary, NULL, 100);
                $cont = ob_get_contents(); //  Trả về nội dung của bộ đệm đầu ra trên cùng.
                ob_end_clean(); // - Trả về tất cả nội dung của bộ đệm đầu ra trên cùng & xóa nội dung khỏi bộ đệm.
                imagedestroy($binary);
                $content = imagecreatefromstring($cont);
                $output = $target_dir . $ten_moi;
                imagewebp($content, $output);
                imagedestroy($content);

                ob_start(); //Tạo một bộ đệm đầu ra mới và thêm nó vào đầu ngăn xếp.
                imagewebp($binarySecond, NULL, 100);
                $cont = ob_get_contents(); //  Trả về nội dung của bộ đệm đầu ra trên cùng.
                ob_end_clean(); // - Trả về tất cả nội dung của bộ đệm đầu ra trên cùng & xóa nội dung khỏi bộ đệm.
                imagedestroy($binarySecond);
                $content = imagecreatefromstring($cont);
                $output = $ImgClient_dir . $ten_moi;
                imagewebp($content, $output);
                imagedestroy($content);
            }
            if ($typeTarget[$i] == 'png') {
                $binary = imagecreatefromstring(file_get_contents($image));
                $binarySecond = imagecreatefromstring(file_get_contents($image));
                imagepng($binary, $target_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
                imagepng($binarySecond, $ImgClient_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
                $ten_moi = $only_name1 . '.' . $typeTarget[$i];

                ob_start();
                imagepng($binary, NULL, 100);
                $cont = ob_get_contents();
                ob_end_clean();
                imagedestroy($binary);
                $content = imagecreatefromstring($cont);
                $output = $target_dir . $ten_moi;
                imagepng($content, $output);
                imagedestroy($content);

                ob_start();
                imagepng($$binarySecond, NULL, 100);
                $cont = ob_get_contents();
                ob_end_clean();
                imagedestroy($binarySecond);
                $content = imagecreatefromstring($cont);
                $output = $ImgClient_dir . $ten_moi;
                imagepng($content, $output);
                imagedestroy($content);
            }

            if ($typeTarget[$i] == 'jpg') {
                $binary = imagecreatefromstring(file_get_contents($image));
                $binarySecond = imagecreatefromstring(file_get_contents($image));
                imagejpeg($binary, $target_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
                imagejpeg($binarySecond, $ImgClient_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
                $ten_moi = $only_name1 . '.' . $typeTarget[$i];

                ob_start();
                imagejpeg($binary, NULL, 100);
                $cont = ob_get_contents();
                ob_end_clean();
                imagedestroy($binary);
                $content = imagecreatefromstring($cont);
                $output = $target_dir . $ten_moi;
                imagejpeg($content, $output);
                imagedestroy($content);

                ob_start();
                imagejpeg($binarySecond, NULL, 100);
                $cont = ob_get_contents();
                ob_end_clean();
                imagedestroy($binarySecond);
                $content = imagecreatefromstring($cont);
                $output = $ImgClient_dir . $ten_moi;
                imagejpeg($content, $output);
                imagedestroy($content);
            }

            $i++;
        }

        $file_names = glob("source/convert/*");
        $ImgData = Img::all();
        $dem = 0;
        foreach ($file_names as $item) {
            $dem++;
        }
        for ($j = 0; $j < $dem; $j++) {
            $newName = basename($file_names[$j]); // tên mới 
            $link = $file_names[$j];
            $size = filesize($file_names[$j]); // size mới
            $id_img = $ImgData[$j]->id;
            $sizeBefore =  $ImgData[$j]->size; // size cũ
            $decleare = round(100 - (($size / $sizeBefore) * 100));

            $ImgAfter = new ImgAfter();
            $ImgAfter->id_img = $id_img;
            $ImgAfter->name = $newName;
            $ImgAfter->link = $link;
            $ImgAfter->formatSizeBefore = $this->formatSizeUnits($sizeBefore);
            $ImgAfter->formatSizeAfter = $this->formatSizeUnits($size);
            $ImgAfter->decleare = $decleare;
            $ImgAfter->save();

            $ImgClient = new ImgClient();
            $ImgClient->user_id = Auth::user()->id;
            $ImgClient->image = $newName;
            $ImgClient->size = $this->formatSizeUnits($size);
            $ImgClient->save();
        }
        $ImgAfter = ImgAfter::all();

        // XÓA DỮ LIỆU BẢNG img và img After
        // $idImg = $request->id_img; // id ảnh
        // foreach ($idImg as $id) {
        //     $delete_Img = Img::where('id', $id)->delete();
        //     $delete_ImgAfter = ImgAfter::where('id_img', $id)->delete();
        // }
        return response()->json([
            "status" => 200,
            "message" => "Data Img converted successfully",
            "data" => $ImgAfter
        ]);
    }

    // chức năng mở rộng : thumbnail , banner , xóa nền, resize
    public function postCreateThumbnail(Request $request)
    {
        if ($request->hasFile('profile_image')) {
            //get filename with extension
            $filenamewithextension = $request->file('profile_image')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('profile_image')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            //small thumbnail name
            $smallthumbnail = $filename . '_small_' . time() . '.' . $extension;

            //medium thumbnail name
            $mediumthumbnail = $filename . '_medium_' . time() . '.' . $extension;

            //large thumbnail name
            $largethumbnail = $filename . '_large_' . time() . '.' . $extension;

            //Upload File
            $request->file('profile_image')->storeAs('public/profile_images', $filenametostore);
            $request->file('profile_image')->storeAs('public/profile_images/thumbnail', $smallthumbnail);
            $request->file('profile_image')->storeAs('public/profile_images/thumbnail', $mediumthumbnail);
            $request->file('profile_image')->storeAs('public/profile_images/thumbnail', $largethumbnail);

            //create small thumbnail
            $smallthumbnailpath = public_path('storage/profile_images/thumbnail/' . $smallthumbnail);
            $this->createThumbnail($smallthumbnailpath, 150, 93);

            //create medium thumbnail
            $mediumthumbnailpath = public_path('storage/profile_images/thumbnail/' . $mediumthumbnail);
            $this->createThumbnail($mediumthumbnailpath, 300, 185);

            //create large thumbnail
            $largethumbnailpath = public_path('storage/profile_images/thumbnail/' . $largethumbnail);
            $this->createThumbnail($largethumbnailpath, 550, 340);

            return response()->json([
                "status" => 200,
                "message" => "Thumbnail created successfully",
            ]);
        }
    }

    // Resize
    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }

    // Xóa nền
    public function postRemoveBackground(Request $request)
    {
        if (isset($_POST['submit'])) {
            $rand = rand(111111111, 999999999);
            move_uploaded_file($_FILES['file']['tmp_name'], 'upload/' . $rand . $_FILES['file']['name']);
            $file = "upload/" . $rand . $_FILES['file']['name'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.remove.bg/v1.0/removebg');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            $post = array(
                'image_url' => $file,
                'size' => 'auto'
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $headers = array();
            $headers[] = 'X-Api-Key: SViJniNnLybr3tCSNW9Lrevg';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            curl_close($ch);
            $fp = fopen('remove/' . $rand . '.png', "wb");
            fwrite($fp, $result);
            fclose($fp);
            echo "<img src='remove/$rand.png'>";
        }
    }

    // Tải hình ảnh
    public function download_img(Request $request)
    {
        $date = getdate();
        $ngay = $date['mday'] . '/' . $date['mon'] . '/' . $date['year'];
        $dem  = 0;
        $file_names = glob("source/convert/*");
        foreach ($file_names as $file) {
            $dem++;
        }
        if ($dem == 1) {
            $file_names = glob("source/convert/*");
            $file_namess = glob("source/image/*");
            foreach ($file_names as $file) {

                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary");
                header("Content-disposition: attachment; filename=\"" . basename($file) . "\"");
                readfile($file);
            }
            foreach ($file_names as $file) {
                unlink($file);
            }
            foreach ($file_namess as $file) {
                unlink($file);
            }
        } elseif ($dem >= 2) {
            $ngay = $date['mday'] . $date['mon'] . $date['year'] . $date['hours'] . $date['minutes'] . $date['seconds'];
            $archive_file_name = $ngay . '.zip';
            $file_names = glob("source/convert/*");
            $file_namess = glob("source/image/*");
            $file_path =  'source/convert/';
            $zip = new ZipArchive();
            $zip->open($archive_file_name, ZipArchive::CREATE);
            foreach ($file_names as $file) {
                $zip->addFile($file_path . basename($file));
            }
            $zip->close();

            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=$archive_file_name");
            header("Content-length: " . filesize($archive_file_name));
            header("Pragma: no-cache");
            header("Expires: 0");
            readfile("$archive_file_name");


            foreach ($file_names as $file) {
                unlink($file);
            }
            foreach ($file_namess as $file) {
                unlink($file);
            }
            $status = unlink("'D:\xampp\htdocs\project\ConvertMultipleImg\public\'.$archive_file_name");

            if ($status) {
                echo "File bị xóa thành công!";
            } else {
                echo "Error: File không bị xóa.";
            }
        }
        return response()->json([
            "status" => 200,
            "message" => "Download successfully"
        ]);
    }

    // Định dang kích thước hình ảnh
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }
        return $bytes;
    }

    // Nhánh duck
    // Convert ảnh
    // function convertImage(Request $request)
    // {
    //     $request->validate([
    //         "typeImage" => "required"
    //     ]);
    //     $image_quality = 100;
    //     $imageConvertedId = []; // array image convert id
    //     if ($request->hasFile('files')) {
    //         // get request data
    //         $files = $request->file('files');
    //         $typeTarget = $request->typeImage;

    //         $target_dir = "source/convert/" . Auth::user()->id . "/"; // đường dẫn lưu trữ ảnh đã convert

    //         // get current date
    //         $date = getdate();
    //         $dateFormat = $date['mday'] . $date['mon'] . $date['year'];

    //         for ($i = 0; $i < count($files); $i++) {
    //             // file input name and extension
    //             $fileName = $files[$i]->getClientOriginalName();
    //             $extension = $files[$i]->getClientOriginalExtension();
    //             $size = $files[$i]->getSize();

    //             // create converted image's name
    //             $fileOriginName = basename($fileName, '.' . $extension);
    //             $only_name1 = $fileOriginName . '_' . $dateFormat . '_' . Str::random(7);

    //             // start covert image
    //             $binary = imagecreatefromstring(file_get_contents($files[$i]));
    //             $newName = $only_name1 . '.' . $typeTarget[$i];

    //             ob_start(); //Tạo một bộ đệm đầu ra mới và thêm nó vào đầu ngăn xếp.

    //             // convert image
    //             switch ($typeTarget[$i]) {
    //                 case "webp":
    //                     imagewebp($binary, $target_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
    //                     imagewebp($binary, NULL, 100);
    //                     break;
    //                 case "gif":
    //                     imagegif($binary, $target_dir . $only_name1 . '.' . $typeTarget[$i]);
    //                     imagegif($binary, NULL);
    //                     break;
    //                 case "png":
    //                     imagepng($binary, $target_dir . $only_name1 . '.' . $typeTarget[$i]);
    //                     imagepng($binary, NULL);
    //                     break;
    //                 default: //jpeg
    //                     imagejpeg($binary, $target_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
    //                     imagejpeg($binary, NULL, 100);
    //             }

    //             $cont = ob_get_contents(); //  Trả về nội dung của bộ đệm đầu ra trên cùng.
    //             ob_end_clean(); // - Trả về tất cả nội dung của bộ đệm đầu ra trên cùng & xóa nội dung khỏi bộ đệm.
    //             imagedestroy($binary);
    //             $content = imagecreatefromstring($cont);
    //             $output = $target_dir . $newName;

    //             switch ($typeTarget[$i]) {
    //                 case "webp":
    //                     imagewebp($content, $output);
    //                     break;
    //                 case "gif":
    //                     imagegif($content, $output);
    //                     break;
    //                 case "png":
    //                     imagepng($content, $output);
    //                     break;
    //                 default: //jpeg
    //                     imagejpeg($content, $output);
    //             }
    //             imagedestroy($content);

    //             // Save image info to database
    //             $duckImage = new DuckImage();
    //             $duckImage->name = $newName;
    //             $duckImage->user_id = Auth::user()->id;
    //             $duckImage->size_before = $size;
    //             $duckImage->size_after = filesize($output);
    //             $duckImage->save();

    //             array_push($imageConvertedId, $duckImage);
    //         }

    //         return response()->json([
    //             "status" => 200,
    //             "message" => "Data Img converted successfully",
    //             "data" => $imageConvertedId
    //         ]);
    //     } else {
    //         return response()->json([
    //             "status" => 406,
    //             "message" => "Cannot find File(s) uploaded"
    //         ], 406);
    //     }
    // }
    function convertImage(Request $request)
    {
        $request->validate([
            "typeImage" => "required"
        ]);

        $imageConvertedData = []; // array image convert data
        if ($request->hasFile('files')) {
            // get request data
            $files = $request->file('files');
            $typeTarget = $request->typeImage;

            if(count($files) == count($typeTarget)){
                $target_dir = public_path("source/convert/" . Auth::user()->id . "/"); // đường dẫn lưu trữ ảnh đã convert

                // get current date
                $date = getdate();
                $dateFormat = $date['mday'] . $date['mon'] . $date['year'];
    
                for ($i = 0; $i < count($files); $i++) {
                    // get image data
                    $fileName = $files[$i]->getClientOriginalName();
                    $extension = $files[$i]->getClientOriginalExtension();
                    $size = $files[$i]->getSize();
    
                    // save image to disk
                    $img = Image::make($files[$i]->getRealPath());
                    $img->stream();
                    $diskImagePath = Auth::user()->id . "/" . $fileName;
                    Storage::disk('local')->put(Auth::user()->id . "/" . $fileName, $img, 'public');
    
                    // create new image name
                    $fileOriginName = basename($fileName, '.' . $extension);
                    $only_name1 = $fileOriginName . '_' . $dateFormat . '_' . Str::random(7);
                    $newName = $only_name1 . '.' . $typeTarget[$i];
    
                    // save to table
                    $duckImage = new DuckImage();
                    $duckImage->name = $newName;
                    $duckImage->user_id = Auth::user()->id;
                    $duckImage->size_before = $size;
                    $duckImage->save();

                    $duckImage->name = $_SERVER['APP_URL'] . "/source/convert/" . Auth::user()->id . "/" . $newName;
    
                    // start convert image
                    ProcessConvertImage::dispatch($typeTarget[$i], $target_dir, $only_name1, $diskImagePath, $duckImage->id);
    
                    array_push($imageConvertedData, $duckImage);
                }
    
                return response()->json([
                    "status" => 200,
                    "message" => "Data Image(s) converted successfully",
                    "data" => $imageConvertedData
                ], 200);
            } else{
                return response()->json([
                    "status" => 403,
                    "message" => "Files uploads and Type target must be equal"
                ], 403);
            } 
        } else {
            return response()->json([
                "status" => 406,
                "message" => "Cannot find File(s) uploaded"
            ], 406);
        }
    }

    // Tải hình ảnh
    public function downloadImage(Request $request)
    {
        // get id input
        $imageIds = $request->ids;

        if (count($imageIds) == 1) {
            if (DuckImage::where([['id', $imageIds[0]], ['user_id', Auth::user()->id]])->exists()) {
                $image = DuckImage::where('id', $imageIds[0])->first();
                $imagePath = "source/convert/" . Auth::user()->id . "/" . $image->name;

                return response()->json([
                    "status" => 200,
                    "message" => "Download successfully",
                    "data" => $_SERVER['APP_URL'] . "/" . $imagePath
                ], 200);
            } else {
                return response()->json([
                    "status" => 404,
                    "message" => "Image not found"
                ], 404);
            }
        } else {
            // zip file if multiple images

            // check images exist
            foreach ($imageIds as $id) {
                if (!DuckImage::where([['id', $id], ['user_id', Auth::user()->id]])->exists()) {
                    return response()->json([
                        "status" => 404,
                        "message" => "Image not found"
                    ], 404);
                }
            }

            // create zip file name
            $date = getdate();
            $ngay = $date['mday'] . $date['mon'] . $date['year'] . "_" . Str::random(7);;
            $archiveFileName = $ngay . '.zip';

            // zip images
            $zip = new ZipArchive();
            $zip->open($archiveFileName, ZipArchive::CREATE);
            if ($zip->open(public_path("source/zip/" . $archiveFileName), ZipArchive::CREATE) === TRUE) {
                foreach ($imageIds as $id) {
                    $image = DuckImage::where('id', $id)->first();
                    $imagePath = "source/convert/" . Auth::user()->id . "/" . $image->name;
                    $zip->addFile($imagePath, $image->name);
                }
                $zip->close();
            }

            return response()->json([
                "status" => 200,
                "message" => "Download successfully",
                "data" => $_SERVER['APP_URL'] . "/" .  "source/zip/" . $archiveFileName
            ], 200);
        }
    }

    // Xóa nền
    public function removeBackground(Request $request)
    {
        if ($request->hasFile('files')) {
            $file = $request->file('files')[0];
            $fileName = $file->getClientOriginalName();

            // move uploaded file to folder
            $randomString = Str::random(7);
            $file->move(public_path('source/remove-background'), $randomString . "_" . $fileName);

            $imagePath = "source/remove-background/" . $randomString . "_" . $fileName;
            $imageRemovedBackgroundPath = "source/remove-background/" . $randomString . "_" .  "remove_bg" . "_" . $fileName;

            $client = new \GuzzleHttp\Client;
            $res = $client->post('https://api.remove.bg/v1.0/removebg', [
                'multipart' => [
                    [
                        'name'     => 'image_file',
                        'contents' => fopen($imagePath, 'r')
                    ],
                    [
                        'name'     => 'size',
                        'contents' => 'auto'
                    ]
                ],
                'headers' => [
                    'X-Api-Key' => env("REMOVE_BG_API_KEY")
                ]
            ]);
            
            $fp = fopen($imageRemovedBackgroundPath, "wb");
            fwrite($fp, $res->getBody());
            fclose($fp);

            return response()->json([
                "status" => 200,
                "message" => "Remove background successfully",
                "data" => $_SERVER['APP_URL'] . "/" . $imageRemovedBackgroundPath
            ], 200);
        } else{
            return response()->json([
                "status" => 406,
                "message" => "Cannot find File uploaded"
            ], 406);
        }
    }

    // Resize ảnh
    public function resizeImage(Request $request)
    {
        $request->validate([
            "percentage" => "required"
        ]);

        if ($request->hasFile('files')) {
            // get input data
            $file = $request->file('files')[0];
            $fileName = $file->getClientOriginalName();
            $percentage = $request->percentage;
            $randomString = Str::random(7);

            $imagePath = "source/resize/" . $randomString . "_" . "resize" . "_" . $fileName;

            // create image
            $img = Image::make($file->path());

            // resize image
            $img->resize($img->width() * ($percentage / 100), $img->height() * ($percentage / 100), function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($imagePath);

            return response()->json([
                "status" => 200,
                "message" => "Resize image successfully",
                "data" => $_SERVER['APP_URL'] . "/" . $imagePath
            ], 200);
        } else{
            return response()->json([
                "status" => 406,
                "message" => "Cannot find File uploaded"
            ], 406);
        }
    }
}
