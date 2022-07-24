<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->input('q');
        if ($q != "") {
            $blogs = Blog::where(function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            })->orderBy('id', 'DESC')
                ->paginate(25);
            $blogs->appends(['q' => $q]);
        } else {
            $blogs = Blog::paginate(25);
        }
        return View('backend.blog.index', compact("blogs", "q"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blog.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $blog = new Blog;
        $blog->name = $request->input('name');
        $blog->content = $request->input('content');

        $image_url = $request->input('image');
        if ($image_url != null && $image_url != "") {
            $start_position = strripos($image_url, "/") + 1;
            $image_url = substr($image_url, $start_position, strlen($image_url) - $start_position);
        }
        $blog->image = $image_url;
        $blog->author_id = 1;
        $blog->author_type = 1;
        $featured = $request->has("is_featured") ? 1 : 0;
        $blog->is_featured = $featured;
        $blog->save();

        return redirect()->route("blogView")->with('success', 'Thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $blog = Blog::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }
        return view('backend.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $blog = Blog::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route("blogView")->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $blog->name = $request->input('name');
        $blog->content = $request->input('content');
        $image_url = $request->input('image');
        if ($image_url != null && $image_url != "") {
            $start_position = strripos($image_url, "/") + 1;
            $image_url = substr($image_url, $start_position, strlen($image_url) - $start_position);
            if ($image_url != $blog->image) {
                $delete_url = 'uploads\images\\' . $blog->image;
                if (File::exists(public_path($delete_url))) {
                    File::delete(public_path($delete_url));
                }
            }
        }
        $blog->image = $image_url;
        $featured = $request->has("is_featured") ? 1 : 0;
        $blog->is_featured = $featured;
        $blog->update();
        return redirect()->route("blogView")->with('success', 'Thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $blog = Blog::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Đối tượng không tồn tại hoặc đã bị xóa');
        }

        $blog->delete();

        return redirect()->back()->with('success', 'Thành công');
    }
}
