<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminInboxController extends Controller
{
    /**
     * Tampilkan semua pesan masuk
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(10);

        return view('admin.inbox.index', compact('messages'));
    }

    /**
     * Tampilkan detail pesan + tandai sudah dibaca
     */
    public function show(ContactMessage $message)
    {
        // Tandai pesan sudah dibaca
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.inbox.show', compact('message'));
    }

    /**
     * Hapus pesan
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()
            ->route('admin.inbox.index')
            ->with('success', 'Pesan berhasil dihapus');
    }
}
    