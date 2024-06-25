<div>
    <div class="card mb-3 me-4 ms-4 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>{{$title}}</span>
            </div>

            <table class="detailsTable">
                <tr class="text-center">
                    <td class="text-start">ID</td>
                    <td class="text-start">Nazwa</td>
                    <td style="width:10%">Wazenie</td>
                    <td style="width:20%">Karma</td>
                    <td>Czy karmić</td>
                    <td></td>
                </tr>
                @foreach ($animals as $a)
                @php


                @endphp
                <tr class="text-center">
                    <td class="text-start border-bottom"><a href="{{ route('animal.profile', $a->id) }}">{!! $a->id !!}</a></td>
                    <td class="text-start border-bottom"><a href="{{ route('animal.profile', $a->id) }}">{!! $a->name !!}</a></td>
                    <td>
                        <input type="hidden" name="id" wire:model="mass.{{$a->id}}.id">
                        <input type="number" min="0" class="form-control" wire:model="mass.{{$a->id}}.weight">
                    </td>
                    <td>
                        <div class="input-group">
                            <select class="form-select" wire:model="mass.{{$a->id}}.feed" required>
                                @foreach ($feeds as $fs)
                                @if ($fs->amount >0 )
                                <option value="{{$fs->id}}" @if($a->feed_id == $fs->id) selected @endif>{{$fs->name}}</option>
                                @endif
                                @endforeach
                            </select>
                            <input type="number" min="0" class="form-control"  wire:model="mass.{{$a->id}}.amount">
                        </div>
                    </td>
                    <td><input class="form-check-input" type="checkbox" wire:model="mass.{{$a->id}}.feedCheck"></td>
                    <td></td>
                </tr>
                @endforeach
            </table>
            <button type="button" class="btn btn-success w-100 mt-3" wire:click="saveMassData()">Wprowadź dane</a>

        </div>
    </div>
</div>
