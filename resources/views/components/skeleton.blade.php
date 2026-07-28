@props(['type' => 'card'])

@if($type === 'hero')
    <div class="animate-pulse bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl p-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-7 space-y-4">
            <div class="h-4 bg-gray-200 dark:bg-gray-800 rounded w-24"></div>
            <div class="h-8 bg-gray-200 dark:bg-gray-800 rounded w-3/4"></div>
            <div class="h-8 bg-gray-200 dark:bg-gray-800 rounded w-1/2"></div>
            <div class="h-16 bg-gray-200 dark:bg-gray-800 rounded w-full"></div>
            <div class="h-4 bg-gray-200 dark:bg-gray-800 rounded w-48 pt-4"></div>
        </div>
        <div class="lg:col-span-5 h-64 bg-gray-200 dark:bg-gray-800 rounded-lg"></div>
    </div>
@else
    <div class="animate-pulse bg-[var(--bg-card)] border border-[var(--border-subtle)] rounded-xl p-6 space-y-4">
        <div class="h-40 bg-gray-200 dark:bg-gray-800 rounded-lg w-full"></div>
        <div class="flex gap-2">
            <div class="h-3 bg-gray-200 dark:bg-gray-800 rounded w-16"></div>
            <div class="h-3 bg-gray-200 dark:bg-gray-800 rounded w-20"></div>
        </div>
        <div class="h-6 bg-gray-200 dark:bg-gray-800 rounded w-5/6"></div>
        <div class="h-4 bg-gray-200 dark:bg-gray-800 rounded w-full"></div>
        <div class="h-4 bg-gray-200 dark:bg-gray-800 rounded w-2/3"></div>
        <div class="pt-4 border-t border-[var(--border-subtle)] flex justify-between">
            <div class="h-4 bg-gray-200 dark:bg-gray-800 rounded w-24"></div>
            <div class="h-4 bg-gray-200 dark:bg-gray-800 rounded w-16"></div>
        </div>
    </div>
@endif
