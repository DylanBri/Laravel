<div id="multiselect-user-content">
    @component('components.multi-select', [
        'id' => 'selectMultiUsers',
        'label' => 'profile::user.selectMultiUsers',
        'selectId' => 'users',
        'options' => $options
    ])
    @endcomponent
</div>

@include('profile::livewire.user.form.update-users-select-form-js')
