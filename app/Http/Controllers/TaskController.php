<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Task;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

     /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        //Ensure that user is loged into the right account to delete task
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }

    public function getTaskById($id)
    {
    	$task = new Task();

        $result = $task->find($id);
        //Ensure that user is loged into the right account to view task
        $this->authorize('view', $result);

    	// return $result;
    	return view('tasks.edit', ['task' => $result]);
    }

    public function updateTaskById($id, Request $request)
    {
        $task = Task::find($id);

        //Ensure that user is loged into the right account to update task
        $this->authorize('update', $task);

        // validate
        $this->validate($request, [
            'task-name' => 'required|max:255',
        ]);

        // set data
	    if (isset($request['task-name'])) {
	        $task->name = $request['task-name'];
	    }

	    // update
        $task->update();

	    // redirect to tasks page
	    return redirect('/tasks');;
    }
}
