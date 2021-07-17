<?php

namespace App\Http\Traits;

trait CommonTrait{
	
	public static function task_filter_options()
	{
        
		return [
            [
                'name' => 'Active',
                'value' => 1,
                'completion_status' => 0,
            ],
            [
                'name' => 'Urgent',
                'value' => 2,
                'completion_status' => 0,
            ],
            [
                'name' => 'Overdue',
                'value' => 3,
                'completion_status' => 0,
            ],
            [
                'name' => 'Completed',
                'value' => 4,
                'completion_status' => 1,
            ],
            [
                'name' => 'Awaiting approval',
                'value' => 5,
                'completion_status' => 2,
            ],
        ];
	}

    public static function issue_filter_options()
	{
        
		return [
            [
                'name' => 'In Progress',
                'value' => 3,
                'completion_status' => 0,
            ],
            [
                'name' => 'Resolved',
                'value' => 4,
                'completion_status' => 1,
            ],
            [
                'name' => 'Awaiting Review',
                'value' => 5,
                'completion_status' => 2,
            ],
        ];
	}
}
?>