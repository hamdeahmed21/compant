<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Multipic;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }



    public function AllBrand(){

        $brands = Brand::latest()->paginate(5);
        return view('backend.brand.index' , compact('brands'));
    }


    public function StoreBrand(Request $request){
        $validatedData = $request->validate([
            'brand_name' => 'required|unique:brands|min:4',
            'brand_image' => 'required|mimes:jpg.jpeg,png',

        ],
            [
                'brand_name.required' => 'Please Input Brand Name',
                'brand_image.min' => 'Brand Longer then 4 Characters',
            ]);

        $brand_image =  $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(300,200)->save('image/brand/'.$name_gen);

        $last_img = 'image/brand/'.$name_gen;

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Brand Inserted Successfully',
            'alert-type' => 'success'
        );

        return Redirect()->route('all.brand')->with($notification);

    }


    public function Edit($id){
        $brands = Brand::find($id);
        return view('backend.brand.edit',compact('brands'));

    }


    public function Update(Request $request, $id){

        $validatedData = $request->validate([
            'brand_name' => 'required|min:4',

        ],
            [
                'brand_name.required' => 'Please Input Brand Name',
                'brand_image.min' => 'Brand Longer then 4 Characters',
            ]);

        $old_image = $request->old_image;

        $brand_image =  $request->file('brand_image');

        if($brand_image){

            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen.'.'.$img_ext;
            $up_location = 'image/brand/';
            $last_img = $up_location.$img_name;
            $brand_image->move($up_location,$img_name);

            unlink($old_image);
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $last_img,
                'created_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Brand Updated Successfully',
                'alert-type' => 'info'
            );
            return Redirect()->route('all.brand')->with($notification);

        }else{
            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'created_at' => Carbon::now()
            ]);
            $notification = array(
                'message' => 'Brand Updated Successfully',
                'alert-type' => 'warning'
            );

            return Redirect()->route('all.brand')->with($notification);

        }
    }


    public function Delete($id){
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        unlink($old_image);

        Brand::find($id)->delete();
        $notification = array(
            'message' => 'Brand Delete Successfully',
            'alert-type' => 'error'
        );
        return Redirect()->back()->with($notification);

    }


    //// This is for Multi Image All Methods

    public function Multpic(){
        $images = Multipic::all();
        return view('backend.multipic.index',compact('images'));
    }


    public function StoreImg(Request $request){

        $image =  $request->file('image');

        foreach($image as $multi_img){

            $name_gen = hexdec(uniqid()).'.'.$multi_img->getClientOriginalExtension();
            Image::make($multi_img)->resize(300,300)->save('image/multi/'.$name_gen);

            $last_img = 'image/multi/'.$name_gen;

            Multipic::insert([

                'image' => $last_img,
                'created_at' => Carbon::now()
            ]);
        } // end of the foreach



        return Redirect()->back()->with('success','Brand Inserted Successfully');


    }
}
