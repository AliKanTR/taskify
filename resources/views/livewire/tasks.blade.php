<div>
    <div class="container">
        @include('layouts.alerts')
        <div class="mb-4 d-flex align-items-center">
            <label class="me-2 fw-bold">Project:</label>
            @if(!empty($projects))
                <select wire:model.live="selectedProject" class="form-select w-auto">
                @foreach ($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            @endif

            <a class="ms-4" href="{{ route('projects.create') }}">Add New Project</a>
        </div>

        @if($selectedProject)
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tasks</h5>
                    <button wire:click="addTask" class="btn btn-primary btn-sm">+ Add Task</button>
                </div>

                <div class="card-body">
                    <ul wire:sortable="updateTaskOrder" id="taskList" class="list-group">
                        @forelse ($tasks as $task)
                            <li class="list-group-item d-flex align-items-center justify-content-between" wire:sortable.item="{{ $task->id }}">
                                <div wire:sortable.handle class="d-flex align-items-center w-100">
                                    <span class="me-2 drag-handle" style="cursor: grab;">&#9776;</span>
                                    <input type="text"
                                           class="form-control form-control-sm"
                                           wire:change.debounce="updateTaskName({{ $task->id }}, $event.target.value)"
                                           value="{{ $task->name }}">
                                </div>
                                <button wire:click="deleteTask({{ $task->id }})"
                                        class="btn btn-danger btn-sm ms-2">&times;</button>
                            </li>
                        @empty
                            <p>No tasks were added for this project yet.</p>
                        @endforelse
                    </ul>

                    <div class="mt-3">
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
