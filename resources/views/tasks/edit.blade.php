<div class="modal fade" id="editTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="editTaskForm" class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Edit Task</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="id" id="edit-id">

                <div class="mb-3">
                    <label>Title</label>
                    <input name="title" id="edit-title" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" id="edit-description" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Priority</label>
                    <select name="priority" id="edit-priority" class="form-select">
                        <option value="1">Low</option>
                        <option value="2">Medium</option>
                        <option value="3">High</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Deadline</label>
                    <input type="date" name="deadline" id="edit-deadline" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" id="edit-status" class="form-select">
                        <option value="1">Todo</option>
                        <option value="2">Doing</option>
                        <option value="3">Review</option>
                        <option value="4">Done</option>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Update Task</button>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    var editModal = document.getElementById('editTaskModal');

    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        var id = button.getAttribute('data-id');
        var url = '/tasks/' + id;

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-title').value = button.getAttribute('data-title');
        document.getElementById('edit-description').value = button.getAttribute('data-description');
        document.getElementById('edit-priority').value = button.getAttribute('data-priority');
        document.getElementById('edit-deadline').value = button.getAttribute('data-deadline');
        document.getElementById('edit-status').value = button.getAttribute('data-status');

        document.getElementById('editTaskForm').action = url;
    });
});
</script>
@endpush
