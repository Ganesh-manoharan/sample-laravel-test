<?php
namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

trait ModelObserver
{
    public static function storeTrackDetails($model, $action, $trackModel)
    {
        $updateDetails = $model->getChanges();
        unset($updateDetails['updated_at']);
        $trackModel->modified_by = Auth::check() ? Auth::user()->id : null;
        $trackModel->modified_columns = json_encode(array_keys($updateDetails));
        $trackModel->action = $action;
        $trackModel->save();
        return $trackModel;
    }
}
