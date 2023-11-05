<div>
    <div class="card mb-3 bg-dark photobg rounded-1">
        <div class="card-body " style="">
            <div class="strike mb-2">
                <span>Planowanie zapotrzebowania</span>
             </div>

             <table class="detailsTable">
                <tr class="border-bottom">
                    <td style="width: 25%">Nazwa karmy</td>
                    <td class="text-center" style="width: 10%">DK</td>
                    <td class="text-center" style="width: 10%">DZ</td>
                    <td class="text-center">Zamówienie</td>
                    <td class="text-center" style="width: 10%">Nowa DK</td>
                    <td class="text-center" style="width: 15%">Nowa DZ</td>
                    <td class="text-center" style="width: 10%">Kwota</td>
                </tr>

                @foreach ($feed as $f)
                <tr>
                    <td><a href="{{ route('feed.profile', $f->id)}}">{{ $f->name}}</a><input type="hidden" name="id" wire:model.live="order.{{$f->id}}.id"></td>
                    <td class="text-center">@if (!empty($order[$f->id]['dk'])){{$order[$f->id]['dk']}}@endif</td>
                    <td class="text-center">@if (!empty($order[$f->id]['dz'])){{$order[$f->id]['dz']}}@endif</td>
                    <td class="text-center"><input type="number" min="0" name="qty" wire:model.live="order.{{$f->id}}.qty" placeholder="Planowane zamówienie"></td>
                    <td class="text-center">@if (!empty($order[$f->id]['qty']) AND $order[$f->id]['qty'] > 0){{$order[$f->id]['ndk']}}@endif</td>
                    <td class="text-center">@if (!empty($order[$f->id]['qty']) AND $order[$f->id]['qty'] > 0){{$order[$f->id]['ndz']}}@endif</td>
                    <td class="text-center">@if (!empty($order[$f->id]['qty']) AND $order[$f->id]['qty'] > 0){{ number_format($order[$f->id]['price'], 2, ",", ".")}}@endif</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="6" class="text-end">Suma:</td>
                    <td class="text-center">{{ number_format($sum, 2, ",", ".") }} zł</td>
                </tr>
            </table>
        </div>
    </div>
</div>
