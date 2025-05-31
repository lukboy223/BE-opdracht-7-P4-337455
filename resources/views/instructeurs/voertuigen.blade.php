<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Door instructeur gebruikte voertuigen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .table-container {
            max-width: 1200px;
        }
        .action-btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Door instructeur gebruikte voertuigen</h1>
        <h3 class="mb-3">Naam: {{ $instructeur->fullName }}</h3>
        <h5 class="mb-4">Datum in dienst: {{ \Carbon\Carbon::parse($instructeur->DatumInDienst)->format('d-m-Y') }}</h5>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Type Voertuig</th>
                        <th>Type</th>
                        <th>Kenteken</th>
                        <th>Bouwjaar</th>
                        <th>Brandstof</th>
                        <th>Rijbewijscategorie</th>
                        <th>Datum toekenning</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($voertuigen as $voertuig)
                        <tr>
                            <td>{{ $voertuig->typeVoertuig->TypeVoertuig }}</td>
                            <td>{{ $voertuig->Type }}</td>
                            <td>{{ $voertuig->Kenteken }}</td>
                            <td>{{ \Carbon\Carbon::parse($voertuig->Bouwjaar)->format('d-m-Y') }}</td>
                            <td>{{ $voertuig->Brandstof }}</td>
                            <td>{{ $voertuig->typeVoertuig->Rijbewijscategorie }}</td>
                            <td>{{ \Carbon\Carbon::parse($voertuig->pivot->DatumToekenning)->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('voertuig.edit', $voertuig->pivot->Id) }}" class="btn btn-primary btn-sm action-btn">
                                    Wijzigen
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Geen voertuigen gevonden voor deze instructeur.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <a href="{{ route('instructeur.index') }}" class="btn btn-secondary mt-3">Terug naar overzicht</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
