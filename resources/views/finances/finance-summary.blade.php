<div class="card mb-3 bg-dark photobg rounded-1 h-100">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Podsumowanie</span>
         </div>
         <div>
         {!! $summaryChart->container() !!}
        </div>
        <table class="detailsTable mt-3">
            <tr>
                <td colspan="2" class="border-bottom">
                    Podsumowanie
                </td>
            </tr>
            <tr>
                <td class="key" style="width:80%">Dochody</td>
                <td>{{$incomeAmount}} zł</td>
            </tr>
            <tr>
                <td class="key">Koszty</td>
                <td>{{$costAmount}} zł</td>
            </tr>
            <tr>
                <td class="key">Bilans</td>
                <td>{{$incomeAmount-$costAmount}} zł</td>
            </tr>
        </table>
    </div>
</div>
{!! $summaryChart->script() !!}
