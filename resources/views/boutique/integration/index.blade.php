@extends('boutique.layouts.app')

@section('content')
<div class="page-body">
      <div class="container-fluid p-3">
            <div class="page-title">
                <h3>Liste des Marques</h3>
            </div>
        </div>
    <div class="container-fluid">
        
        <div class="card">
            <div class="card-header">
                <h5>Générer le Code d'Intégration</h5>
               
                <button class="btn btn-primary mt-3" type="button" data-bs-toggle="modal" data-bs-target="#generateCodeModal">
                    <i class="fa-solid fa-code me-2"></i>Générer le code
                </button>
            </div>
            <div class="card-body">
                <p>Générez un code iframe pour intégrer votre boutique sur d'autres sites web.</p>
                
                @if($domain ?? false)
                <div class="mt-4">
                    <h6 class="mb-2">Configuration actuelle :</h6>
                    <div class="alert alert-info">
                        <strong>Domaine :</strong> {{ $domain->domain_name }}<br>
                        <strong>Dimensions :</strong> {{ $domain->width }} x {{ $domain->height }}
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Votre code d'intégration :</label>
                        <textarea class="form-control" rows="5" id="finalIframeCode" readonly>{{ $domain->iframe_code }}</textarea>
                        <button class="btn btn-outline-primary mt-2" onclick="copyToClipboard('finalIframeCode')">
                            <i class="fa-regular fa-copy me-2"></i>Copier le code
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de génération -->
    <div class="modal fade" id="generateCodeModal" tabindex="-1" aria-labelledby="generateCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateCodeModalLabel">Générateur de code d'intégration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="integrationForm" action="{{ route('boutique.integration.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="domain" class="form-label">Domaine cible*</label>
                                <input type="url" class="form-control" id="domain" name="domain" 
                                       placeholder="https://votresite.com" required
                                       value="{{ $domain->domain_name ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label for="width" class="form-label">Largeur*</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="width" name="width" 
                                           value="{{ $domain->width ?? 100 }}" required>
                                    <select class="form-select" id="unit" name="unit" style="max-width: 80px;">
                                        <option value="%" {{ ($domain->type ?? '%') == '%' ? 'selected' : '' }}>%</option>
                                        <option value="px" {{ ($domain->type ?? '%') == 'px' ? 'selected' : '' }}>px</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="height" class="form-label">Hauteur*</label>
                                <input type="number" class="form-control" id="height" name="height" 
                                       value="{{ $domain->height ?? 500 }}" required>
                            </div>
                            <div class="col-12">
                                <label for="iframeCode" class="form-label">Code Iframe</label>
                                <textarea class="form-control" id="iframeCode" name="iframe_code" rows="5" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary" id="generateBtn">Générer</button>
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const generateBtn = document.getElementById('generateBtn');
    const domainInput = document.getElementById('domain');
    const widthInput = document.getElementById('width');
    const heightInput = document.getElementById('height');
    const unitSelect = document.getElementById('unit');
    const iframeCodeTextarea = document.getElementById('iframeCode');

    // Générer le code iframe
    generateBtn.addEventListener('click', function() {
        if (!domainInput.value) {
            alert('Veuillez saisir un domaine valide');
            return;
        }

        const iframeCode = `<iframe 
    src="${domainInput.value}" 
    width="${widthInput.value}${unitSelect.value}" 
    height="${heightInput.value}px"
    frameborder="0"
    style="border:none;overflow:hidden"
    allowfullscreen>
</iframe>`;

        iframeCodeTextarea.value = iframeCode;
    });

    if (domainInput.value && widthInput.value && heightInput.value) {
        generateBtn.click();
    }
});

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    document.execCommand('copy');
    
    const originalText = element.nextElementSibling.innerHTML;
    element.nextElementSibling.innerHTML = '<i class="fa-solid fa-check me-2"></i>Copié !';
    
    setTimeout(() => {
        element.nextElementSibling.innerHTML = originalText;
    }, 2000);
}
</script>
@endsection