<?php

namespace App\Http\Controllers;

use App\Models\AnimalPhotoGallery;
use App\Models\LitterPhotoGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LitterGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $litterId)
    {
        // $litterId = $request->route('id');
        $image = new LitterPhotoGallery();
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename =  $litterId . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('public/Image/Litters'), $filename);
            $image->litter_id = $litterId;
            $image->url = '/public/Image/Litters/' . $filename;
            $image->main_photo = 0;
            $image->save();
        }
        return redirect()
            ->route('litters.show', [$litterId])
            ->with('gallery', 1)
            ->with('gallery_add', 'Dodano nowe zdjęcie');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $litterId, int $id)
    {

        $photo = LitterPhotoGallery::find($id);
        // dd($id);
        LitterPhotoGallery::where('litter_id', '=', $photo->litter_id)->update(['main_photo' => 0]);
        $photo->main_photo = 1;
        $photo->save();
        return redirect()
            ->route('litters.show', [$photo->litter_id])
            ->with('gallery', 1)
            ->with('gallery_add', 'Ustawiono zdjęcie profilowe');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $litterId, int $id)
    {
        $query = LitterPhotoGallery::find($id);
        $file = public_path($query->url);
        File::delete($query->url);
        $query->delete();
        return redirect()
            ->route('litters.show', [$litterId])
            ->with('gallery', 1)
            ->with('gallery_add', 'Usunięto zdjęcie');
    }
}
