<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructeurs in dienst</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .table-container {
            max-width: 1000px;
        }
        .star {
            color: gold;
        }
        .car-icon {
            color: #007bff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Instructeurs in dienst</h1>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Voornaam</th>
                        <th>Tussenvoegsel</th>
                        <th>Achternaam</th>
                        <th>Mobiel</th>
                        <th>Datum in dienst</th>
                        <th>Aantal sterren</th>
                        <th>Voertuigen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instructeurs as $instructeur)
                        <tr>
                            <td>{{ $instructeur->Voornaam }}</td>
                            <td>{{ $instructeur->Tussenvoegsel ?: '' }}</td>
                            <td>{{ $instructeur->Achternaam }}</td>
                            <td>{{ $instructeur->Mobiel }}</td>
                            <td>{{ \Carbon\Carbon::parse($instructeur->DatumInDienst)->format('d-m-Y') }}</td>
                            <td>
                                @for($i = 0; $i < strlen($instructeur->AantalSterren); $i++)
                                    <i class="fas fa-star star"></i>
                                @endfor
                            </td>
                            <td>
                                <a href="{{ route('instructeur.voertuigen', $instructeur->Id) }}" title="Bekijk voertuigen">
                                    <i class="fas fa-car car-icon"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
