<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\AttendanceReminder; // Utilisation de la classe de notification

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
     * Affiche le formulaire d'envoi.
     */
    public function create()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('documents.create', compact('users'));
    }

    /**
     * Gère l'upload et notifie le destinataire.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'receiver_id' => 'required|exists:users,id',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:10240', 
        ]);

        if ($request->hasFile('file')) {
            // 1. Stockage du fichier
            $path = $request->file('file')->store('documents', 'public');

            // 2. Création de l'entrée en BDD
            $document = Document::create([
                'title' => $request->title,
                'file_path' => $path,
                'sender_id' => auth()->id(),
                'receiver_id' => $request->receiver_id,
            ]);

            // --- AJOUT NOTIFICATION DESTINATAIRE ---
            $receiver = User::find($request->receiver_id);
            $receiver->notify(new AttendanceReminder(
                "📁 Nouveau document reçu : " . $request->title . " (de " . auth()->user()->name . ")", 
                route('documents.index')
            ));

            return redirect()->route('documents.sent')->with('success', 'Le document a été envoyé avec succès !');
        }

        return back()->with('error', 'Une erreur est survenue lors de l\'envoi.');
    }

    /**
     * Téléchargement sécurisé.
     */
    public function download(Document $document)
    {
        if (auth()->id() !== $document->sender_id && auth()->id() !== $document->receiver_id) {
            abort(403);
        }

        return Storage::disk('public')->download($document->file_path, $document->title);
    }
}