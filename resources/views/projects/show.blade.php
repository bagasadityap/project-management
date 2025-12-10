@extends('layouts.template')
@section('title', 'Detail Project')

@section('content')

<h2>{{ $project->name }}</h2>

<div class="mb-4">
    <span class="badge bg-info">Status:
        @if($project->status == 1) Planning
        @elseif($project->status == 2) On Progress
        @else Done
        @endif
    </span>
</div>

<div class="row mb-4">
    @foreach ($statusLabels as $code => $label)
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="fw-bold">{{ $label }}</div>
                    <h3 class="mt-2">
                        {{ $statusSummary[$code] ?? 0 }}
                    </h3>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card mb-4">
    <div class="card-header">
        Tasks
        <button class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#taskModal">+ Task</button>
    </div>

    <div class="card-body">
        <table class="table table-bordered" id="tasks-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Priority</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($project->tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>
                        @if($task->priority == 1) Low
                        @elseif($task->priority == 2) Medium
                        @else High
                        @endif
                    </td>
                    <td>{{ $task->deadline }}</td>
                    <td>
                        {{ ['Todo','Doing','Review','Done'][$task->status - 1] }}
                    </td>
                    <td>
                        <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('tasks.create')

@endsection
