@props(['title', 'value', 'icon'])

<div {{ $attributes->merge(['class' => 'bg-white shadow rounded p-4 flex items-center gap-4']) }}>
    <div class="text-3xl">{{ $icon }}</div>
    <div>
        <div class="text-gray-500 text-sm">{{ $title }}</div>
        <div class="text-xl font-bold">{{ $value }}</div>
    </div>
</div>
