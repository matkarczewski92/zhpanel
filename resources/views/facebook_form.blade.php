@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Post tekstowy --}}
    <div class="card mb-4 bg-dark text-white">
        <div class="card-body">
            <h5 class="card-title border-bottom pb-2">Post tekstowy</h5>
            <form action="{{ url('/fb/post-text') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="messageText" class="form-label">Treść posta</label>
                    <textarea id="messageText" name="message" class="form-control" rows="3" placeholder="Treść posta" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Opublikuj tekst</button>
            </form>
        </div>
    </div>

    {{-- Post ze zdjęciem --}}
    <div class="card mb-4 bg-dark text-white">
        <div class="card-body">
            <h5 class="card-title border-bottom pb-2">Post ze zdjęciem</h5>
            <form action="{{ url('/fb/post-image') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="messageImage" class="form-label">Treść posta</label>
                    <textarea id="messageImage" name="message" class="form-control" rows="3" placeholder="Treść posta" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="url" class="form-label">URL zdjęcia</label>
                    <input type="text" id="url" name="url" class="form-control" placeholder="https://example.com/photo.jpg" required>
                </div>
                <button type="submit" class="btn btn-primary">Opublikuj zdjęcie</button>
            </form>
        </div>
    </div>

    {{-- Post z wieloma zdjęciami --}}
    <div class="card mb-4 bg-dark text-white">
        <div class="card-body">
            <h5 class="card-title border-bottom pb-2">Post z wieloma zdjęciami</h5>
            <form action="{{ url('/fb/post-multi') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="messageMulti" class="form-label">Treść posta</label>
                    <textarea id="messageMulti" name="message" class="form-control" rows="3" placeholder="Treść posta" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="urls" class="form-label">URL-e zdjęć</label>
                    <textarea id="urls" name="urls" class="form-control" rows="3" placeholder="Podaj adresy URL oddzielone przecinkami" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Opublikuj wiele zdjęć</button>
            </form>
        </div>
    </div>



</div>
@endsection
