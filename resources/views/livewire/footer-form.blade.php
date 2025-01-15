<form wire:submit.prevent="subscribe">
    <div class="mt-4 flex flex-col items-center gap-2 sm:flex-row sm:gap-3 bg-white rounded-lg p-2 dark:bg-gray-800">
        <div class="w-full">
            <input type="email" wire:model="email" class="py-3 px-4 block w-full border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900" placeholder="Enter your email">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="w-full sm:w-auto p-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700">
            Subscribe
        </button>
    </div>
</form>
@if (session()->has('success'))
    <p class="text-green-500 text-sm mt-2">{{ session('success') }}</p>
@endif

