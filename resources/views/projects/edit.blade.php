@extends('layouts.template')
@section('title', 'Edit Project')

@section('content')
<div class="card">
    <div class="card-header">Edit Project</div>
    <div class="card-body">

        <form method="POST" action="{{ route('projects.update', $project->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input name="name" value="{{ $project->name }}" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Start Date</label>
                    <input type="date" name="start_date" value="{{ $project->start_date }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>End Date</label>
                    <input type="date" name="end_date" value="{{ $project->end_date }}" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="1" @selected($project->status==1)>Planning</option>
                    <option value="2" @selected($project->status==2)>On Progress</option>
                    <option value="3" @selected($project->status==3)>Done</option>
                </select>
            </div>

            <button class="btn btn-primary">Update</button>
        </form>

    </div>
</div>
@endsection
