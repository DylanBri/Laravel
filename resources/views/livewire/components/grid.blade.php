<div class="grid-body">
    <div>
        <div>
            <div>
                <div class="grid-container">
                    <div class="grid-content">
                    {{-- mettre les différents éléments --}}
                    </div>
                    <table class="grid-footer">
                        <thead>
                            <th scope="col" class="grid-footer-left">
                                {{-- actions reload + new --}}
                            </th>
                            <th scope="col" class="grid-footer-center">
                                {{-- pagination --}}
                            </th>
                            <th scope="col" class="grid-footer-right">
                                {{-- nb lignes --}}
                            </th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('livewire.components.grid-js')

@livewire('components.grid.header')
@livewire('components.grid.content')
@livewire('components.grid.footer')
