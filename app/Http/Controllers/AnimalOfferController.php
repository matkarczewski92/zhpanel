<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalOffer;
use App\Models\AnimalOfferReservation;
use App\Models\Finances;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AnimalOfferController extends Controller
{


    public function index()
    {
        return view('offers', [
            'title' => 'Oferty sprzedaży',
            'offers' => AnimalOffer::where('sold_date', NULL)->get(),
        ]);
    }


    public function store(Request $req): RedirectResponse
    {
        $animalId = $req->animalId;

        if (is_null($req->offerId)) {
            $offer = new AnimalOffer();
        } else {
            $offer = AnimalOffer::find($req->offerId);
        }
        $offer->animal_id = $animalId;
        $offer->price = $req->price;
        $offer->save();
        $offerId = $offer->id;

        if (!is_null($req->booker)) {
            if (is_null($req->reservationId)) $reservation = new AnimalOfferReservation();
            else $reservation = AnimalOfferReservation::find($req->reservationId);
            $reservation->offer_id = $offerId;
            $reservation->deposit = $req->deposit;
            $reservation->booker = $req->booker;
            $reservation->expiration_date = $req->expiration_date;
            $reservation->adnotations = $req->adnotations;
            $reservation->save();
        }
        $animalUpdate = Animal::find($animalId);
        $publicProfileSwitch = ($req->publicProfile == 'on') ? '1' : '0';
        $animalUpdate->public_profile = $publicProfileSwitch;
        $animalUpdate->save();


        return redirect()
            ->route('animal.profile', $animalId)
            ->with('animalOffer', 'Oferta zaktualizowana')
            ->with('animalOfferColor', 'success');
    }

    public function destroy(int $offerId): RedirectResponse
    {
        $offer = AnimalOffer::find($offerId);
        $animalId = $offer->animal_id;
        $offer->delete();
        return redirect()
            ->route('animal.profile', $animalId)
            ->with('animalOffer', 'Oferta usunięta')
            ->with('animalOfferColor', 'danger');
    }
    public function destroyReservation(Request $req): RedirectResponse
    {
        $res = AnimalOfferReservation::find($req->resId);
        $getId = AnimalOffer::find($res->offer_id);
        $animalId = $getId->animal_id;
        $res->delete();
        return redirect()
            ->route('animal.profile', $animalId)
            ->with('animalOffer', 'Rezerwacja usunięta')
            ->with('animalOfferColor', 'danger');
    }

    public function sell(int $offerId)
    {
        $today = Carbon::now();
        $offer = AnimalOffer::find($offerId);
        $animalId = $offer->animal_id;

        // update offer
        $offer->sold_date = $today;
        $offer->save();

        // update animal
        $animal = Animal::find($animalId);
        $animal->animal_category_id = 3;
        $animal->save();

        // create transactions
        $finances = new Finances;
        $finances->finances_category_id = 3;
        $finances->amount = $offer->price;
        $finances->animal_id = $animalId;
        $finances->type = 'i';
        $finances->title = 'Sprzedaż zwierzęcia: #' . $animal->id . ' ' . $animal->name . '';
        $finances->save();

        // dd($animalId);
        return redirect()
            ->route('animal.profile', $animalId)
            ->with('animalOffer', 'Sprzedaż zarejestrowana')
            ->with('animalOfferColor', 'success');
    }
}
