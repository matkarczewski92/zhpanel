
    <div class="card  bg-dark photobg rounded-1 h-100">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Ostatnie transakcje
                    @if (!empty($hide))
                        {{$hide}}
                    @endif

                </span>
            </div>
            @if (session()->has('finances'))
                <div class="alert alert-{{ session('financesColor') }} alert-dismissible fade show" role="alert">
                    {{ session('finances') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-4">
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1">Rodzaj</span>
                        <select class="form-select" wire:model.live="filterType">
                        <option value=""></option>
                        <option value="c">Koszty</option>
                        <option value="i">Dochody</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1">Kategoria</span>
                        <select class="form-select" wire:model.live="filterCat">
                            <option value=""></option>
                            @foreach ($categories as $cat)
                                <option value={{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1">Tytuł</span>
                        <input type="text" class="form-control"  wire:model.live="filterName">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Kwota od</span>
                        <input type="number" class="form-control" placeholder="od" wire:model.live="filterAmountFrom">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Kwota do</span>
                        <input type="number" class="form-control" placeholder="do" wire:model.live="filterAmountTo">
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Data od</span>
                        <input type="date" class="form-control" placeholder="Kwota od" wire:model.live="filterDateFrom">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Data do</span>
                        <input type="date" class="form-control" placeholder="Kwota do" wire:model.live="filterDateTo">
                    </div>
                </div>
                <div class="col-lg-4">
                    <button type="button" class="btn btn-warning w-100" wire:click="resetFilters()">Wyczyść filtry</button>
                </div>
            </div>




            <table class="detailsTable mb-3">
                <tr class="text-center border-bottom">
                    <td class="border-end">ID</td>
                    <td>Typ</td>
                    <td>Kategoria</td>
                    <td style="width:40%">Tytuł</td>
                    <td>Kwota</td>
                    <td>Data</td>
                    <td class="border-start">Karma</td>
                    <td class="border-end">ID Zwierzaka</td>
                    <td class="border-start"></td>
                </tr>
                @foreach ($transfers as $tr)
                    @php
                        $textColor = $tr->type == 'c' ? 'text-danger' : 'text-success';
                        $type = $tr->type == 'c' ? 'Koszt' : 'Dochód';
                    @endphp
                    <tr class="{{ $textColor }}">
                        <td class="text-center border-end">{{ $tr->id }}</td>
                        <td class="text-center">{{ $type[0] }}</td>
                        <td class="text-center">{{ $tr->financesCategory?->name }}</td>
                        <td>{{ $tr->title }}</td>
                        <td class="text-center">{{ $tr->amount }} zł</td>
                        <td class="text-center ">{{ $tr->created_at->format('Y-m-d') }}</td>
                        <td class="text-center border-start">@if ($tr->feed_id)<a href="{{ route('feed.profile', $tr->feed_id)}}">{{ $tr->feedDetails?->name }} </a>@endif</td>
                        <td class="text-center border-end">@if ($tr->animal_id)<a href="{{ route('animal.profile', $tr->animal_id)}}">#{{ $tr->animal_id }}</a>@endif</td>
                        <td class="text-center border-start">
                            <a wire:click.prevent="showEdit({{ $tr->id }})"><i
                                    class="fa-solid fa-pen-to-square fa-lg me-2"></i></a>
                            <a wire:click.prevent="delete({{ $tr->id }})"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    @if (!empty($editId) AND $editId == $tr->id)
                    <tr>
                        <td colspan="9" >
                            @livewire('finances.finance-edit-transfer', ['transferId' => $editId])
                        </td>
                    </tr>
                    @endif
                @endforeach
            </table>
            <div class="end-0 mt-2">
                {{ $transfers->links() }}
            </div>
        </div>
    </div>


