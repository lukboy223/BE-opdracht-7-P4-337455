<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wijzigen voertuiggegevens</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .form-container {
            max-width: 800px;
        }
        .readonly-field {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Wijzigen voertuiggegevens</h1>
        <h3 class="mb-3">Niet-toegewezen voertuig</h3>
        
        <div class="form-container">
            <form action="{{ route('voertuig.update-unassigned', ['voertuigId' => $voertuig->Id, 'instructeurId' => $instructeur->Id]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="typeVoertuig" class="form-label">Type Voertuig</label>
                    <input type="text" class="form-control readonly-field" id="typeVoertuig" name="TypeVoertuig" 
                           value="{{ $voertuig->typeVoertuig->TypeVoertuig }}" disabled>
                </div>
                
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <input type="text" class="form-control @error('Type') is-invalid @enderror" id="type" 
                           name="Type" value="{{ old('Type', $voertuig->Type) }}" required>
                    @error('Type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="kenteken" class="form-label">Kenteken</label>
                    <input type="text" class="form-control @error('Kenteken') is-invalid @enderror" id="kenteken" 
                           name="Kenteken" value="{{ old('Kenteken', $voertuig->Kenteken) }}" required>
                    @error('Kenteken')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="bouwjaar" class="form-label">Bouwjaar <small class="text-muted">(niet wijzigbaar)</small></label>
                    <input type="date" class="form-control readonly-field" id="bouwjaar" name="Bouwjaar" 
                           value="{{ \Carbon\Carbon::parse($voertuig->Bouwjaar)->format('Y-m-d') }}" readonly>
                    <small class="form-text text-muted">Dit veld kan niet worden gewijzigd.</small>
                </div>
                
                <div class="mb-3">
                    <label for="brandstof" class="form-label">Brandstof</label>
                    <select class="form-select @error('Brandstof') is-invalid @enderror" id="brandstof" name="Brandstof" required>
                        <option value="Benzine" {{ old('Brandstof', $voertuig->Brandstof) == 'Benzine' ? 'selected' : '' }}>Benzine</option>
                        <option value="Diesel" {{ old('Brandstof', $voertuig->Brandstof) == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="Elektrisch" {{ old('Brandstof', $voertuig->Brandstof) == 'Elektrisch' ? 'selected' : '' }}>Elektrisch</option>
                    </select>
                    @error('Brandstof')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="rijbewijscategorie" class="form-label">Rijbewijscategorie</label>
                    <input type="text" class="form-control readonly-field" id="rijbewijscategorie" 
                           value="{{ $voertuig->typeVoertuig->Rijbewijscategorie }}" disabled>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="assignToInstructor" name="Assign" value="1">
                    <label class="form-check-label" for="assignToInstructor">
                        Toewijzen aan instructeur {{ $instructeur->fullName }}
                    </label>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Wijzig</button>
                    <a href="{{ route('voertuig.available', $instructeur->Id) }}" class="btn btn-secondary ms-2">Annuleren</a>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add JavaScript to ensure the read-only field cannot be modified
        document.getElementById('bouwjaar').addEventListener('click', function(e) {
            e.preventDefault();
            alert('Het veld "Bouwjaar" kan niet worden gewijzigd.');
        });
        
        document.getElementById('bouwjaar').addEventListener('keydown', function(e) {
            e.preventDefault();
            return false;
        });
    </script>
</body>
</html>
