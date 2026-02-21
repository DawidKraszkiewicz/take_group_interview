<div class="space-y-6">
    @if ($error)
        <div class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4 text-red-700 dark:text-red-300 text-sm">
            <strong>Błąd:</strong> {{ $error }}
        </div>
    @endif

    @if ($movies)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($movies as $movie)
                @php
                    // Localized title or fallback
                    $lang = app()->getLocale();
                    $title = $movie->title[$lang] ?? $movie->title['en'] ?? 'No Title';
                    $poster = $movie->poster_path
                        ? 'https://image.tmdb.org/t/p/w500' . $movie->poster_path
                        : 'https://via.placeholder.com/500x750';
                @endphp
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden flex flex-col h-full hover:shadow-lg transition">
                    <img src="{{ $poster }}" alt="{{ $title }}" class="w-full h-auto aspect-[2/3] object-cover">
                    <div class="p-4 flex flex-col flex-1 justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 truncate" title="{{ $title }}">
                                {{ $title }}
                            </h3>
                            <div class="flex items-center mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                {{ number_format($movie->vote_average ?? 0, 1) }}
                            </div>
                        </div>
                        <div class="mt-4 text-xs text-zinc-500 dark:text-zinc-500">
                            {{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('Y') : 'N/A' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $movies->links() }}
        </div>
    @endif
</div>
