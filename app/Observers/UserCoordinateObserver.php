<?php

namespace App\Observers;

use App\Models\UserCoordinate;
use App\Models\UserCoordinateVersion;
use Illuminate\Support\Facades\Auth;

class UserCoordinateObserver
{
    /**
     * Handle the UserCoordinate "created" event.
     *
     * @param  \App\Models\UserCoordinate  $userCoordinate
     * @return void
     */
    public function created(UserCoordinate $userCoordinate)
    {
        if (Auth::user() !== null) {
//            dd(Auth::user());
            $version = new UserCoordinateVersion($userCoordinate->toArray());
            $version->fill([
                'version' => 1,
                'version_created_at' => now(),
                'version_created_by' => Auth::user()->id,
                'version_comment' => 'creation user coordinate'
            ]);
            $version->save();

            $userCoordinate->fill([
                'version' => $version->version,
                'version_created_at' => $version->version_created_at,
                'version_created_by' => $version->version_created_by,
                'version_comment' => $version->version_comment
            ]);
            $userCoordinate->saveQuietly();
        }
    }

    /**
     * Handle the UserCoordinate "updated" event.
     *
     * @param  \App\Models\UserCoordinate  $userCoordinate
     * @return void
     */
    public function updated(UserCoordinate $userCoordinate)
    {
        if (Auth::user() !== null) {
//            dd(Auth::user());
            $version = new UserCoordinateVersion($userCoordinate->toArray());
            $version->fill([
                'version' => $userCoordinate->version + 1,
                'version_created_at' => now(),
                'version_created_by' => Auth::user()->id,
                'version_comment' => 'modification user coordinate'
            ]);
            $version->save();

            $userCoordinate->fill([
                'version' => $version->version,
                'version_created_at' => $version->version_created_at,
                'version_created_by' => $version->version_created_by,
                'version_comment' => $version->version_comment
            ]);
            $userCoordinate->saveQuietly();
        }
    }

    /**
     * Handle the UserCoordinate "deleted" event.
     *
     * @param  \App\Models\UserCoordinate  $userCoordinate
     * @return void
     */
    public function deleted(UserCoordinate $userCoordinate)
    {
        //
    }

    /**
     * Handle the UserCoordinate "restored" event.
     *
     * @param  \App\Models\UserCoordinate  $userCoordinate
     * @return void
     */
    public function restored(UserCoordinate $userCoordinate)
    {
        //
    }

    /**
     * Handle the UserCoordinate "force deleted" event.
     *
     * @param  \App\Models\UserCoordinate  $userCoordinate
     * @return void
     */
    public function forceDeleted(UserCoordinate $userCoordinate)
    {
        //
    }
}
