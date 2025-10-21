<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class Tasks extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $selectedProject;

    private const int RESULTS_PER_PAGE = 10;

    public function selectProject($projectId): void
    {
        $project = Project::find($projectId);
        $this->authorize('view', $project);

        $this->selectedProject = $projectId;
    }

    public function updateTaskOrder($tasks): void
    {
        try {
            \DB::transaction(function () use ($tasks) {
                foreach ($tasks as $task) {
                    Task::where('id', $task['value'])
                        ->update(['priority' => $task['order']]);
                }
            });
        } catch (\Throwable $th) {
            session()->flash('error', sprintf('Something went wrong while updating the tasks order: %s', $th->getMessage()));
        }
    }

    public function addTask(): void
    {
        $this->authorize('view', Project::find($this->selectedProject));

        $task = new Task();
        $task->project_id = $this->selectedProject;
        $task->user_id = auth()->user()->id;
        $task->name = 'New Task';
        $task->save();

        session()->flash('success', 'Task added successfully.');
    }

    public function updateTaskName($id, $value): void
    {
        \Validator::make(
            ['value' => $value],
            ['value' => 'required|string']
        )->validate();

        $task = Task::find($id);
        $this->authorize('update', $task);
        $task->update(['name' => $value]);

        session()->flash('success', 'You have successfully updated the task name.');
    }

    public function deleteTask($id): void
    {
        $task = Task::find($id);
        $this->authorize('delete', $task);
        $task->delete();

        if (Task::where('project_id', $task->project_id)->count() <= self::RESULTS_PER_PAGE) {
            $this->resetPage(); // reset pagination
        }

        session()->flash('success', 'Task deleted successfully.');
    }

    public function mount(): void
    {
        $this->selectedProject = auth()->user()->projects()->first()?->id;
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.tasks', [
            'projects' => auth()->user()->projects,
            'tasks' => Task::where('project_id', $this->selectedProject)->where('user_id', auth()->user()->id)->orderBy('priority')->orderBy('created_at', 'desc')->paginate(self::RESULTS_PER_PAGE),
        ]);
    }
}
