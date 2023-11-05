<div class="card mb-3 bg-dark photobg rounded-1  h-100">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Koszty</span>
         </div>
         <div>
         {!! $costChart->container() !!}
        </div>
    </div>
</div>
{!! $costChart->script() !!}
