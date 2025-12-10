<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Project::withCount('tasks')->with('tasks');

            if ($request->problem === 'problem') {
                $query->whereExists(function ($q) {
                    $q->selectRaw(1)
                    ->from('tasks')
                    ->whereColumn('tasks.project_id', 'projects.id')
                    ->where('tasks.status', '!=', 4)
                    ->where('tasks.deadline', '<', now());
                });
            }

            if ($request->problem === 'normal') {
                $query->whereNotExists(function ($q) {
                    $q->selectRaw(1)
                    ->from('tasks')
                    ->whereColumn('tasks.project_id', 'projects.id')
                    ->where('tasks.status', '!=', 4)
                    ->where('tasks.deadline', '<', now());
                });
            }

            return DataTables::eloquent($query)
                ->addColumn('status_label', function ($row) {
                    return [
                        1 => '<span class="badge bg-secondary">Planning</span>',
                        2 => '<span class="badge bg-info">On Progress</span>',
                        3 => '<span class="badge bg-success">Done</span>',
                    ][$row->status];
                })
                ->addColumn('progress', function ($row) {
                    $progress = $row->progress();

                    return '
                        <div class="progress" style="height: 15px;">
                            <div class="progress-bar bg-success" style="width: '.$progress.'%;">
                                '.$progress.'%
                            </div>
                        </div>
                    ';
                })
                ->addColumn('is_problem', function ($row) {
                    return $row->isProblematic()
                        ? '<span class="badge bg-danger">Bermasalah</span>'
                        : '<span class="badge bg-success">Normal</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="'.route('projects.show', $row->id).'" class="btn btn-sm btn-primary">Detail</a>
                        <a href="'.route('projects.edit', $row->id).'" class="btn btn-sm btn-warning">Edit</a>
                        <form action="'.route('projects.destroy', $row->id).'" method="POST" class="d-inline">
                            '.csrf_field().method_field("DELETE").'
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Delete?\')">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['status_label', 'progress', 'is_problem', 'action'])
                ->make(true);
        }

        $totalProjects = Project::count();

        $doneStats = Project::projectDoneStatistics();
        $chartLabels = $doneStats->map(function ($row) {
            return $row->year . '-' . str_pad($row->month, 2, '0', STR_PAD_LEFT);
        });
        $chartData = $doneStats->pluck('total');

        return view('projects.index', compact('totalProjects', 'chartLabels', 'chartData'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        Project::create($request->all());
        return redirect()->route('projects.index');
    }

    public function show(Project $project)
    {
        $project->load('tasks');

        $statusSummary = $project->taskStatusSummary();
        $statusLabels = [
            1 => 'Todo',
            2 => 'Doing',
            3 => 'Review',
            4 => 'Done',
        ];

        return view('projects.show', compact('project', 'statusSummary', 'statusLabels'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $project->update($request->all());
        return redirect()->route('projects.index');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index');
    }
}

