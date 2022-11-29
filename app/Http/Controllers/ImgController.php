<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessConvertImage;
use App\Models\DuckImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;
use Intervention\Image\Facades\Image;

class ImgController extends Controller
{
    // Nhánh duck
    // Convert ảnh
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

            if (count($files) == count($typeTarget)) {
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
                    $only_name1 = Auth::user()->company . '_' . $dateFormat . '_' . Str::random(7);
                    $newName = $only_name1 . '.' . $typeTarget[$i];

                    // save to table
                    $duckImage = new DuckImage();
                    $duckImage->name = $newName;
                    $duckImage->user_id = Auth::user()->id;
                    $duckImage->size_before = $size;
                    $duckImage->save();

                    // create response data
                    $responseData = new DuckImage();
                    $responseData->id = $duckImage->id;
                    $responseData->name = $_SERVER['APP_URL'] . "/source/convert/" . Auth::user()->id . "/" . $newName;
                    $responseData->size_before = $size;

                    // start convert image
                    ProcessConvertImage::dispatch($typeTarget[$i], $target_dir, $only_name1, $diskImagePath, $duckImage->id);

                    array_push($imageConvertedData, $responseData);
                }

                return response()->json([
                    "status" => 200,
                    "message" => "Data Image(s) converted successfully",
                    "data" => $imageConvertedData
                ], 200);
            } else {
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
        $request->validate([
            "ids" => "required"
        ]);

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
            $extension = $file->getClientOriginalExtension();

            // move uploaded file to folder
            $randomString = Str::random(10);
            $file->move(public_path('source/remove-background'), $randomString . "." . $extension);

            $imagePath = "source/remove-background/" . $randomString . "." . $extension;
            $imageRemovedBackgroundPath = "source/remove-background/" . Auth::user()->company . "_" . $randomString . "_" .  "remove_bg" . "." . $extension;

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
        } else {
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
            "percentage" => "required|integer|min:1|max:99"
        ]);

        if ($request->hasFile('files')) {
            // get input data
            $file = $request->file('files')[0];
            $extension = $file->getClientOriginalExtension();
            $percentage = $request->percentage;
            $randomString = Str::random(10);

            $imagePath = "source/resize/" . Auth::user()->company . "_" . $randomString . "_" . "resize" . "." . $extension;

            // create image
            $img = Image::make($file->path());

            // resize image
            $img->resize($img->width() * (1 - $percentage / 100), $img->height() * (1 - $percentage / 100), function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($imagePath);

            return response()->json([
                "status" => 200,
                "message" => "Resize image successfully",
                "data" => $_SERVER['APP_URL'] . "/" . $imagePath
            ], 200);
        } else {
            return response()->json([
                "status" => 406,
                "message" => "Cannot find File uploaded"
            ], 406);
        }
    }

    // Lấy toàn bộ ảnh từ Google Drive
    public function getGoogleDriveFile()
    {
        $driveService = Storage::disk('google');
        $query = "'" . env("GOOGLE_DRIVE_FOLDER_ID") . "' in parents and trashed=false";

        $optParams = [
            'fields' => 'nextPageToken, files(id, name, size)',
            'q' => $query
        ];

        $results = $driveService->files->listFiles($optParams);

        return response()->json([
            "status" => 200,
            "message" => "Get file successfully",
            "data" => $results->getFiles()
        ], 200);
    }

    // Convert ảnh từ Google Drive
    public function convertGoogleDriveFile(Request $request)
    {
        $request->validate([
            "typeImage" => "required"
        ]);

        $typeTarget = $request->typeImage;

        // get all file from Drive
        $driveService = Storage::disk('google');
        $query = "'" . env("GOOGLE_DRIVE_FOLDER_ID") . "' in parents and trashed=false";
        $optParams = [
            'fields' => 'nextPageToken, files(id, name, size)',
            'q' => $query
        ];
        $results = $driveService->files->listFiles($optParams);
        $files = $results->getFiles();

        $imageConvertedData = []; // array image convert data

        foreach ($files as $file) {
            // get image data
            $fileId = $file->id;
            $fileName = $file->name;
            $fileSize = $file->size;
            $target_dir = public_path("source/convert/" . Auth::user()->id . "/"); // đường dẫn lưu trữ ảnh đã convert
            $fileOriginName = explode('.', $fileName)[0];

            // download all file from Drive
            $file = $driveService->files->get($fileId, array(
                'alt' => 'media'
            ));
            $file =  $file->getBody()->getContents();

            // get current date
            $date = getdate();
            $dateFormat = $date['mday'] . $date['mon'] . $date['year'];

            // create new name
            $only_name1 = $fileOriginName . '_' . $dateFormat . '_' . Str::random(7);
            $diskImagePath = Auth::user()->id . "/" . $fileName;
            $newName = $only_name1 . '.' . $typeTarget;

            // save to table
            $duckImage = new DuckImage();
            $duckImage->name = $newName;
            $duckImage->user_id = Auth::user()->id;
            $duckImage->size_before = $fileSize;
            $duckImage->save();

            // create response data
            $responseData = new DuckImage();
            $responseData->id = $duckImage->id;
            $responseData->name = $_SERVER['APP_URL'] . "/source/convert/" . Auth::user()->id . "/" . $newName;
            $responseData->size_before = $fileSize;
            array_push($imageConvertedData, $responseData);

            // save file to Storage
            Storage::disk('local')->put(Auth::user()->id . "/" . $fileName, $file, 'public');

            // start convert image
            ProcessConvertImage::dispatch($typeTarget, $target_dir, $only_name1, $diskImagePath, $duckImage->id);
        }

        return response()->json([
            "status" => 200,
            "message" => "Convert file successfully",
            "data" => $imageConvertedData
        ], 200);
    }

    // Xóa toàn bộ ảnh của người dùng hiện tại
    public function deleteAllFile()
    {
        $userDir = public_path("source/convert/" . Auth::user()->id . "/");
        $imageData =  DuckImage::where("user_id", Auth::user()->id)->get();

        if (count($imageData) != 0) {
            foreach ($imageData as $image) {
                if (file_exists($userDir . $image->name)) {
                    unlink($userDir . $image->name);
                }
            }
            DuckImage::where("user_id", Auth::user()->id)->delete();

            return response()->json([
                "status" => 200,
                "message" => "Image(s) Delete successfully"
            ], 200);
        } else {
            return response()->json([
                "status" => 203,
                "message" => "No Image(s) found"
            ], 203);
        }
    }

    // Tạo thumbnail
    public function createThumbnail(Request $request){
        $request->validate([
            "size" => "required|integer" // 0 - small | 1 - medium | 2 - large
        ]);

        if ($request->hasFile('files')) {
            // get input data
            $file = $request->file('files')[0];
            $extension = $file->getClientOriginalExtension();
            $size = $request->size;
            $randomString = Str::random(10);

            $imagePath = "source/thumbnail/" . Auth::user()->company . "_" . $randomString . "_" . "thumbnail" . "." . $extension;

            // create image
            $img = Image::make($file->path());

            // create thumbnail
            switch ($size) {
                case 1: // 1 - medium
                    $img->resize(300, 185, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                  break;
                case 2: // 2 - large
                    $img->resize(550, 340, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                  break;
                default: // 0 - small
                $img->resize(150, 93, function ($constraint) {
                    $constraint->aspectRatio();
                });
              }
            $img->save($imagePath);

            return response()->json([
                "status" => 200,
                "message" => "Resize image successfully",
                "data" => $_SERVER['APP_URL'] . "/" . $imagePath
            ], 200);
        } else {
            return response()->json([
                "status" => 406,
                "message" => "Cannot find File uploaded"
            ], 406);
        }
    }
}
