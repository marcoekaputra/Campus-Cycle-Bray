@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView({ behavior: 'smooth' })
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col sm:flex-row items-center justify-between gap-4 py-3">
            {{-- Mobile Pagination Simple --}}
            <div class="flex items-center justify-between w-full sm:hidden">
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-slate-400 bg-slate-100 border border-slate-200 rounded-xl cursor-not-allowed select-none">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Sebelumnya</span>
                    </span>
                @else
                    <button
                        type="button"
                        wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:border-[#641E28] hover:text-[#641E28] hover:bg-rose-50/50 rounded-xl shadow-xs transition active:scale-95"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Sebelumnya</span>
                    </button>
                @endif

                <span class="text-xs font-black text-slate-700 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200">
                    Hal. {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
                </span>

                @if ($paginator->hasMorePages())
                    <button
                        type="button"
                        wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:border-[#641E28] hover:text-[#641E28] hover:bg-rose-50/50 rounded-xl shadow-xs transition active:scale-95"
                    >
                        <span>Selanjutnya</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                @else
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-slate-400 bg-slate-100 border border-slate-200 rounded-xl cursor-not-allowed select-none">
                        <span>Selanjutnya</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                @endif
            </div>

            {{-- Desktop Pagination Detailed --}}
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between w-full">
                <div>
                    <p class="text-xs text-slate-500 font-medium">
                        Menampilkan
                        <strong class="font-black text-slate-800">{{ $paginator->firstItem() ?? 0 }}</strong>
                        sampai
                        <strong class="font-black text-slate-800">{{ $paginator->lastItem() ?? 0 }}</strong>
                        dari
                        <strong class="font-black text-slate-800">{{ $paginator->total() }}</strong>
                        produk
                    </p>
                </div>

                <div>
                    <div class="inline-flex items-center gap-1 bg-white p-1 rounded-2xl border border-slate-200/90 shadow-xs">
                        {{-- Previous Button --}}
                        @if ($paginator->onFirstPage())
                            <span class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-300 bg-slate-50 cursor-not-allowed select-none" aria-disabled="true">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </span>
                        @else
                            <button
                                type="button"
                                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-700 bg-white hover:bg-rose-50 hover:text-[#641E28] hover:border-rose-200 border border-transparent transition font-bold"
                                aria-label="Halaman Sebelumnya"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                        @endif

                        {{-- Pagination Number Elements --}}
                        @foreach ($elements as $element)
                            {{-- Separator (...) --}}
                            @if (is_string($element))
                                <span class="w-9 h-9 flex items-center justify-center text-xs font-bold text-slate-400 select-none">
                                    {{ $element }}
                                </span>
                            @endif

                            {{-- Array of Page Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                        @if ($page == $paginator->currentPage())
                                            <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-gradient-to-br from-[#641E28] to-[#8C283A] text-white text-xs font-black shadow-sm select-none border border-[#641E28]" aria-current="page">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <button
                                                type="button"
                                                wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-white text-slate-700 hover:text-[#641E28] hover:bg-rose-50/80 hover:border-rose-200 border border-transparent text-xs font-extrabold transition active:scale-95"
                                                aria-label="Ke halaman {{ $page }}"
                                            >
                                                {{ $page }}
                                            </button>
                                        @endif
                                    </span>
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($paginator->hasMorePages())
                            <button
                                type="button"
                                wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-700 bg-white hover:bg-rose-50 hover:text-[#641E28] hover:border-rose-200 border border-transparent transition font-bold"
                                aria-label="Halaman Selanjutnya"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        @else
                            <span class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-300 bg-slate-50 cursor-not-allowed select-none" aria-disabled="true">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    @endif
</div>
