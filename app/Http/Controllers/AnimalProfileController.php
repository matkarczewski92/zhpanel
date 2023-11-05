<?php

namespace App\Http\Controllers;

use App\Charts\AnimalWeightChart;
use App\Models\Animal;
use App\Models\AnimalFeedings;
use App\Models\AnimalGenotype;
use App\Models\AnimalPhotoGallery;
use App\Models\AnimalWeight;
use App\Models\Feed;
use App\Models\Litter;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AnimalProfileController extends Controller
{
    public function index(Request $request): View
    {
        $animalId = $request->route('id');
        $animal = Animal::find($animalId);

        return view('animals.animal-profile', [
            'animal' => $animal,
            'charts' => $this->weightChart($animalId),
            'litters' => Litter::where('parent_male', '=', $animalId)->orWhere('parent_female', '=', $animalId)->get(),
        ]);
    }

    public function weightChart(int $animalId)
    {
        $chartData = AnimalWeight::where('animal_id', '=', $animalId)->orderBy('created_at', 'desc')->latest()->take(10)->get()->reverse();
        $chart = new AnimalWeightChart;
        foreach ($chartData as $group) {
            $dateCreate = date_create($group->created_at);
            $label[] = date_format($dateCreate, "Y-m-d");
            $data[] = $group->value;
        }
        if (!empty($label)) {
            $chart->labels($label);
            $chart->dataset('Waga', 'line', $data)->options([
                'backgroundColor' => 'rgba(81, 153, 255, 0.9)',
            ]);
        } else {
            $chart->labels([0]);
            $chart->dataset('Waga', 'line', [0])->options([
                'backgroundColor' => 'rgba(81, 153, 255, 0.9)',
            ]);
        }
        return $chart;
    }

    public function imageUpload(Request $request)
    {
        $animalId = $request->route('id');
        $image = new AnimalPhotoGallery();
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = $animalId . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('public/Image'), $filename);
            $image->animal_id = $animalId;
            $image->url = '/public/Image/' . $filename;
            $image->main_profil_photo = 0;
            $image->save();
        }
        return redirect()
            ->route('animal.profile', ['id' => $animalId])
            ->with('gallery', 1)
            ->with('gallery_add', 'Dodano nowe zdjęcie');
    }
    public function imagedelete()
    {
        $id = last(request()->segments());
        $query = AnimalPhotoGallery::find($id);
        $animalId = $query->animal_id;
        $file = public_path() . $query->url;
        File::delete($file);
        $query->delete();
        return redirect()
            ->route('animal.profile', ['id' => $animalId])
            ->with('gallery', 1)
            ->with('gallery_add', 'Usunięto zdjęcie');
    }

    public function imagesetmain(Request $request)
    {
        $id = $request->route('id');
        $photo = AnimalPhotoGallery::find($id);
        AnimalPhotoGallery::where('animal_id', '=', $photo->animal_id)->update(['main_profil_photo' => 0]);
        $photo->main_profil_photo = 1;
        $photo->save();
        return redirect()
            ->route('animal.profile', ['id' => $photo->animal_id])
            ->with('gallery', 1)
            ->with('gallery_add', 'Ustawiono zdjęcie profilowe');
    }
}
