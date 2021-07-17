<?php

namespace App\Observers;

use App\FundsKeyContact;
use App\FundsKeyContactTrace;
use App\Traits\ModelObserver;
class FundKeyContactsObserver
{
    use ModelObserver;
    /**
     * Handle the funds key contact "created" event.
     *
     * @param  \App\FundsKeyContact  $fundsKeyContact
     * @return void
     */
    public function created(FundsKeyContact $fundsKeyContact)
    {
        $departmentTrace = new FundsKeyContactTrace;
        $modelTrack = $this->storeTrackDetails($fundsKeyContact, 'Created', $departmentTrace);
        $modelTrack->funds_keycontact_id = $fundsKeyContact->id;
        $modelTrack->fund_groups_id = $fundsKeyContact->getFundGroup->id;
        $modelTrack->save();
    }

    /**
     * Handle the funds key contact "updated" event.
     *
     * @param  \App\FundsKeyContact  $fundsKeyContact
     * @return void
     */
    public function updated(FundsKeyContact $fundsKeyContact)
    {
        $departmentTrace = new FundsKeyContactTrace;
        $modelTrack = $this->storeTrackDetails($fundsKeyContact, 'Updated', $departmentTrace);
        $modelTrack->funds_keycontact_id = $fundsKeyContact->id;
        $modelTrack->fund_groups_id = $fundsKeyContact->getFundGroup->id;
        $modelTrack->save();
    }

    /**
     * Handle the funds key contact "deleted" event.
     *
     * @param  \App\FundsKeyContact  $fundsKeyContact
     * @return void
     */
    public function deleted(FundsKeyContact $fundsKeyContact)
    {
        $departmentTrace = new FundsKeyContactTrace;
        $modelTrack = $this->storeTrackDetails($fundsKeyContact, 'Deleted', $departmentTrace);
        $modelTrack->funds_keycontact_id = $fundsKeyContact->id;
        $modelTrack->fund_groups_id = $fundsKeyContact->getFundGroup->id;
        $modelTrack->save();
    }

    
}
