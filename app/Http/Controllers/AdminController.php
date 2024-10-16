<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthAdmin;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{

    public function __construct(){
        // $this->middleware(AuthAdmin::class);
    }

    public function index(){
        return view('admin.index.index');
    }

    public function brands(){
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function brand_add(){
        return view('admin.brands.brand_add');
    }

    public function brand_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $image->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->GenerateBrandsThumbnailsImage($image, $file_name);
        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand has been added succesfully!');
    }

    public function brand_edit($id){
        $brand = Brand::find($id);
        return view('admin.brands.brand_edit', compact('brand'));
    }

    public function GenerateBrandsThumbnailsImage($image, $imageName){
        $destPath = public_path('uploads/brands');
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function($const){
            $const->aspectRatio();
        });
        $img->save($destPath. '/'. $imageName);
    }
}
