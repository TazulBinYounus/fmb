<?php

namespace App\Models\Concerns;

use App\Models\ActivityLog;
use Illuminate\Support\Str;

/**
 * Writes an activity-log entry when a logged-in admin creates, updates or deletes a record.
 * Models may define activityLabel() to describe themselves (defaults to name/title).
 */
trait RecordsActivity
{
    public static function bootRecordsActivity(): void
    {
        foreach (['created', 'updated', 'deleted'] as $event) {
            static::$event(function ($model) use ($event) {
                if (! auth()->check()) {
                    return;
                }
                if ($event === 'updated' && ! $model->wasChanged()) {
                    return;
                }
                $type = Str::headline(class_basename($model));
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => $event,
                    'subject_type' => $model::class,
                    'subject_id' => $model->getKey(),
                    'description' => ucfirst($event)." {$type}: ".Str::limit($model->activityLabel(), 80),
                ]);
            });
        }
    }

    public function activityLabel(): string
    {
        return (string) ($this->name ?? $this->title ?? $this->label ?? $this->question ?? '#'.$this->getKey());
    }
}
