<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.quote_title') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="container">
        <h1>{{ __('messages.quote_title') }}</h1>

        <!-- Sélecteur de langue -->
        <form>
            <label for="language">{{ __('messages.select_language') }}:</label>
            <select id="language" onchange="changeLanguage(this.value)">
                <option value="{{ route('changeLang', 'fr') }}" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>🇫🇷 Français</option>
                <option value="{{ route('changeLang', 'en') }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇬🇧 English</option>
                <option value="{{ route('changeLang', 'es') }}" {{ app()->getLocale() == 'es' ? 'selected' : '' }}>🇪🇸 Español</option>
            </select>
        </form>

        <form action="{{ route('devis.store') }}" method="POST">
            @csrf
            <input type="hidden" name="lang" id="lang" value="{{ app()->getLocale() }}">
            
            <label>{{ __('messages.client_name') }}</label>
            <input type="text" name="client" placeholder="{{ __('messages.enter_client_name') }}" required>

            <!-- Liste dynamique des produits -->
            <div class="product-list">
                <div class="product-item">
                    <input type="text" name="produit[]" placeholder="{{ __('messages.product_name') }}" required>
                    <input type="number" name="quantite[]" class="quantity" placeholder="{{ __('messages.quantity') }}" required>
                    <input type="number" name="prix[]" class="unit-price" placeholder="{{ __('messages.unit_price') }}" step="0.01" required>
                </div>
            </div>

            <button type="button" id="ajouter-produit">➕</button>

            <label>{{ __('messages.total_price') }}</label>
            <input type="text" id="total" name="total_price" readonly>

            <button type="submit">{{ __('messages.submit') }}</button>
        </form>
    </div>

    <script>
    function changeLanguage(url) {
        window.location.href = url;
    }

    // Ajouter un nouveau produit
    document.getElementById('ajouter-produit').addEventListener('click', function() {
        let newProduct = document.createElement('div');
        newProduct.classList.add('product-item');
        newProduct.innerHTML = `
            <input type="text" name="produit[]" placeholder="{{ __('messages.product_name') }}" required>
            <input type="number" name="quantite[]" class="quantity" placeholder="{{ __('messages.quantity') }}" required>
            <input type="number" name="prix[]" class="unit-price" placeholder="{{ __('messages.unit_price') }}" step="0.01" required>
            <button type="button" class="supprimer-produit">❌</button>
        `;
        document.querySelector('.product-list').appendChild(newProduct);

        // Ajouter des écouteurs d'événements pour les nouveaux champs
        newProduct.querySelector('.quantity').addEventListener('input', calculerTotal);
        newProduct.querySelector('.unit-price').addEventListener('input', calculerTotal);
    });

    // Supprimer un produit
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('supprimer-produit')) {
            event.target.parentElement.remove();
            calculerTotal();
        }
    });

    // Calculer le total
    function calculerTotal() {
        let total = 0;
        document.querySelectorAll('.product-item').forEach(item => {
            const qte = parseFloat(item.querySelector('[name="quantite[]"]').value) || 0;
            const prix = parseFloat(item.querySelector('[name="prix[]"]').value) || 0;
            total += qte * prix;
        });

        // Mettre à jour le champ total
        document.getElementById('total').value = total.toFixed(2);
    }

    // Ajouter des écouteurs d'événements pour les champs existants
    document.querySelectorAll('.quantity, .unit-price').forEach(input => {
        input.addEventListener('input', calculerTotal);
    });
</script>

</body>
</html>
