<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class GalleryController extends Controller
{
    public function AllGallery()
    {
        $id  = Auth::guard('client')->id();
        $gallery = Gallery::where('client_id', $id)->orderBy('id', 'desc')->get();
        return view('client.backend.gallery.all_gallery', compact('gallery'));
    }
    // End Method

    public function AddGallery()
    {
        return view('client.backend.gallery.add_gallery');
    }

    public function StoreGallery(Request $request)
    {

        $images = $request->file('gallery_img');

        foreach ($images as $gimg) {

            $manager  = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $gimg->getClientOriginalExtension();
            $img      = $manager->read($gimg);
            $img->resize(500, 500)->save(public_path('upload/gallery/' . $name_gen));
            $save_url = 'upload/gallery/' . $name_gen;

            Gallery::insert([
                'client_id'   => Auth::guard('client')->id(),
                'gallery_img' => $save_url,
            ]);
        } // end foreach

        $notification = [
            'message'    => 'Gallery Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.gallery')->with($notification);

    }
    // End Method

    public function EditGallery($id)
    {
        $gallery = Gallery::find($id);
        return view('client.backend.gallery.edit_gallery', compact('gallery'));
    }
    // End Method

    public function UpdateGallery(Request $request)
    {

        $gallery_id = $request->id;

        if ($request->hasFile('gallery_img')) {
            $image    = $request->file('gallery_img');
            $manager  = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img      = $manager->read($image);
            $img->resize(500, 500)->save(public_path('upload/gallery/' . $name_gen));
            $save_url = 'upload/gallery/' . $name_gen;

            $gallery = Gallery::find($gallery_id);
            if ($gallery->gallery_img) {
                $img = $gallery->gallery_img;
                unlink($img);
            }

            $gallery->update([
                'gallery_img' => $save_url,
            ]);

            $notification = [
                'message'    => 'Menu Updated Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.gallery')->with($notification);

        } else {

            $notification = [
                'message'    => 'No Image Selected for Update',
                'alert-type' => 'warning',
            ];

            return redirect()->back()->with($notification);
        }
    }
    // End Method

    public function DeleteGallery($id)
    {
        $item = Gallery::find($id);
        $img  = $item->gallery_img;
        unlink($img);

        Gallery::find($id)->delete();

        $notification = [
            'message'    => 'Gallery Delete Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);

    }
    // End Method
}
