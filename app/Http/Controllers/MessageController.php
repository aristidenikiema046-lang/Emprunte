<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('id', '!=', auth()->id())->get();
        $selectedUserId = $request->query('user');
        $messages = [];

        if ($selectedUserId) {
            $messages = Message::where(function($q) use ($selectedUserId) {
                $q->where('sender_id', auth()->id())->where('receiver_id', $selectedUserId);
            })->orWhere(function($q) use ($selectedUserId) {
                $q->where('sender_id', $selectedUserId)->where('receiver_id', auth()->id());
            })->orderBy('created_at', 'asc')->get();
        }

        return view('messages.index', compact('users', 'messages', 'selectedUserId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required_without:file|nullable|string',
            'file' => 'nullable|file|max:20480',
        ]);

        $path = null;
        $name = null;

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('messages_files', 'public');
            $name = $request->file('file')->getClientOriginalName();
        }

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content ?? '',
            'file_path' => $path,
            'file_name' => $name,
        ]);

        return back();
    }

    public function update(Request $request, Message $message)
    {
        // Sécurité : Seul l'expéditeur peut modifier
        if ($message->sender_id !== auth()->id()) {
            return back()->with('error', 'Action non autorisée');
        }

        $request->validate(['content' => 'required|string']);
        $message->update(['content' => $request->content]);

        return back()->with('success', 'Message modifié');
    }

    public function destroy(Message $message)
    {
        // Sécurité : Seul l'expéditeur peut supprimer
        if ($message->sender_id !== auth()->id()) {
            return back()->with('error', 'Action non autorisée');
        }

        $message->delete();
        return back()->with('success', 'Message supprimé');
    }
}