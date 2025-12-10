<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function taskCount()
    {
        return $this->tasks()->count();
    }

    public function taskStatusSummary()
    {
        return $this->tasks()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');
    }

    public function progress()
    {
        $total = $this->tasks()->count();
        if ($total === 0) return 0;

        $done = $this->tasks()->where('status', 4)->count(); // 4 = Done

        return round(($done / $total) * 100, 2);
    }

    public static function taskDoneStatistics()
    {
        return Task::selectRaw('YEAR(updated_at) AS year, MONTH(updated_at) AS month, COUNT(*) AS total')
            ->where('status', 4)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
    }

    public static function projectDoneStatistics()
    {
        return Project::selectRaw('YEAR(updated_at) AS year, MONTH(updated_at) AS month, COUNT(*) AS total')
            ->where('status', 3)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
    }

    public function isProblematic()
    {
        $overdueExist = $this->tasks()
            ->where('deadline', '<', now())
            ->exists();

        return $overdueExist && $this->progress() < 50 && $this->status != 3;
    }
}
