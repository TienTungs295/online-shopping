<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class UploadRestController extends Controller
{
    public function storeImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        $file_path = "uploads/images/";
        $sub_folder = $request->input("sub-folder");
        if (!empty($sub_folder)) $file_path .= $sub_folder . "/" . date('Y-m-d') . "/";
        else $file_path .= "products/" . date('Y-m-d') . "/";
        $file = $request->file('file');
        $original_name = $file->getClientOriginalName();
        $dotPosition = strripos($original_name, ".");
        $image_format = substr($original_name, $dotPosition, strlen($original_name) - $dotPosition);
        $image_name = substr($original_name, 0, strlen($original_name) - (strlen($original_name) - $dotPosition));
        $file_name = Str::slug($image_name) . '_' . time() . "_" . random_int(100000, 999999) . $image_format;
        $file->move($file_path, $file_name);
        return response()->json(["data" => ["status" => "success", "file_path" => $file_path . $file_name, "file_name" => $file_name]]);
    }
}
