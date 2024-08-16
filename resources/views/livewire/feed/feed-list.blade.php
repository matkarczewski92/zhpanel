<div>
    <div class="card mb-3 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Zestawienie stanów</span>
             </div>
            <table class="detailsTable">
                <tr class="border-bottom">
                    <td>Nazwa karmy</td>
                    <td class="text-center">Aktualny stan</td>
                    <td class="text-center">Cena</td>
                    <td class="text-center">Domyślny interwał</td>
                    <td class="text-center">Ilość zwierząt</td>
                    <td class="text-center">Opcje</td>
                </tr>

                @foreach ($feed as $f)
                <tr>
                    <td><a href="{{ route('feed.profile', $f->id)}}">{{ $f->name}}</a></td>
                    <td class="text-center">{{ $f->amount}} szt</td>
                    <td class="text-center">{{ $f->last_price}} zł/szt</td>
                    <td class="text-center">{{ $f->feeding_interval}} </td>
                    <td class="text-center">{{ $f->animalsFeed?->where('animal_category_id', '<>', '5')->where('animal_category_id', '<>', '3')->count()}} </td>
                    <td class="text-center"><a href="{{ route('feed.profile', $f->id)}}"><i class="fa-solid fa-circle-info fa-lg"></i></a> </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
