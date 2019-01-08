<?php

namespace App\Http\Controllers\Admin;

use App\Image;
use App\Http\Requests\{ImageStoreRequest, ImageUpdateRequest};
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $images = Image::with('users')->get();
        $users = User::visitors()->get();

        return view('admin.image.index', compact('images', 'users'));
    }

    /**
     * @param ImageStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ImageStoreRequest $request)
    {
        $imageFile = $request->file('image');
        $extension = $imageFile->getClientOriginalExtension();
        Storage::disk('public')->put($imageFile->getFilename().'.'.$extension,  File::get($imageFile));

        $image = new Image();
        $image->path = $imageFile->getFilename().'.'.$extension;
        $image->extension = $extension;
        $image->size = $imageFile->getSize();
        $image->save();

        return response()->json(Image::with('users')->get());
    }

    /**
     * @param ImageUpdateRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ImageUpdateRequest $request, int $id)
    {
        $image = Image::findOrFail($id);
        $image->users()->sync($request->users);

        return response()->json(Image::with('users')->get());
    }

    /**
     * @param int $id
     */
    public function destroy(int $id)
    {
        Image::destroy($id);
    }
}