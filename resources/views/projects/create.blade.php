@extends('layouts.template')
@section('title', 'Tambah Project')

@section('content')
<div class="card">
    <div class="card-header">Tambah Project</div>
    <div class="card-body">

        <form method="POST" action="{{ route('projects.store') }}">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input name="name" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="1">Planning</option>
                    <option value="2">On Progress</option>
                    <option value="3">Done</option>
                </select>
            </div>

            <button class="btn btn-primary">Simpan</button>
        </form>

    </div>
</div>
@endsection
