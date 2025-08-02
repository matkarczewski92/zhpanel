<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body onload='window.print()'>

<table class="table table-borderless">
    <tr class="text-center ">
        <td colspan="2"><img src="https://makssnake.pl/public/src/logo_black.png" class="mt-3 mb-3"></td>
    </tr>
</table>

    <table class="table mx-auto ">
        <tr>
            <td>Kod miotu</td>
            <td class="text-end">{{ $animal->animalType->name ?? '' }}</td>
        </tr>

        <tr>
            <td>Data klucia</td>
            <td class="text-end">{!! $animal->date_of_birth !!}</td>
        </tr>
        <tr>
        <td>Kod miotu</td>
            <td class="text-end">{{ $animal->animalLitter->litter_code ?? '' }}</td>
        </tr>
        <tr>
            <td>Nazwa</td>
            <td class="text-end">{!! $animal->name !!}</td>
        </tr>
            <td>Płeć</td>
            <td class="text-end">{{ $sexName ?? '' }}</td>
        </tr>
    </table>

    <table class="table mx-auto mt-5">
        <tr>
            <td>Hodowla</td>
            <td class="text-end">MaksSnake</td>
        </tr>
        <tr>
            <td>Dane kontakt</td>
            <td class="text-end">tel. 533 913 602</td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td class="text-end">snake@makssnake.pl</td>
        </tr>
    </table>

    <table class="table mx-auto mt-5 table-dark">
        <tr>
            <td>KOD WĘŻA</td>
            <td class="text-end">{{$animal->public_profile_tag}}</td>
        </tr>
    </table>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>