<?php


namespace App\Services;


use App\Models\Photo;
use Illuminate\Http\Request;

class UploadService
{
    public function savePhoto(Request $request)
    {
        $photo = Photo::query()->create([]);
        $file = $request->file('photo');
        $ext = $file->getClientOriginalExtension();
        $filename = $photo->photo_id . '.' . $ext;
        $file->move('storage/photos', $filename);
        $photo->update(compact('filename'));
        return $photo;
    }
}
