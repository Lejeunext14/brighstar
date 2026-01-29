@props([
    'sidebar' => false,
])

@if($sidebar)
    <div class="flex items-center justify-center gap-2 px-3 py-2">
        <div class="flex aspect-square size-8 items-center justify-center rounded-md bg-gradient-to-br from-blue-500 to-purple-600">
            <x-app-logo-icon class="size-5 fill-current" />
        </div>
        <span class="font-semibold text-sm">NLLC</span>
    </div>
@else
    <div class="flex items-center justify-center gap-2 px-3 py-2">
        <div class="flex aspect-square size-8 items-center justify-center rounded-md bg-gradient-to-br from-blue-500 to-purple-600">
            <x-app-logo-icon class="size-5 fill-current" />
        </div>
        <span class="font-semibold text-sm">NLLC</span>
    </div>
@endif
