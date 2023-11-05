<div class="card mb-3 bg-dark photobg rounded-1  h-100">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>Dochody</span>
         </div>
         <div>
         {!! $incomeChart->container() !!}
        </div>
    </div>
</div>
{!! $incomeChart->script() !!}
