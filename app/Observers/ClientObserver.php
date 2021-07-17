<?php

namespace App\Observers;

use App\Client;
use App\ClientTrace;
use App\Traits\ModelObserver;
class ClientObserver
{
    use ModelObserver;
    /**
     * Handle the client "created" event.
     *
     * @param  \App\Client  $client
     * @return void
     */
    public function created(Client $client)
    {
        $clientTrace = new ClientTrace;
        $modelTrack=$this->storeTrackDetails($client,'Created',$clientTrace);
        $modelTrack->client_id=$client->id;
        $modelTrack->save();
    }

    /**
     * Handle the client "updated" event.
     *
     * @param  \App\Client  $client
     * @return void
     */
    public function updated(Client $client)
    {
        $clientTrace = new ClientTrace;
        $modelTrack=$this->storeTrackDetails($client,'Updated',$clientTrace);
        $modelTrack->client_id=$client->id;
        $modelTrack->save();
    }

    /**
     * Handle the client "deleted" event.
     *
     * @param  \App\Client  $client
     * @return void
     */
    public function deleted(Client $client)
    {
        $clientTrace = new ClientTrace;
        $modelTrack=$this->storeTrackDetails($client,'Deleted',$clientTrace);
        $modelTrack->client_id=$client->id;
        $modelTrack->save();
    }

   
}
