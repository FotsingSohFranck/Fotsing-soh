<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuoteMail;
use Illuminate\Support\Facades\App;

class QuoteController extends Controller
{
    public function index()
    {
        return view('quote');
    }

    public function sendQuote(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email',
            'products' => 'required|array',
            'quantities' => 'required|array',
            'prices' => 'required|array',
        ]);

        $items = [];
        $total = 0;

        foreach ($validated['products'] as $index => $product) {
            $subtotal = $validated['quantities'][$index] * $validated['prices'][$index];
            $total += $subtotal;
            $items[] = [
                'name' => $product,
                'quantity' => $validated['quantities'][$index],
                'price' => $validated['prices'][$index],
                'subtotal' => $subtotal,
            ];
        }

        $data = [
            'client_name' => $validated['client_name'],
            'client_email' => $validated['client_email'],
            'items' => $items,
            'total' => $total,
        ];

        Mail::to($data['client_email'])->send(new QuoteMail($data));

        return back()->with('success', __('messages.send_email'));
    }

    public function generateQuote(Request $request)
    {
        // Vérifier que les données du formulaire sont bien envoyées
        $data = $request->all();

        // Vérifier si les valeurs sont présentes
        if (!isset($data['client_name']) || !isset($data['produit'])) {
            return redirect()->back()->withErrors(['error' => 'Veuillez remplir tous les champs obligatoires.']);
        }

        // Envoyer les données à la vue devis_apercu.blade.php
        return view('devis_apercu', compact('data'));
    }
}
