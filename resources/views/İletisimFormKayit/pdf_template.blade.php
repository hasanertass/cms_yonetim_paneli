<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body { font-family: DejaVu Sans; }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

    </style>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500;700&display=swap&subset=latin-ext"
        rel="stylesheet">
    <title>Veritabanı Verileri</title>
</head>

<body>
    <h1 style="color: #559fa8; text-align: center;">{{$formName->FormName}}  Verileri</h1>
    <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                @foreach($formAlanları as $formAlan)
                    <th>{{ $formAlan->AlanName }}</th>
                @endforeach
                <th>Durum</th>
            </tr>
        </thead>
        <tbody>
            @foreach($forms as $form)
                <tr>
                    @for($i=1; $i<=$formAlanları->count();$i++)
                        <td style="max-width: 150px; white-space: normal; word-wrap: break-word;">
                            {{ $form['column' . $i] }}</td>
                    @endfor
                    <td class="align-middle">
                        @if($form->status==0)
                            İncelenmedi
                        @else
                            İncelendi
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
