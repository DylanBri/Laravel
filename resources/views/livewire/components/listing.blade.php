<div class="listing-body">
    <div class="listing-container">
        <div class="listing-alphabet">
            {{-- mettre la liste alphabétique --}}
        </div>
        <div class="listing-filter">
            {{-- mettre les différents filtres --}}
        </div>
        <div class="listing-content" style="height:{{$height}}">
            {{-- mettre les différents éléments liste --}}
        </div>
    </div>
</div>

@include('livewire.components.listing-js')

@livewire('components.listing.alphabet')
@livewire('components.listing.filter')
@livewire('components.listing.content')