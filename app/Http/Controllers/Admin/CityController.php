<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function AllCity()
    {
        $city = City::latest()->get();
        return view('admin.backend.city.all_city', compact('city'));
    }

    public function StoreCity(Request $request)
    {

        City::create([
            'city_name' => $request->city_name,
            'city_slug' => strtolower(str_replace(' ', '-', $request->city_name)),
        ]);

        $notification = [
            'message'    => 'City Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);

    }
    // End Method

    public function EditCity($id)
    {
        $city = City::find($id);
        return response()->json($city);
    }

    public function UpdateCity(Request $request){
        $cat_id = $request->cat_id;

        City::find($cat_id)->update([
               'city_name' => $request->city_name,
               'city_slug' =>  strtolower(str_replace(' ','-',$request->city_name)), 
           ]);  
       

       $notification = array(
           'message' => 'City Updated Successfully',
           'alert-type' => 'success'
       );

       return redirect()->back()->with($notification);
                  
   }
   // End Method 


    public function DeleteCity($id){
      City::find($id)->delete();

      $notification = array(
        'message' => 'City Deleted Successfully',
        'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);

   }
    // End Method 
}
