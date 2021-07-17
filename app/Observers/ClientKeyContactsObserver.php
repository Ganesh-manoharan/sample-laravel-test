<?php

namespace App\Observers;

use App\ClientKeyContacts;
use  App\ClientKeycontactTrace;
use App\Traits\ModelObserver;
class ClientKeyContactsObserver
{
    use ModelObserver;
    /**
     * Handle the client key contacts "created" event.
     *
     * @param  \App\ClientKeyContacts  $clientKeyContacts
     * @return void
     */
    public function created(ClientKeyContacts $clientKeyContacts)
    {
        $clientKeyContactsTrace = new ClientKeycontactTrace;
        $modelTrack = $this->storeTrackDetails($clientKeyContacts, 'Created', $clientKeyContactsTrace);
        $modelTrack->client_keycontacts_id = $clientKeyContacts->id;
        $modelTrack->client_id = $clientKeyContacts->getClient->id;
        $modelTrack->save();
    }

    /**
     * Handle the client key contacts "updated" event.
     *
     * @param  \App\ClientKeyContacts  $clientKeyContacts
     * @return void
     */
    public function updated(ClientKeyContacts $clientKeyContacts)
    {
        $clientKeyContactsTrace = new ClientKeycontactTrace;
        $modelTrack = $this->storeTrackDetails($clientKeyContacts, 'Updated', $clientKeyContactsTrace);
        $modelTrack->client_keycontacts_id = $clientKeyContacts->id;
        $modelTrack->client_id = $clientKeyContacts->getClient->id;
        $modelTrack->save();
    }

    /**
     * Handle the client key contacts "deleted" event.
     *
     * @param  \App\ClientKeyContacts  $clientKeyContacts
     * @return void
     */
    public function deleted(ClientKeyContacts $clientKeyContacts)
    {
        $clientKeyContactsTrace = new ClientKeycontactTrace;
        $modelTrack = $this->storeTrackDetails($clientKeyContacts, 'Deleted', $clientKeyContactsTrace);
        $modelTrack->client_keycontacts_id = $clientKeyContacts->id;
        $modelTrack->client_id = $clientKeyContacts->getClient->id;
        $modelTrack->save();
    }

   
}
