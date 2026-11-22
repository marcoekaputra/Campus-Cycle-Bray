<?php

namespace App\Livewire;

use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Chat Penjual & Pembeli - CampusCycle Untirta')]
class Chat extends Component
{
    #[Url(as: 'c')]
    public ?int $activeConversationId = null;

    #[Url(as: 'product')]
    public ?string $productSlug = null;

    public string $newMessage = '';
    public string $search = '';

    public function mount(): void
    {
        $userId = Auth::id();

        // 1. Jika diarahkan dari tombol "Chat Penjual" di halaman produk
        if ($this->productSlug) {
            $product = Product::where('slug', $this->productSlug)->first();
            if ($product && $product->seller_id !== $userId) {
                // Cari atau buat percakapan baru
                $conversation = Conversation::firstOrCreate(
                    [
                        'buyer_id' => $userId,
                        'seller_id' => $product->seller_id,
                        'product_id' => $product->id,
                    ],
                    [
                        'last_message_at' => now(),
                        'status' => 'active',
                    ]
                );
                $this->activeConversationId = $conversation->id;
            }
        }

        // 2. Jika belum ada activeConversationId, pilih percakapan terbaru
        if (!$this->activeConversationId) {
            $latest = Conversation::where('buyer_id', $userId)
                ->orWhere('seller_id', $userId)
                ->latest('last_message_at')
                ->first();

            if ($latest) {
                $this->activeConversationId = $latest->id;
            }
        }

        $this->markAsRead();
    }

    public function selectConversation(int $id): void
    {
        $this->activeConversationId = $id;
        $this->markAsRead();
    }

    public function sendMessage(): void
    {
        $text = trim($this->newMessage);
        if (empty($text) || !$this->activeConversationId) {
            return;
        }

        $userId = Auth::id();
        $conversation = Conversation::where('id', $this->activeConversationId)
            ->where(function ($q) use ($userId) {
                $q->where('buyer_id', $userId)->orWhere('seller_id', $userId);
            })
            ->first();

        if (!$conversation) {
            return;
        }

        ChatMessage::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'message' => $text,
            'is_read' => false,
        ]);

        $conversation->update(['last_message_at' => now()]);
        $this->newMessage = '';
    }

    protected function markAsRead(): void
    {
        if (!$this->activeConversationId) {
            return;
        }

        $userId = Auth::id();
        ChatMessage::where('conversation_id', $this->activeConversationId)
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    public function render()
    {
        $userId = Auth::id();

        // Ambil semua percakapan milik user
        $conversationsQuery = Conversation::with(['buyer', 'seller', 'product', 'latestMessage'])
            ->where(function ($q) use ($userId) {
                $q->where('buyer_id', $userId)->orWhere('seller_id', $userId);
            })
            ->latest('last_message_at');

        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $conversationsQuery->where(function ($q) use ($term) {
                $q->whereHas('buyer', fn($u) => $u->where('name', 'like', $term)->orWhere('nim', 'like', $term))
                  ->orWhereHas('seller', fn($u) => $u->where('name', 'like', $term)->orWhere('nim', 'like', $term))
                  ->orWhereHas('product', fn($p) => $p->where('title', 'like', $term));
            });
        }

        $conversations = $conversationsQuery->get();

        // Ambil percakapan aktif & riwayat pesannya
        $activeConversation = null;
        $messages = collect();

        if ($this->activeConversationId) {
            $activeConversation = Conversation::with(['buyer', 'seller', 'product'])
                ->where('id', $this->activeConversationId)
                ->where(function ($q) use ($userId) {
                    $q->where('buyer_id', $userId)->orWhere('seller_id', $userId);
                })
                ->first();

            if ($activeConversation) {
                $messages = $activeConversation->messages()->with('sender')->get();
            }
        }

        return view('livewire.chat', [
            'conversations' => $conversations,
            'activeConversation' => $activeConversation,
            'messages' => $messages,
        ]);
    }
}

