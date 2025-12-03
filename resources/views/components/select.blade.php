@props(['label', 'options' => [], 'disabled' => false])

<div class="mb-4">
    @if($label)
        <label class="block mb-1 font-medium text-gray-700">{{ $label }}</label>
    @endif
    <select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-indigo-500']) !!}>
        <option value="">-- Sélectionner --</option>
        @foreach($options as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
</div>
