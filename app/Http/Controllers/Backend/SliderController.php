<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\slider;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function HomeSlider(){
        $sliders = Slider::latest()->get();
        return view('backend.slider.index', compact('sliders'));
    }

    public function AddSlider(){
        return view('backend.slider.create');
    }

    public function StoreSlider(Request $request){

        $slider_image =  $request->file('image');


        $name_gen = hexdec(uniqid()).'.'.$slider_image->getClientOriginalExtension();
        Image::make($slider_image)->resize(1920,1088)->save('image/slider/'.$name_gen);

        $last_img = 'image/slider/'.$name_gen;

        Slider::insert([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->route('home.slider')->with('success','Slider Inserted Successfully');

    }
  public function editSlider($id)
{
    $sliders = slider::find($id);
    return view('backend.slider.edit',compact('sliders'));
}
    public function updateSlider(Request $request,$id)
    {
        $old_image = $request->old_image;

        $slider_image = $request->file('image');

        if ($slider_image) {

            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($slider_image->getClientOriginalExtension());
            $img_name = $name_gen . '.' . $img_ext;
            $up_location = 'image/slider/';
            $last_img = $up_location . $img_name;
            $slider_image->move($up_location, $img_name);

            unlink($old_image);
            slider::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $last_img,
                'created_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Brand Updated Successfully',
                'alert-type' => 'info'
            );
            return Redirect()->route('home.slider')->with($notification);

        } else {
            slider::find($id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'created_at' => Carbon::now()
            ]);
            $notification = array(
                'message' => 'Slider Updated Successfully',
                'alert-type' => 'warning'
            );

            return Redirect()->route('home.slider')->with($notification);
        }
    }
    public function deleteSlider($id){
        $image = slider::find($id);
        $old_image = $image->image;
        unlink($old_image);

        slider::find($id)->delete();
        $notification = array(
            'message' => 'Slider Delete Successfully',
            'alert-type' => 'error'
        );
        return Redirect()->back()->with($notification);

    }

}
