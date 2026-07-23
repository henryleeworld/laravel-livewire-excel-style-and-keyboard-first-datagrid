<div class="min-h-full bg-stone-50 px-4 py-6 dark:bg-zinc-950 sm:px-6 lg:px-8">
    <div class="mx-auto flex max-w-[96rem] flex-col gap-6">
        <header class="flex flex-col justify-between gap-4 border-b border-stone-200 pb-5 dark:border-zinc-800 sm:flex-row sm:items-end">
            <div class="flex flex-col gap-1">
                <p class="text-gray-600 font-mono text-xs font-semibold uppercase tracking-[0.18em] text-amber-700 dark:text-amber-400">
                    {{ __('Wholesale') . __(' / ') . __('Sales desk') }}
                </p>
                <h2 class="text-xl font-semibold">{{ __('Orders') }}</h2>
                <p class="text-sm text-gray-600">{{ __('Search, filter, save a working view, or export the current register.') }}</p>
            </div>

            <a href="{{ route('orders.create') }}" wire:navigate class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 hover:bg-gray-300">
                {{ __('New order') }}
            </a>
        </header>

        <section aria-label="Order register" class="min-w-0">
            <x-laragrid :grid="$this->gridDefinition('orders')" />
        </section>
    </div>
</div>
