<?php

namespace App\Observers;

use App\DepartmentMembers;
use App\DepartmentMemberTrace;
use App\Traits\ModelObserver;

class DepartmentMemberObserver
{
    use ModelObserver;
    /**
     * Handle the department members "created" event.
     *
     * @param  \App\DepartmentMembers  $departmentMembers
     * @return void
     */
    public function created(DepartmentMembers $departmentMembers)
    {
        $departmentTrace = new DepartmentMemberTrace;
        $modelTrack = $this->storeTrackDetails($departmentMembers, 'Created', $departmentTrace);
        $modelTrack->department_members_id = $departmentMembers->id;
        $modelTrack->department_id = $departmentMembers->getDepartment->id;
        $modelTrack->save();
    }

    /**
     * Handle the department members "updated" event.
     *
     * @param  \App\DepartmentMembers  $departmentMembers
     * @return void
     */
    public function updated(DepartmentMembers $departmentMembers)
    {
        $departmentTrace = new DepartmentMemberTrace;
        $modelTrack = $this->storeTrackDetails($departmentMembers, 'Updated', $departmentTrace);
        $modelTrack->department_members_id = $departmentMembers->id;
        $modelTrack->department_id = $departmentMembers->getDepartment->id;
        $modelTrack->save();
    }

    /**
     * Handle the department members "deleted" event.
     *
     * @param  \App\DepartmentMembers  $departmentMembers
     * @return void
     */
    public function deleted(DepartmentMembers $departmentMembers)
    {
        $departmentTrace = new DepartmentMemberTrace;
        $modelTrack = $this->storeTrackDetails($departmentMembers, 'Deleted', $departmentTrace);
        $modelTrack->department_members_id = $departmentMembers->id;
        $modelTrack->department_id = $departmentMembers->getDepartment->id;
        $modelTrack->save();
    }

    
}
