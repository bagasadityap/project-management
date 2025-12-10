<div class="modal fade" id="showTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail Task</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <p><strong>Title:</strong> <span id="show-title"></span></p>
                <p><strong>Description:</strong> <span id="show-description"></span></p>
                <p><strong>Priority:</strong> <span id="show-priority"></span></p>
                <p><strong>Deadline:</strong> <span id="show-deadline"></span></p>
                <p><strong>Status:</strong> <span id="show-status"></span></p>

            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    var showModal = document.getElementById('showTaskModal');

    showModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        document.getElementById('show-title').innerText = button.getAttribute('data-title');
        document.getElementById('show-description').innerText = button.getAttribute('data-description');
        document.getElementById('show-priority').innerText =
            ['Low','Medium','High'][button.getAttribute('data-priority') - 1];
        document.getElementById('show-deadline').innerText = button.getAttribute('data-deadline');
        document.getElementById('show-status').innerText =
            ['Todo','Doing','Review','Done'][button.getAttribute('data-status') - 1];
    });
});
</script>
@endpush
