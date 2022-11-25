<?php

namespace App\Observers;

use App\Models\SessionProfile;
use App\Providers\FortifyServiceProvider;
//use Illuminate\Support\Facades\Log;

class SessionProfileObserver
{
    /**
     * Handle the Session "created" event.
     *
     * @param  \App\Models\SessionProfile  $session
     * @return void
     */
    public function created(SessionProfile $session)
    {
        // Fill session profile
        session_start();
        session(['userId' => $session->user_id]);
        session(['roleId' => $session->role_id]);
        session(['clientId' => $session->client_id]);

        // Right and profile
        /*$rights = RightAndProfile::query()
            ->join('right', 'right.id', '=', 'right_and_profile.right_id')
            ->where('right_and_profile.user_id', $profile->getUserId())
            ->where('right_and_profile.role_id', $profile->getRoleId())
            ->where('right_and_profile.client_id', $profile->getClientId())
            ->where('right_and_profile.enabled', 1)
            ->get('right.code');
        $rightAndProfile = array_map(function ($item) {
            return $item['code'];
        }, $rights->toArray());*/

        // Fill session specific right
        /*session(['right' => [
            "andProfile" => $rightAndProfile,
            "andHolding" => $rightAndHolding,
            "andCompany" => $rightAndCompany,
            "andOffice" => $rightAndOffice
        ]]);*/

        // Fill session profile type
        switch ($session->role_id) {
            case FortifyServiceProvider::ROLE_SUPADM :
                session(['isSuperAdmin' => true]);
                break;
            case FortifyServiceProvider::ROLE_ADMIN :
                session(['isAdmin' => true]);
                break;
            case FortifyServiceProvider::ROLE_MANAGER :
                session(['isManager' => true]);
                break;
//            case FortifyServiceProvider::ROLE_VIEWER :
//                session(['isViewer' => true]);
//                break;
            case FortifyServiceProvider::ROLE_USER :
                session(['isUser' => true]);
        }
    }

    /**
     * Handle the Session "updated" event.
     *
     * @param  \App\Models\SessionProfile  $session
     * @return void
     */
    public function updated(SessionProfile $session)
    {
        //
    }

    /**
     * Handle the Session "deleted" event.
     *
     * @param  \App\Models\SessionProfile  $session
     * @return void
     */
    public function deleted(SessionProfile $session)
    {
        // Unset session profile
        session_unset();
    }

    /**
     * Handle the Session "restored" event.
     *
     * @param  \App\Models\SessionProfile  $session
     * @return void
     */
    public function restored(SessionProfile $session)
    {
        //
    }

    /**
     * Handle the Session "force deleted" event.
     *
     * @param  \App\Models\SessionProfile  $session
     * @return void
     */
    public function forceDeleted(SessionProfile $session)
    {
        //
    }
}
