<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DevisMail;


class DevisController  extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'client' => 'required|string|max:255',
            'produit' => 'required|array',
            'quantite' => 'required|array',
            'prix' => 'required|array',
             'lang' => 'required|string',
        ]);
    
        $total = 0;

        foreach ($data['quantite'] as $index => $qte) {
            $total += $qte * $data['prix'][$index];
        }

        // Sauvegarde des données en session (ou base de données)
        session(['devis' => [
            'client_name' => $data['client'],
            'produit' => $data['produit'],
            'quantite' => $data['quantite'],
            'prix' => $data['prix'],
            'total_price' => $total
        ],

            'lang' => $request->lang

    ]);

        return redirect()->route('devis_apercu', ['lang' => $request->lang]);

    }


    public function generateQuote(Request $request)
    {
        // Récupérer les données du formulaire
        $data = $request->validate([
            'client' => 'required|string|max:255',
            'produit' => 'required|array',
            'quantite' => 'required|array',
            'prix' => 'required|array',
        ]);
        
    
        // Vérifier que les données essentielles sont présentes
        if (!isset($data['client']) || !isset($data['produit'])) {
            return redirect()->back()->withErrors(['error' => 'Veuillez remplir tous les champs obligatoires.']);
        }
    
        // Stocker les données du devis dans la session
        session(['devis' => $data]);
    
        // Rediriger vers l'aperçu du devis
        return redirect()->route('devis_apercu');
    }

    public function apercu()
    {
        // Vérifier si un devis existe en session
        if (!session()->has('devis')) {
            return redirect()->back()->withErrors(['error' => 'Aucun devis disponible.']);
        }
    
        // Récupérer le devis
        $data = session('devis');

        //recyperation de la langue
        $lang = session('lang', 'fr');
    
        // Afficher la vue avec les données du devis
        return view('devis_apercu', compact('data', 'lang'));
    }
    



    public function envoyerDevis(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $data = session('devis'); // Récupération des données du devis
        if (!$data) {
            return back()->with('error', 'Aucune donnée de devis trouvée.');
        }


        // Envoi du mail avec Mailable
        Mail::to($request->email)->send(new DevisMail($data));

        try {
            Mail::send('emails.devis', ['data' => $data], function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Votre devis');
            });
    
            //  Message de succès
            return back()->with('success', 'Le devis a été envoyé avec succès à Mailtrap pour : ' . $request->email);
    
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'envoi du devis.');
        }

        return back()->with('success', 'Le devis a été envoyé avec succès.');
}

        



        

    
}
