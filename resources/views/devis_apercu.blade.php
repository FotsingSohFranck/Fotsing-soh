<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.quote_preview') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style02.css') }}">
</head>
<body>
    <div class="container">
        <h1>{{ __('messages.quote_preview') }}</h1>
        <a href="{{ route('devis_apercu') }}">{{ __('messages.last_quote') }}</a>

        <!-- Affichage de la langue sélectionnée -->
        <p><strong>{{ __('messages.selected_language') }} :</strong> 
            @if ($lang == 'fr') 🇫🇷 Français
            @elseif ($lang == 'en') 🇬🇧 English
            @elseif ($lang == 'es') 🇪🇸 Español
            @endif
        </p>

        <p><strong>{{ __('messages.client') }} :</strong> {{ $data['client_name'] }}</p>
        
        <h2>{{ __('messages.products') }}</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>{{ __('messages.product') }}</th>
                    <th>{{ __('messages.quantity') }}</th>
                    <th>{{ __('messages.unit_price') }}</th>
                    <th>{{ __('messages.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['produit'] as $index => $produit)
                    <tr>
                        <td>{{ $produit }}</td>
                        <td>{{ $data['quantite'][$index] }}</td>
                        <td>{{ number_format($data['prix'][$index], 2) }} FCFA</td>
                        <td>{{ number_format($data['quantite'][$index] * $data['prix'][$index], 2) }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>{{ __('messages.total_amount', ['amount' => number_format($data['total_price'], 2)]) }}</h3>

        <!-- Formulaire pour l'envoi du devis par email -->
        <form action="{{ route('envoyer_devis') }}" method="POST">
            @csrf
            <label for="email">{{ __('messages.email_address') }} :</label>
            <input type="email" name="email" id="email" placeholder="{{ __('messages.enter_email') }}" required>
            <button type="submit">{{ __('messages.send_quote') }}</button>
        </form>

        <a href="{{ url('/') }}">{{ __('messages.back') }}</a>
    </div>

    @if (session('success'))
    <div style="color: green; background: #d4edda; padding: 10px; margin-bottom: 10px; border: 1px solid #c3e6cb;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="color: red; background: #f8d7da; padding: 10px; margin-bottom: 10px; border: 1px solid #f5c6cb;">
        {{ session('error') }}
    </div>
@endif

</body>
</html>
