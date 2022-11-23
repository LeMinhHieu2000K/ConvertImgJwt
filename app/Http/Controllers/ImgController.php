<?php

namespace App\Http\Controllers;

use App\Models\Img;
use App\Models\ImgAfter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use ZipArchive;

class ImgController extends Controller
{
    public function postRegister(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "phone" => "required",
            "password" => "required|confirm",
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            "role" => "required"

        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();

        $emailTarget = $request->email; // email thằng nhận

        // gửi email thông báo đăng ký thành công
        Mail::send(
            'testMail',
            ['name' => $request->name, 'email' => $request->email, 'password' => $request->password],
            function ($email) use ($emailTarget) { // phải dùng phương thức use mới dùng được biến $emailTarget
                $email->subject('Chúc mừng bạn đã đăng ký thành công');
                $email->to($emailTarget);
            }
        );
        return response()->json([
            "status"=>1,
            "message"=> "user registered successfully"
        ],200);
    }

   
    public function postLogin(Request $request)
    {
         // validation
         $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // verify user + token
        if (!$token = auth('api')->attempt(["email" => $request->email, "password" => $request->password])) {

            return response()->json([
                "status" => 0,
                "message" => "Invalid credentials"
            ]);
        }

        // send response
        return response()->json([
            "status" => 200,
            "message" => "Logged in successfully",
            "access_token" => $token,
            "role" =>  Auth::user()->role
        ]);
    }

    public function getLogout(Request $request)
    {
        auth()->logout();

        return response()->json([
            "status" => 200,
            "message" => "User logged out"
        ]);
    }


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
            ]);
        } else {
            return response()->json([
                "message" => "ko có file"
            ]);
        }
    }

    public function getImageData()
    {
        $imgData = Img::all();
        return response()->json([
            "status" => 200,
            "message" => "Data Img",
            "data" => $imgData
        ]);
    }

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

    public function convertImageData(Request $request, $image_quality = 100)
    {
        $typeTarget = $request->typecanchuyen; // kiểu cần chuyển
        $nameImg = $request->name_img; // tên ban đầu
        $typeOriginal = $request->type_img; // kiểu ban đầu
        $count = 0;
        $idImg = $request->id_img;
        foreach ($idImg as $id) {
            $count++;
        }

        for ($i = 0; $i < $count; $i++) // lap ten ban dau
        {
            $nameImg[$i];
            $typeOriginal[$i];
            $typeTarget[$i];
            $dir = 'source/image/'; // đường dẫn ban đầu
            $target_dir = "source/convert/"; // đường dẫn lưu trữ ảnh đã convert
            $image = $dir . $nameImg[$i]; // tạo ảnh
            $date = getdate();
            $ngay = $date['mday'] . $date['mon'] . $date['year'];
            $only_name = basename($image, '.' . $typeOriginal[$i]);
            $only_name1 = $only_name.'_'.$ngay.'_'.$i;

            if ($typeTarget[$i] == 'gif') {
                $binary = imagecreatefromstring(file_get_contents($image));
                imageGif($binary, $target_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
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
            }

            if ($typeTarget[$i] == 'webp') {
                $binary = imagecreatefromstring(file_get_contents($image));
                imagewebp($binary, $target_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
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
            }
            if ($typeTarget[$i] == 'png') {
                $binary = imagecreatefromstring(file_get_contents($image));
                imagepng($binary, $target_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
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
            }

            if ($typeTarget[$i] == 'jpg') {
                $binary = imagecreatefromstring(file_get_contents($image));
                imagejpeg($binary, $target_dir . $only_name1 . '.' . $typeTarget[$i], $image_quality);
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
            }
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
        }
        $ImgAfter = ImgAfter::all();

        // XÓA DỮ LIỆU BẢNG img và img After
        $idImg = $request->id_img; // id ảnh
        foreach ($idImg as $id) {
            $delete_Img = Img::where('id', $id)->delete();
            $delete_ImgAfter = ImgAfter::where('id_img', $id)->delete();
        }
        return response()->json([
            "status" => 200,
            "message" => "Data Img converted successfully",
            "data" => $ImgAfter
        ]);
    }

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
}
