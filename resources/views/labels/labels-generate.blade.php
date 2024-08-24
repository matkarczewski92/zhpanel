{{-- @foreach ($animals as $a)
{!!$a['type']!!}<br>
{!!$a['id']!!}<br>
{!!$a['name']!!}<br>
{!!$a['sex']!!}<br>
{!!$a['date_of_birth']!!}<br>
<hr>
@endforeach --}}
@php
$col = 0;
$row = 0    
@endphp

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body><center>
    <table style="margin-top:30px">
        <tr style="height:99.25pt;">
            @foreach ($animals as $a)
            @php
                $color = ($a['sex']==3) ? '#ff0f00' : '#0000ff';
            @endphp
                <td class="border" style="width:191.3pt; padding-right:0.75pt; padding-left:0.75pt; vertical-align:top;">
                    <p class="text-center" style="margin:5.55pt 4.8pt 0pt; font-size:9pt;"><b>{!!$a['type']!!}</b></p>
                    <p style="margin:5.55pt 4.8pt 0pt; font-size:9pt;">{!!$a['id']!!}. {!!$a['name']!!}</p>
                    <p style="margin:5.55pt 4.8pt 0pt; font-size:9pt;"><b>Data klucia:</b> {!!$a['date_of_birth']!!}</p>
                    <p style="margin:5.55pt 4.8pt 0pt; font-size:9pt; color: {{$color}}"><b>Płeć:</b> {{$repo->sexName($a['sex'])}}</p>
                </td>
                @php
                    $col++;
                    if($col == 3) {
                        echo('</tr><tr style="height:99.25pt;">');
                        $col = 0;
                        $row++;
                    }
                    if($row == 8)
                    {
                        echo('</tr></table><table style="margin-top:-65px"><tr style="height:99.25pt;">');
                        $row = 0;
                    }
                @endphp
            @endforeach
            @for(;$col<3; $col++)
                    <td class="border" style="width:191.3pt; padding-right:0.75pt; padding-left:0.75pt; vertical-align:top;">
                        <p style="margin:5.55pt 4.8pt 0pt; font-size:11pt;">&nbsp;</p>
                        <p style="margin:0pt 4.8pt; font-size:11pt;">&nbsp;</p>
                    </td>
            @endfor
        </tr>
    </table>
    </center>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>