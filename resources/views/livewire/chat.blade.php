<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6" wire:poll.4s>
    <!-- Breadcrumb & Title -->
    <div class="mb-4 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="/" class="hover:text-[#641E28] transition font-medium">Beranda</a>
                <span>/</span>
                <span class="text-slate-800 font-bold">Pusat Pesan & Chat</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span>Chat Penjual & Pembeli</span>
                <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Live Chat Kampus
                </span>
            </h1>
        </div>
        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-slate-600 hover:text-[#641E28] flex items-center gap-1.5 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>

    <!-- Main Chat Container (Shopee / Tokopedia Style Split Layout) -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden flex flex-col md:flex-row h-[680px]">

        <!-- Left Sidebar: Conversations List -->
        <div class="w-full md:w-80 lg:w-96 border-r border-slate-200/80 flex flex-col h-full shrink-0 bg-slate-50/60 {{ $activeConversationId ? 'hidden md:flex' : 'flex' }}">
            <!-- Search Conversation -->
            <div class="p-3.5 border-b border-slate-200/80 bg-white">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari nama mahasiswa atau barang..."
                        class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-[#641E28] focus:ring-2 focus:ring-[#641E28]/10 transition outline-hidden font-medium"
                    />
                </div>
            </div>

            <!-- Conversations Scroll List -->
            <div class="flex-1 overflow-y-auto divide-y divide-slate-100">
                @forelse($conversations as $conv)
                    @php
                        $other = $conv->getOtherUser(Auth::id());
                        $isActive = ($conv->id === $activeConversationId);
                        $unread = $conv->unreadCount(Auth::id());
                        $latest = $conv->latestMessage;
                    @endphp
                    <button
                        type="button"
                        wire:click="selectConversation({{ $conv->id }})"
                        class="w-full p-3.5 flex items-start gap-3 text-left transition relative cursor-pointer {{ $isActive ? 'bg-rose-50/70 border-l-4 border-l-[#641E28]' : 'hover:bg-slate-100/70' }}"
                    >
                        <!-- Avatar -->
                        <div class="relative shrink-0">
                            <div class="w-11 h-11 rounded-full {{ $isActive ? 'bg-[#641E28] text-white' : 'bg-slate-200 text-slate-700' }} font-bold flex items-center justify-center text-sm shadow-xs">
                                {{ strtoupper(substr($other->name ?? 'M', 0, 1)) }}
                            </div>
                            @if($unread > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-[#641E28] text-[#EDAB0F] rounded-full text-[10px] font-black flex items-center justify-center shadow-xs border-2 border-white">
                                    {{ $unread }}
                                </span>
                            @endif
                        </div>

                        <!-- Chat Snippet -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-1 mb-0.5">
                                <h4 class="text-xs font-bold truncate text-slate-900 {{ $isActive ? 'text-[#641E28]' : '' }}">
                                    {{ $other->name ?? 'Mahasiswa Untirta' }}
                                </h4>
                                <span class="text-[10px] font-medium text-slate-400 shrink-0">
                                    {{ $conv->last_message_at ? $conv->last_message_at->format('H:i') : '' }}
                                </span>
                            </div>

                            <!-- Product Badge -->
                            @if($conv->product)
                                <div class="flex items-center gap-1.5 text-[10px] text-slate-500 font-semibold mb-1">
                                    <span class="truncate max-w-[170px] text-slate-700">📦 {{ $conv->product->title }}</span>
                                </div>
                            @endif

                            <p class="text-xs text-slate-500 truncate {{ $unread > 0 ? 'font-bold text-slate-900' : '' }}">
                                @if($latest)
                                    {{ $latest->sender_id === Auth::id() ? 'Anda: ' : '' }}{{ $latest->message }}
                                @else
                                    <span class="italic text-slate-400">Belum ada pesan</span>
                                @endif
                            </p>
                        </div>
                    </button>
                @empty
                    <div class="p-8 text-center text-slate-400">
                        <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-xs font-semibold text-slate-600">Belum ada obrolan</p>
                        <p class="text-[11px] text-slate-400 mt-1">Mulai obrolan dari halaman produk untuk bertanya ke penjual.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Main: Active Chat Window -->
        <div class="flex-1 flex flex-col h-full bg-white {{ $activeConversationId ? 'flex' : 'hidden md:flex' }}">
            @if($activeConversation)
                @php
                    $otherUser = $activeConversation->getOtherUser(Auth::id());
                @endphp

                <!-- Active Chat Top Header -->
                <div class="h-16 px-4 sm:px-6 border-b border-slate-200 flex items-center justify-between gap-3 shrink-0 bg-white shadow-xs">
                    <div class="flex items-center gap-3">
                        <!-- Mobile back button to conversation list -->
                        <button
                            type="button"
                            wire:click="$set('activeConversationId', null)"
                            class="md:hidden p-1.5 rounded-lg text-slate-500 hover:bg-slate-100"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <div class="w-10 h-10 rounded-full bg-[#641E28] text-[#EDAB0F] font-black flex items-center justify-center text-sm shadow-xs">
                            {{ strtoupper(substr($otherUser->name ?? 'M', 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-extrabold text-slate-900 leading-tight">
                                    {{ $otherUser->name ?? 'Mahasiswa Untirta' }}
                                </h3>
                                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-rose-50 text-[#641E28] border border-rose-200">
                                    {{ $otherUser->nim ?? 'Untirta' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 text-[11px] text-slate-500 mt-0.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>{{ $otherUser->campus_zone ?? 'Kampus Cilegon' }} (Fakultas Teknik)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Role Badge -->
                    <div class="text-right">
                        <span class="text-[11px] font-bold px-2 py-1 rounded-full {{ $activeConversation->seller_id === Auth::id() ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-slate-100 text-slate-700' }}">
                            {{ $activeConversation->seller_id === Auth::id() ? 'Anda sebagai Penjual' : 'Anda sebagai Pembeli' }}
                        </span>
                    </div>
                </div>

                <!-- Product Context Floating Card (Tokopedia / Shopee Context Style) -->
                @if($activeConversation->product)
                    <div class="p-3 bg-slate-50 border-b border-slate-200/90 flex items-center justify-between gap-3 shrink-0">
                        <div class="flex items-center gap-3 min-w-0">
                            <img
                                src="{{ $activeConversation->product->image_url ?: '/images/products/helm-proyek-ft.jpg' }}"
                                alt="{{ $activeConversation->product->title }}"
                                class="w-11 h-11 rounded-lg object-cover border border-slate-200 shrink-0"
                            />
                            <div class="min-w-0">
                                <a href="{{ route('product.detail', $activeConversation->product->slug) }}" target="_blank" class="text-xs font-bold text-slate-900 hover:text-[#641E28] truncate block">
                                    {{ $activeConversation->product->title }}
                                </a>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs font-extrabold text-[#641E28]">
                                        Rp {{ number_format($activeConversation->product->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-[10px] font-semibold text-slate-500">
                                        • Status: {{ ucfirst($activeConversation->product->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <a
                                href="{{ route('product.detail', $activeConversation->product->slug) }}"
                                class="px-3 py-1.5 text-xs font-bold text-[#641E28] bg-white border border-[#641E28]/40 hover:bg-rose-50 rounded-lg transition"
                            >
                                Lihat Barang
                            </a>
                            @if($activeConversation->seller_id !== Auth::id() && $activeConversation->product->status === 'available')
                                <a
                                    href="{{ route('order.checkout', $activeConversation->product->slug) }}"
                                    class="px-3 py-1.5 text-xs font-black text-slate-950 bg-gradient-to-r from-[#EDAB0F] to-amber-500 hover:from-amber-500 hover:to-amber-600 rounded-lg transition shadow-xs"
                                >
                                    Beli Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Message Bubbles Scroll Area -->
                <div class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-3 bg-[#fdfdfd]" id="chat-messages-container">
                    @forelse($messages as $msg)
                        @php
                            $isMe = ($msg->sender_id === Auth::id());
                        @endphp
                        <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                            <div class="max-w-[80%] sm:max-w-md rounded-2xl px-4 py-2.5 text-xs leading-relaxed shadow-xs {{ $isMe ? 'bg-[#641E28] text-white rounded-br-xs' : 'bg-slate-100 text-slate-800 rounded-bl-xs border border-slate-200/80' }}">
                                <p class="whitespace-pre-wrap font-medium">{{ $msg->message }}</p>
                            </div>
                            <div class="flex items-center gap-1.5 mt-1 text-[10px] text-slate-400 font-medium px-1">
                                <span>{{ $msg->created_at->format('H:i') }}</span>
                                @if($isMe)
                                    <span>•</span>
                                    <span class="{{ $msg->is_read ? 'text-[#EDAB0F] font-bold' : 'text-slate-400' }}">
                                        {{ $msg->is_read ? 'Dibaca' : 'Terkirim' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex items-center justify-center text-center p-8 text-slate-400">
                            <div>
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <h4 class="text-xs font-bold text-slate-700">Mulai Percakapan</h4>
                                <p class="text-[11px] text-slate-400 mt-1 max-w-xs">
                                    Tanyakan kelengkapan, jadwal ketemuan COD di kampus Untirta, atau nego harga secara santun.
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Input Footer -->
                <div class="p-3 sm:p-4 bg-white border-t border-slate-200 shrink-0">
                    <form wire:submit="sendMessage" class="flex items-center gap-2">
                        <div class="relative flex-1">
                            <input
                                type="text"
                                wire:model="newMessage"
                                wire:keydown.enter.prevent="sendMessage"
                                placeholder="Ketik pesan untuk {{ $otherUser->name ?? 'penjual' }} (Tekan Enter untuk kirim)..."
                                class="w-full pl-4 pr-10 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:border-[#641E28] focus:ring-2 focus:ring-[#641E28]/10 transition outline-hidden font-medium"
                                autofocus
                            />
                        </div>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="px-5 py-2.5 bg-[#641E28] hover:bg-[#4A151D] text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs transition flex items-center gap-2 cursor-pointer disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="sendMessage">Kirim</span>
                            <span wire:loading wire:target="sendMessage">...</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </form>
                </div>

            @else
                <!-- No Conversation Selected State -->
                <div class="flex-1 flex items-center justify-center text-center p-8 text-slate-400 bg-slate-50/40">
                    <div>
                        <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 text-slate-400 flex items-center justify-center mx-auto mb-3 shadow-xs">
                            <svg class="w-8 h-8 text-[#641E28]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800">Pilih Percakapan untuk Memulai</h3>
                        <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">
                            Pilih obrolan dari daftar sebelah kiri atau klik tombol "Chat Penjual" di halaman barang mana pun.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

