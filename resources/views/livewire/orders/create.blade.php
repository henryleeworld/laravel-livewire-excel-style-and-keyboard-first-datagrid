<div class="min-h-full bg-stone-50 px-4 py-6 dark:bg-zinc-950 sm:px-6 lg:px-8">
    <form wire:submit="save" class="mx-auto flex max-w-[96rem] flex-col gap-6">
        <header class="flex flex-col justify-between gap-4 border-b border-stone-200 pb-5 dark:border-zinc-800 sm:flex-row sm:items-end">
            <div class="flex flex-col gap-1">
                <p class="text-gray-600 font-mono text-xs font-semibold uppercase tracking-[0.18em] text-amber-700 dark:text-amber-400">
                    {{ __('Wholesale') . __(' / ') . __('Order entry') }}
                </p>
                <h2 class="text-xl font-semibold">{{ __('New sales order') }}</h2>
                <p class="text-sm text-gray-600">{{ __('Choose a product, enter quantities, and let the grid calculate each line.') }}</p>
            </div>

            <a href="{{ route('orders.index') }}" wire:navigate class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 hover:bg-gray-300">
                {{ __('Back to orders') }}
            </a>
        </header>

        <section class="grid gap-4 border-b border-stone-200 pb-6 dark:border-zinc-800 lg:grid-cols-[minmax(18rem,1.5fr)_minmax(12rem,0.65fr)_minmax(18rem,1fr)]">
            <div>
                <label class="mb-1 block text-sm font-medium">
                    {{ __('Customer') }}
                </label>
                <select wire:model="customerId" class="w-full rounded-md border-gray-300">
                    <option value="">{{ __('Choose a customer') }}</option>
                    @foreach ($this->customers as $customer)
                    <option value="{{ $customer->id }}" wire:key="customer-{{ $customer->id }}">
                        {{ $customer->company_name }} · {{ $customer->segment }}
                    </option>
                    @endforeach
                </select>
                @error('customerId')
                <div class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium">
                    {{ __('Order date') }}
                </label>
                <input type="date" wire:model="orderDate" class="w-full rounded-md border-gray-300" />
                @error('orderDate')
                <div class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium">
                    {{ __('Delivery note') }}
                </label>
                <textarea rows="2" wire:model="notes" class="w-full rounded-md border-gray-300 resize-none" placeholder="{{ __('Optional instructions for the receiving team') }}"></textarea>
                @error('notes')
                <div class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </section>

        <section aria-label="Order lines" class="min-w-0">
            <div class="mb-3 flex flex-col justify-between gap-2 sm:flex-row sm:items-end">
                <div>
                    <flux:heading size="lg">{{ __('Order lines') }}</flux:heading>
                    <p class="text-sm text-gray-600">{{ __('Paste rows from Excel, use Ctrl+D to fill down, and Ctrl+Z to undo.') }}</p>
                </div>

                <div class="flex items-center gap-2 font-mono text-xs text-zinc-500 dark:text-zinc-400">
                    <span class="rounded border border-zinc-300 px-1.5 py-0.5 dark:border-zinc-700">{{ __('Press Enter on Windows, or Return on Mac.') }}</span>
                    {{ __('advances') }}
                    <span class="rounded border border-zinc-300 px-1.5 py-0.5 dark:border-zinc-700">{!! __('fn&nbsp;F2') !!}</span>
                    {{ __('edits · a new line appears automatically') }}
                </div>
            </div>

            <x-laragrid :grid="$this->gridDefinition('lines')" :rows="$lines" />

            @error('lines')
                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </section>

        <footer class="flex flex-col justify-between gap-4 border-t border-stone-200 pt-5 dark:border-zinc-800 sm:flex-row sm:items-center">
            <p class="text-sm text-gray-600 max-w-2xl">
                {{ __('Prices may be adjusted per order. Product names, SKUs, and units are always copied from the current catalogue when you save.') }}
            </p>

            <div class="flex items-center gap-3">
                <a href="{{ route('orders.index') }}" wire:navigate class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 hover:bg-gray-300">{{ __('Cancel') }}</a>
                <button type="submit" data-save-order class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                    ✔️
                    {{ __('Create order') }}
                </button>
            </div>
        </footer>
    </form>
</div>
