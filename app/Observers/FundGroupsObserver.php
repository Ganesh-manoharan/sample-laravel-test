<?php

namespace App\Observers;

use App\FundGroups;
use App\Traits\ModelObserver;
use App\FundGroupsTrace;
class FundGroupsObserver
{
    use ModelObserver;
    /**
     * Handle the fund groups "created" event.
     *
     * @param  \App\FundGroups  $fundGroups
     * @return void
     */
    public function created(FundGroups $fundGroups)
    {
        $fundsGroupTrace = new FundGroupsTrace;
        $modelTrack=$this->storeTrackDetails($fundGroups,'Created',$fundsGroupTrace);
        $modelTrack->fund_groups_id=$fundGroups->id;
        $modelTrack->save();
    }

    /**
     * Handle the fund groups "updated" event.
     *
     * @param  \App\FundGroups  $fundGroups
     * @return void
     */
    public function updated(FundGroups $fundGroups)
    {
        $fundsGroupTrace = new FundGroupsTrace;
        $modelTrack=$this->storeTrackDetails($fundGroups,'Updated',$fundsGroupTrace);
        $modelTrack->fund_groups_id=$fundGroups->id;
        $modelTrack->save();
    }

    /**
     * Handle the fund groups "deleted" event.
     *
     * @param  \App\FundGroups  $fundGroups
     * @return void
     */
    public function deleted(FundGroups $fundGroups)
    {
        $fundsGroupTrace = new FundGroupsTrace;
        $modelTrack=$this->storeTrackDetails($fundGroups,'Deleted',$fundsGroupTrace);
        $modelTrack->fund_groups_id=$fundGroups->id;
        $modelTrack->save();
    }

    
}
