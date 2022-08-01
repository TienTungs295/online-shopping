<?php

namespace App\Http\Controllers\Rests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadRestController extends Controller
{
    public function storeImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $file_path = "uploads/images/";
        $file = $request->file('file');
        $file_name = $file->getClientOriginalName();
        $file_name = time() . '_' . $file_name;
        $file->move($file_path, $file_name);
        return response()->json(["data" => ["status" => "success", "file_path" => $file_path . $file_name, "file_name" => $file_name]]);
    }
}
