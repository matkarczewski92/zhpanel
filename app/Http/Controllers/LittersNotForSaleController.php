<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\NotForSale;
use Illuminate\Http\Request;

class LittersNotForSaleController extends Controller
{
    private LitterRepositoryInterface $litterRepo;
    private AnimalRepositoryInterface $animalRepo;

    public function __construct(
        LitterRepositoryInterface $litterRepo,
        AnimalRepositoryInterface $animalRepo,
    ) {
        $this->litterRepo = $litterRepo;
        $this->animalRepo = $animalRepo;
    }

    public function index()
    {
        return view('not-for-sale', [
            'animal' => NotForSale::all(),
            'animalRepo' => $this->animalRepo,
            'litterRepo' => $this->litterRepo,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = NotForSale::find($id)->delete();

        return redirect('not-for-sale');
    }
}
