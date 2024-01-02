<div class="card mb-3 bg-dark photobg rounded-1">
    <div class="strike mb-2 m-3">
        <span>Wykres zużycia</span>
     </div>
    <div class="me-3 ms-3 ">
        <form action="#" method="get">
            <select class="form-select" name="year" onchange="this.form.submit()">
                <option value="2024" @if ((isset($_GET['year']) and $_GET['year']=='2024') || !isset($_GET['year'])) selected @endif>2024</option>
                <option value="2023" @if (isset($_GET['year']) and $_GET['year']=='2023') selected @endif>2023</option>
                <option value="2022" @if (isset($_GET['year']) and $_GET['year']=='2022') selected @endif>2022</option>
              </select>
        </form>
    </div>
    <div class="card-body " style="">
         {!!$chart->container()!!}
    </div>
</div>
@if (!empty($feed[0]))
    {!! $chart->script() !!}
@endif

