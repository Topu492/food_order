<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Gallery;
use App\Models\Menu;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function RestaurantDetails($id)
    {
        $client = Client::find($id);
        $menus  = Menu::where('client_id', $client->id)->get()->filter(function ($menu) {
            return $menu->products->isNotEmpty();
        });
        $gallerys = Gallery::where('client_id', $id)->get();
        return view('frontend.details_page', compact('client', 'menus', 'gallerys'));
    }

    public function AddWishList(Request $request, $id)
    {
        if (Auth::check()) {
            $exists = Wishlist::where('user_id', Auth::id())->where('client_id', $id)->first();
            if (! $exists) {
                Wishlist::insert([
                    'user_id'    => Auth::id(),
                    'client_id'  => $id,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json(['success' => 'Your Wishlist Addedd Successfully']);
            } else {
                return response()->json(['error' => 'This product has already on your wishlist']);
            }
        } else {
            return response()->json(['error' => 'First Login Your Account']);
        }

    }

    public function AllWishlist()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->get();
        return view('frontend.dashboard.all_wishlist', compact('wishlist'));
    }
    //End Method

    public function RemoveWishlist($id){
        Wishlist::find($id)->delete();

        $notification = array(
            'message' => 'Wishlist Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
     //End Method
}
