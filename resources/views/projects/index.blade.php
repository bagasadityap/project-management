@extends('layouts.template')
@section('title', 'Project List')

@section('content')

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Total Project</h5>
                <h2>{{ $totalProjects }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        Statistik Task Selesai (Done) per Bulan
    </div>
    <div class="card-body">
        <canvas id="doneChart" height="80"></canvas>
    </div>
</div>

<div class="d-flex justify-content-between mb-3">
    <h2>Project List</h2>

    <div class="d-flex gap-2">
        <select id="filter-problem" class="form-select">
            <option value="">Semua Project</option>
            <option value="problem">Project Bermasalah</option>
            <option value="normal">Project Normal</option>
        </select>

        <a href="{{ route('projects.create') }}" class="btn btn-primary">Tambah Project</a>
    </div>
</div>

<table class="table table-bordered" id="project-table">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Start</th>
            <th>End</th>
            <th>Status</th>
            <th>Total Task</th>
            <th>Progress</th>
            <th>Problem?</th>
            <th>Aksi</th>
        </tr>
    </thead>
</table>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const doneLabels = @json($chartLabels);
    const doneData   = @json($chartData);

    const ctx = document.getElementById('doneChart').getContext('2d');
    const doneChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: doneLabels,
            datasets: [{
                label: 'Task Done',
                data: doneData,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });

    $(function() {
        var table = $('#project-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("projects.index") }}',
                data: function (d) {
                    d.problem = $('#filter-problem').val();
                }
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'start_date' },
                { data: 'end_date' },
                { data: 'status_label', orderable:false, searchable:false },
                { data: 'tasks_count' },
                { data: 'progress', orderable:false, searchable:false },
                { data: 'is_problem', orderable:false, searchable:false },
                { data: 'action', orderable:false, searchable:false }
            ]
        });

        $('#filter-problem').change(function() {
            table.ajax.reload();
        });
    });
</script>
@endpush
