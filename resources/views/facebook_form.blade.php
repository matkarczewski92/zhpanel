<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Facebook Post Tool</title>
</head>
<body>
    <h1>📢 Publikacja na Facebooku</h1>

    {{-- Formularz — post tekstowy --}}
    <h2>Post tekstowy</h2>
    <form action="{{ url('/fb/post-text') }}" method="POST">
        @csrf
        <textarea name="message" placeholder="Treść posta" rows="3" required></textarea><br>
        <button type="submit">Opublikuj tekst</button>
    </form>

    <hr>

    {{-- Formularz — post z jednym zdjęciem --}}
    <h2>Post ze zdjęciem</h2>
    <form action="{{ url('/fb/post-image') }}" method="POST">
        @csrf
        <textarea name="message" placeholder="Treść posta" rows="3" required></textarea><br>
        <input type="text" name="url" placeholder="URL zdjęcia" required><br>
        <button type="submit">Opublikuj zdjęcie</button>
    </form>

    <hr>

    {{-- Formularz — post z wieloma zdjęciami --}}
    <h2>Post z wieloma zdjęciami</h2>
    <form action="{{ url('/fb/post-multi') }}" method="POST">
        @csrf
        <textarea name="message" placeholder="Treść posta" rows="3" required></textarea><br>
        <textarea name="urls" placeholder="Wpisz URL-e zdjęć oddzielone przecinkami" rows="3" required></textarea><br>
        <button type="submit">Opublikuj wiele zdjęć</button>
    </form>
</body>
</html>
