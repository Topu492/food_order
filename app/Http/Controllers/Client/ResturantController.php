<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ResturantController extends Controller
{
    public function AllMenu()
    {
        $id   = Auth::guard('client')->id();
        $menu = Menu::where('client_id', $id)->orderBy('id', 'desc')->get();
        return view('client.backend.menu.all_menu', compact('menu'));
    }
    // End Method

    public function AddMenu()
    {
        return view('client.backend.menu.add_menu');

    }

    public function StoreMenu(Request $request)
    {

        if ($request->file('image')) {
            $image    = $request->file('image');
            $manager  = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img      = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/' . $name_gen));
            $save_url = 'upload/menu/' . $name_gen;

            Menu::create([
                'menu_name' => $request->menu_name,
                 'client_id' => Auth::guard('client')->id(),
                'image'     => $save_url,
            ]);
        }

        $notification = [
            'message'    => 'Menu Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.menu')->with($notification);

    }
    // End Method

    public function EditMenu($id)
    {
        $menu = Menu::find($id);
        return view('client.backend.menu.edit_menu', compact('menu'));
    }

    public function UpdateMenu(Request $request)
    {

        $menu_id = $request->id;

        if ($request->file('image')) {
            $image    = $request->file('image');
            $manager  = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img      = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/' . $name_gen));
            $save_url = 'upload/menu/' . $name_gen;

            Menu::find($menu_id)->update([
                'menu_name' => $request->menu_name,
                'image'     => $save_url,
            ]);
            $notification = [
                'message'    => 'Menu Updated Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.menu')->with($notification);

        } else {

            Menu::find($menu_id)->update([
                'menu_name' => $request->menu_name,
            ]);
            $notification = [
                'message'    => 'Menu Updated Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.menu')->with($notification);

        }

    }
    // End Method

    public function DeleteMenu($id)
    {
        $item = Menu::find($id);
        $img  = $item->image;
        unlink($img);

        Menu::find($id)->delete();

        $notification = [
            'message'    => 'Menu Delete Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);

    }
    // End Method

}
