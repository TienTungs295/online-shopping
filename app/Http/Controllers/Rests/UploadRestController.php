<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;


class UploadRestController extends Controller
{
    public function storeImage(Request $request)
    {
        $file = $request->file('file');
        if (is_null($file)) {
            return response()->json(["data" => ["status" => "error", "message" => "File upload không hợp lệ"]]);
        }
        $max_size = 4 * 1024 * 1024;
        if ($file->getSize() > $max_size){
            return response()->json(["data" => ["status" => "error", "message" => "File upload không được quá 2MB"]]);
        }
        $valid_extensions = ["png", "jpg", "jpeg"];
        $original_name = $file->getClientOriginalName();
        if (!is_null($original_name)) {
            $start_position = strpos($original_name, ".") + 1;
            $extension = substr($original_name, $start_position, strlen($original_name) - $start_position);
            if (!in_array($extension, $valid_extensions)) {
                return response()->json(["data" => ["status" => "error", "message" => "Định dạng ảnh phải là png | jpg | jpeg"]]);
            }
        }

        $file_path = "uploads/images/";
        $sub_folder = $request->input("sub-folder");
        if (!empty($sub_folder)) $file_path .= $sub_folder . "/" . date('Y-m-d') . "/";
        else $file_path .= "products/" . date('Y-m-d') . "/";
        $dotPosition = strripos($original_name, ".");
        $image_format = substr($original_name, $dotPosition, strlen($original_name) - $dotPosition);
        $image_name = substr($original_name, 0, strlen($original_name) - (strlen($original_name) - $dotPosition));
        $file_name = Str::slug($image_name) . '_' . time() . "_" . random_int(100000, 999999) . $image_format;
        $file->move($file_path, $file_name);
        return response()->json(["data" => ["status" => "success", "file_path" => $file_path . $file_name, "file_name" => $file_name]]);
    }
}
