<?php

namespace Modules\Profile\Http\Livewire\User\Form;

use Livewire\Component;
use Modules\Advert\Entities\Advert;
use Modules\Advert\Repositories\AdvertRepository;
use Modules\Conversation\Entities\Conversation;
use Modules\Conversation\Repositories\ConversationRepository;
use Modules\Profile\Entities\User;
use Modules\Profile\Repositories\UserRepository;

class UpdateUsersSelectForm extends Component
{
    /**
     * @var array
     */
    public $options;

    /**
     * @var string
     */
    public $type;

    protected $rules = [
        'users' => 'nullable|array',
    ];

    protected $listeners = [
        'users-select-form-update' => 'mount'
    ];

    /**
     * Prepare the component.
     * @param int $id
     * @param string $type
     * @param array|null $options
     *
     * @return void
     */
    public function mount(int $id, string $type, array $options = null)
    {
        $users = null;
        $ids = ($options === null)? [] : $options;
        $this->type = $type;
        $this->options = UserRepository::getListForOptions($ids);

        // TODO Admin - Manager

        $userIds = ($options === null)? [] : $options;
        if ($users !== null) {
            foreach ($users as $user) {
                $userIds[] = $user->id;
            }
        }

        foreach ($this->options as $option) {
            if (in_array($option->id, $userIds)) {
                $option['selected'] = "selected";
            }
        }

        $this->emit('users-select-form-mount', ['users' => $userIds]);
    }

    public function render()
    {
        return view('profile::livewire.user.form.update-users-select-form');
    }
}
