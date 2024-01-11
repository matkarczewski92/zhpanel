<div class="card  bg-dark photobg rounded-1">
    <div class="card-body " style="">
        <div class="strike mb-2">
            <span>{{$animalRepo->sexName($data->sex)}}</span>
        </div>
        @isset($data->animalMainPhoto->url)
            <a><img src="{{ $data->animalMainPhoto->url }}" class="img-fluid " alt=""></a>
        @endisset
    </div>
</div>
