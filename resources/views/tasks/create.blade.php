<div class="modal fade" id="taskModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('tasks.store') }}" class="modal-content">
            @csrf

            <input type="hidden" name="project_id" value="{{ $project->id }}">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Task</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label>Title</label>
                    <input name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Priority</label>
                    <select name="priority" class="form-select">
                        <option value="1">Low</option>
                        <option value="2">Medium</option>
                        <option value="3">High</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Deadline</label>
                    <input type="date" name="deadline" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="1">Todo</option>
                        <option value="2">Doing</option>
                        <option value="3">Review</option>
                        <option value="4">Done</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>
