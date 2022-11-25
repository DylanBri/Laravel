<?php

namespace App\Observers;

use App\Models\Client;
use App\Models\ClientVersion;
use Illuminate\Support\Facades\Auth;

class ClientObserver
{
    /**
     * Handle the Client "created" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function created(Client $client)
    {
        if (Auth::user() !== null) {
//            dd(Auth::user());
            $version = new ClientVersion($client->toArray());
            $version->fill([
                'version' => 1,
                'version_created_at' => now(),
                'version_created_by' => Auth::user()->id,
                'version_comment' => 'creation user coordinate'
            ]);
            $version->save();

            $client->fill([
                'version' => $version->version,
                'version_created_at' => $version->version_created_at,
                'version_created_by' => $version->version_created_by,
                'version_comment' => $version->version_comment
            ]);
            $client->saveQuietly();
        }
    }

    /**
     * Handle the Client "updated" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function updated(Client $client)
    {
        if (Auth::user() !== null) {
//            dd(Auth::user());
            $version = new ClientVersion($client->toArray());
            $version->fill([
                'version' => $client->version + 1,
                'version_created_at' => now(),
                'version_created_by' => Auth::user()->id,
                'version_comment' => 'modification user coordinate'
            ]);
            $version->save();

            $client->fill([
                'version' => $version->version,
                'version_created_at' => $version->version_created_at,
                'version_created_by' => $version->version_created_by,
                'version_comment' => $version->version_comment
            ]);
            $client->saveQuietly();
        }
    }

    /**
     * Handle the Client "deleted" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function deleted(Client $client)
    {
        //
    }

    /**
     * Handle the Client "restored" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function restored(Client $client)
    {
        //
    }

    /**
     * Handle the Client "force deleted" event.
     *
     * @param  \App\Models\Client  $client
     * @return void
     */
    public function forceDeleted(Client $client)
    {
        //
    }
}
