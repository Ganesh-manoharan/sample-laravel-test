<?php

namespace App\Observers;

use App\Departments;
use App\DepartmentTrace;
use App\Traits\ModelObserver;
class DepartmentsObserver
{
    use ModelObserver;
    /**
     * Handle the departments "created" event.
     *
     * @param  \App\Departments  $departments
     * @return void
     */
    public function created(Departments $departments)
    {
       $departmentTrace = new DepartmentTrace;
       $modelTrack=$this->storeTrackDetails($departments,'Created',$departmentTrace);
       $modelTrack->department_id=$departments->id;
       $modelTrack->save();
    }

    /**
     * Handle the departments "updated" event.
     *
     * @param  \App\Departments  $departments
     * @return void
     */
    public function updated(Departments $departments)
    {
        $departmentTrace = new DepartmentTrace;
        $modelTrack=$this->storeTrackDetails($departments,'Updated',$departmentTrace);
        $modelTrack->department_id=$departments->id;
        $modelTrack->save();
    }

    /**
     * Handle the departments "deleted" event.
     *
     * @param  \App\Departments  $departments
     * @return void
     */
    public function deleted(Departments $departments)
    {
        $departmentTrace = new DepartmentTrace;
        $modelTrack=$this->storeTrackDetails($departments,'Deleted',$departmentTrace);
        $modelTrack->department_id=$departments->id;
        $modelTrack->save();
    }

    
}
