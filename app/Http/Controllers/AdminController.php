<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthAdmin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
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

    public function brand_update(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'. $request->id,
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $brand = Brand::find($request->id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if($request->hasFile('image')){
            if(File::exists(public_path('uploads/brands'). '/' . $brand->image)){
                File::delete(public_path('uploads/brands'). '/' . $brand->image);
            }
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateBrandsThumbnailsImage($image, $file_name);
            $brand->image = $file_name;
        }
        
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand has been updated succesfully!');

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

    public function brand_delete($id){
        $brand = Brand::find($id);
        if(File::exists(public_path('uploads/brands'). '/' . $brand->image)){
            File::delete(public_path('uploads/brands'). '/' . $brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status', 'Brand has been deleted succesfully!');
    }

    public function categories(){
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function category_add(){
        return view('admin.categories.category_add');
    }

    public function category_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $image->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->GenerateCategoriesThumbnailsImage($image, $file_name);
        $category->image = $file_name;
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category has been added succesfully!');
    }

    public function GenerateCategoriesThumbnailsImage($image, $imageName){
        $destPath = public_path('uploads/categories');
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function($const){
            $const->aspectRatio();
        });
        $img->save($destPath. '/'. $imageName);
    }

    public function category_edit($id){
        $category = Category::find($id);
        return view('admin.categories.category_edit', compact('category'));
    }

    public function category_update(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'. $request->id,
            'image' => 'mimes:png,jpg,jpeg|max:2048'
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if($request->hasFile('image')){
            if(File::exists(public_path('uploads/categories'). '/' . $category->image)){
                File::delete(public_path('uploads/categories'). '/' . $category->image);
            }
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateCategoriesThumbnailsImage($image, $file_name);
            $category->image = $file_name;
        }

        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category has been updated succesfully!');
    }

    public function category_delete($id){
        $category = Category::find($id);
        if(File::exists(public_path('uploads/categories'). '/' . $category->image)){
            File::delete(public_path('uploads/categories'). '/' . $category->image);
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Category has been deleted succesfully!');

    }

    public function products(){
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function product_add(){
        $categories = Category::select('id', 'name')->orderBy('name', 'DESC')->get();
        $brands = Brand::select('id', 'name')->orderBy('name', 'DESC')->get();
        return view('admin.products.add', compact('categories', 'brands'));
    }

    public function product_store(Request $request){
        $request->validate([
            'name' => "required",
            'slug' => "required|unique:products,slug",
            'short_description' => "required",
            'description' => "required",
            'regular_price' => "required",
            'sale_price' => "required",
            'SKU' => "required",
            'stock_status' => "required",
            'featured' => "required",
            'quantity' => "required",
            'image' => "required|mimes:png,jpg,jpeg|max:2048",
            'category_id' => "required",
            'brand_id' => "required"
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->slug);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = $current_timestamp . $image->extension();
            $this->GenerateProductImageThumbnail($image, $imageName);
            $product->image = $imageName;
        }
    }

    public function GenerateProductImageThumbnail($image, $imageName){
        $destPath = public_path('uploads/products');
        $destPathThumbnail = public_path('uploads/products/thumbnails');
        $img = Image::read($image->path());
        $img->cover(540, 689, "top");
        $img->resize(540, 689, function($const){
            $const->aspectRatio();
        });
        $img->save($destPath. '/'. $imageName);

        $img->resize(124, 124, function($const){
            $const->aspectRatio();
        });
        $img->save($destPathThumbnail. '/'. $imageName);
    }

}
