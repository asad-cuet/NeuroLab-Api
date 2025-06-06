<?php

namespace App\Traits;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

trait TorkActivityLogTrait
{
    use LogsActivity;

    /*
    |--------------------------------------------------------------------------
    | Some things for future
    |--------------------------------------------------------------------------
    |
    | Get the model name: $this->getModelName();
    | ignore logging: return;   [use this in TapActivity()]
    |
    */

    public function TapActivity(Activity $activity, string $eventName)
    {
        $activity->ip_address = request()->ip();
    }

    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
