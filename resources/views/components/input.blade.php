@props(['disabled' => false, 'label' => null, 'type' => 'text'])

<div class="space-y-1">
    @if($label)
        <label class="block text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif

    <input type="{{ $type }}"
           {{ $disabled ? 'disabled' : '' }}
           {!! $attributes->merge([
                'class' => 'block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                           sm:text-sm'
           ]) !!}>
</div>
