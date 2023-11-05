<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalFeedings;
use App\Models\AnimalGenotype;
use App\Models\AnimalGenotypeCategory;
use App\Models\AnimalMolt;
use App\Models\AnimalPhotoGallery;
use App\Models\AnimalWeight;
use App\Models\Feed;
use App\Models\Finances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SettingsController extends Controller
{

    public function index(): View
    {
        return view('settings');
    }
    public function webIndex(): View
    {
        // $this->migrateAnimal();
        // $this->migrateFinances();
        // $this->updateFeed();


        $data = DB::connection('mysql2')->table('weze')->get();
        return view('settings-web', [
            'weze' => $data,
            'gallery' => AnimalPhotoGallery::all(),
        ]);
    }























    // temporary migration function -> to delete after system start
    public function migrateAnimal()
    {

        // stworzenie weza
        $data = DB::connection('mysql2')->table('weze')->get();
        foreach ($data as $d) {
            $check = Animal::where('name', $d->nazwa)->count();
            $newAnimal = Animal::where('name', $d->nazwa)->get();

            if ($check == 0) {
                $animal = new Animal();
                $animal->name = $d->nazwa;
                $animal->sex = $this->newSex($d->plec);
                $animal->date_of_birth = $d->data_urodzenia;
                $animal->animal_type_id = 1;
                $animal->feed_id = $this->newFeed($d->id_karmy);
                $animal->animal_category_id  = $this->newAnimalCategory($d->kategoria);
                $animal->public_profile_tag = $d->qr_secur;
                $animal->save();
                $animalId = $animal->id;
            } else $animalId = $newAnimal[0]->id;

            $molts = DB::connection('mysql2')->table('wylinki')->where('id_weza', $d->id)->get();

            foreach ($molts as $m) {
                $newMolt = new AnimalMolt();
                $newMolt->animal_id = $animalId;
                $newMolt->created_at = $m->data;
                $newMolt->save();
            }

            $weight = DB::connection('mysql2')->table('wazenie')->where('id_weza', $d->id)->get();
            foreach ($weight as $w) {
                $aW = new AnimalWeight();
                $aW->animal_id = $animalId;
                $aW->value = $w->waga;
                $aW->created_at = $w->data;
                $aW->save();
            }

            $feeding = DB::connection('mysql2')->table('karmienie')->where('id_weza', $d->id)->get();
            foreach ($feeding as $f) {
                $feed = new AnimalFeedings();
                $feed->animal_id = $animalId;
                $feed->feed_id = $this->newFeed($f->id_karmy);
                $feed->amount = $f->ilosc;
                $feed->created_at = $f->data;
                $feed->save();
            }


            $genotype = DB::connection('mysql2')->table('genetyka')->where('id_weza', $d->id)->get();
            foreach ($genotype as $g) {
                $gen = new AnimalGenotype();
                $gen->animal_id = $animalId;
                $gen->genotype_id = $g->kategoria;
                $gen->type = $g->rodzaj[0];
                $gen->save();
            }

            $finances = DB::connection('mysql2')->table('koszty')->where('waz', $d->id)->where('nazwa', '<>', 'Karmienie')->get();
            foreach ($finances as $f) {
                $fin = new Finances();
                $fin->finances_category_id = $f->kategoria;
                $fin->amount = $f->kwota;
                $fin->title = $f->nazwa;
                $fin->animal_id = $animalId;
                $fin->type = 'c';
                $fin->created_at = $f->data;
                $fin->save();
            }
            $financesInc = DB::connection('mysql2')->table('dochody')->where('waz', $d->id)->where('nazwa', '<>', 'Karmienie')->get();
            foreach ($financesInc as $f) {
                $fin = new Finances();
                $fin->finances_category_id = 3;
                $fin->amount = $f->kwota;
                $fin->title = $f->nazwa;
                $fin->animal_id = $animalId;
                $fin->type = 'i';
                $fin->created_at = $f->data;
                $fin->save();
            }
        }
    }

    public function migrateFinances()
    {
        $finances = DB::connection('mysql2')->table('koszty')->where('waz', NULL)->where('nazwa', '<>', 'Karmienie')->get();
        foreach ($finances as $f) {
            $fin = new Finances();
            $fin->finances_category_id = $f->kategoria;
            $fin->amount = $f->kwota;
            $fin->title = $f->nazwa;
            $fin->type = 'c';
            $fin->created_at = $f->data;
            $fin->save();
        }
        $financesInc = DB::connection('mysql2')->table('dochody')->where('waz', NULL)->where('nazwa', '<>', 'Karmienie')->get();
        foreach ($financesInc as $f) {
            $fin = new Finances();
            $fin->finances_category_id = 3;
            $fin->amount = $f->kwota;
            $fin->title = $f->nazwa;
            $fin->type = 'i';
            $fin->created_at = $f->data;
            $fin->save();
        }
    }

    public function updateFeed()
    {
        $karmienia = DB::connection('mysql2')->table('karma')->get();
        foreach ($karmienia as $k) {
            $feed = Feed::find($this->newFeed($k->kategoria));
            $feed->amount = $k->ilosc;
            $feed->last_price = $k->cena_ostatnia;
            $feed->save();
        }
    }

    public function newAnimalCategory(int $cat)
    {
        $newCat = match ($cat) {
            0 => 3,
            1 => 1,
        };
        return $newCat;
    }
    public function newSex(int $sex)
    {
        $newSex = match ($sex) {
            0 => 2,
            1 => 3,
            2 => 1,
        };
        return $newSex;
    }
    public function newFeed(int $id)
    {
        $newFeed = match ($id) {
            0 => 0,
            1 => 1,
            9 => 2,
            10 => 3,
            12 => 4,
            4 => 5,
            5 => 6,
            8 => 7,
        };
        return $newFeed;
    }
}
