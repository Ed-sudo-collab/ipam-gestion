@props(['prev' => true])

<div class="flex justify-between mt-6">
    @if($prev)
        <button type="button" wire:click="prevStep" class="px-6 py-2 text-white bg-gray-400 rounded"> Précédent</button>
    @else
        <div></div>
    @endif
    <button type="button" wire:click="nextStep" class="px-6 py-2 text-white bg-indigo-600 rounded"> Suivant</button>
</div>
