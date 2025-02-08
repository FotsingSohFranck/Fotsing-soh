<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Votre Devis</title>
</head>
<body>
    <h2>Votre devis</h2>
    <p><strong>Client :</strong> {{ $data['client_name'] }}</p>

    <h3>Produits</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Total</th>
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

    <h3>Total: {{ number_format($data['total_price'], 2) }} FCFA</h3>

    <p>Merci pour votre confiance.</p>
</body>
</html>
