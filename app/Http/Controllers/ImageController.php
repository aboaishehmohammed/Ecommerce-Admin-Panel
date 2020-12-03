<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,svg',
        ]);
        $upload_path = Storage::putFile('photo', $request->image);
        $extension = $request->image->extension();
        $mime = $request->image->getMimeType();
        $size = $request->image->getSize();
        return Image::create([
            'upload_path' => $upload_path,
            'mime' => $mime,
            'extension' => $extension,
            'size' => $size
        ]);

    }


    public function update(Request $request, $image)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,svg',
        ]);


        $upload_path = Storage::putFile('photo', $request->photo);
        $extension = $request->photo->extension();
        $mime = $request->photo->getMimeType();
        $size = $request->photo->getSize();
        $image = Image::findorfail($image);
        Storage::delete($image->upload_path);
        return $image->Update([
            'upload_path' => $upload_path,
            'mime' => $mime,
            'extension' => $extension,
            'size' => $size
        ]);
    }

    public function getImage(Image $image)
    {

        return Storage::get($image->upload_path);
    }

}
