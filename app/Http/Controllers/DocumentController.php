<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Affiche la liste des documents REÇUS.
     */
    public function index()
    {
        $documents = Document::where('receiver_id', auth()->id())
            ->with('sender')
            ->latest()
            ->get();
            
        return view('documents.index', compact('documents'))->with('title', 'Docs reçus');
    }

    /**
     * Affiche la liste des documents ENVOYÉS par l'utilisateur.
     */
    public function sent()
    {
        $documents = Document::where('sender_id', auth()->id())
            ->with('receiver')
            ->latest()
            ->get();
            
        return view('documents.index', compact('documents'))->with('title', 'Docs envoyés');
    }

    /**
     * Affiche le formulaire d'envoi (Ta vue image_731007.png).
     */
    public function create()
    {
        // On récupère tous les collègues pour le menu déroulant
        $users = User::where('id', '!=', auth()->id())->get();
        return view('documents.create', compact('users'));
    }

    /**
     * Gère l'upload physique du fichier et l'enregistrement en BDD.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'receiver_id' => 'required|exists:users,id',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:10240', // 10 Mo max
        ]);

        if ($request->hasFile('file')) {
            // 1. Stockage du fichier dans storage/app/public/documents
            $path = $request->file('file')->store('documents', 'public');

            // 2. Création de l'entrée en base de données
            Document::create([
                'title' => $request->title,
                'file_path' => $path,
                'sender_id' => auth()->id(),
                'receiver_id' => $request->receiver_id,
            ]);

            return redirect()->route('documents.sent')->with('success', 'Le document a été envoyé avec succès !');
        }

        return back()->with('error', 'Une erreur est survenue lors de l\'envoi.');
    }

    /**
     * Permet de télécharger le fichier en toute sécurité.
     */
    public function download(Document $document)
    {
        // Optionnel : Vérifier que l'utilisateur est soit l'expéditeur soit le destinataire
        if (auth()->id() !== $document->sender_id && auth()->id() !== $document->receiver_id) {
            abort(403);
        }

        return Storage::disk('public')->download($document->file_path, $document->title);
    }
}