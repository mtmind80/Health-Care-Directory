<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Task;
use App\Http\Requests\TaskRequest;

use EquationTrait;

class TasksController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-task')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $tasks = Task::sortable()->paginate($perPage);

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'tasks'    => $tasks,
            'needle'   => null,
            'seo'      => [
                'pageTitle' => 'Task',
            ],
        ];

        return view('task.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-task')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $tasks = Task::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'tasks'    => $tasks,
            'needle'   => $needle,
            'seo'      => [
                'pageTitle' => 'Tasks',
            ],
        ];

        return view('task.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-task')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'usersCB'  => \App\User::usersCB(['0' => 'Select User']),
            'seo'      => [
                'pageTitle' => 'Create Task',
            ],
        ];

        return view('task.create', $data);
    }

    public function store(TaskRequest $request)
    {
        if ($this->authUserCannot('create-task')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $inputs['creator_id'] = \Auth::user()->id;

        if (empty($inputs['completed'])) {
            $inputs['completed'] = 0;
        }

        if (!empty($inputs['remind_at'])) {
            $inputs['remind_at'] = date('Y-m-d', strtotime($inputs['remind_at']));
        }
        if (!empty($inputs['due_at'])) {
            $inputs['due_at'] = date('Y-m-d', strtotime($inputs['due_at']));
        }

        Task::create($inputs);

        return redirect()->route('task_list_path')->withSuccess('Task created.');
    }

    public function edit(Task $task)
    {
        if ($this->authUserCannot('update-task')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'task'     => $task,
            'equation' => $this->equation(),
            'usersCB'  => \App\User::usersCB(),
            'seo'      => [
                'pageTitle' => 'Edit: ' . $task->name,
            ],
        ];

        return view('task.edit', $data);
    }

    public function update(Task $task, TaskRequest $request)
    {
        if ($this->authUserCannot('update-task')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (!empty($inputs['completed_at'])) {
            $inputs['completed_at'] = date('Y-m-d', strtotime($inputs['completed_at']));
        }
        if (!empty($inputs['remind_at'])) {
            $inputs['remind_at'] = date('Y-m-d', strtotime($inputs['remind_at']));
        }
        if (!empty($inputs['due_at'])) {
            $inputs['due_at'] = date('Y-m-d', strtotime($inputs['due_at']));
        }

        $task->update($inputs);

        return redirect()->route('task_list_path')->with('success', 'Task updated.');
    }

    public function inlineUpdate(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $input = $request->all();

            $id = $input['pk'];
            $name = $input['name'];
            $value = $input['value'];
            $rule = (isset($input['rule'])) ? $input['rule'] : 'text';

            $validator = \Validator::make(
                [$name => $value],
                [$name => $rule]
            );

            if ($validator->fails()) {
                $response = [
                    'status'  => 'error',
                    'message' => $validator->messages()->first(),
                ];
            } else {
                $task = Task::find($id);
                $task->{$name} = $value;
                $task->save();

                $response = [
                    'status' => 'success',
                ];
            }
        } else {
            $response = [
                'status'  => 'error',
                'message' => 'Invalid request.',
            ];
        }

        return json_encode($response);
    }

    public function toggleStatus(Request $request)
    {
        if ($this->authUserCannot('complete-task')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $task = Task::find($request->taskId);

        $task->completed = !$task->completed;
        $task->completed_at = $task->completed ? \Carbon\Carbon::now() : null;
        $task->response = $request->response;

        $task->save();

        return redirect()->back()->withSuccess('Task marked as ' . ($task->completed ? '"completed".' : '"no completed".'));
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-task')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no task selected.');
        }
        $arrCid = explode('|', $strCid);

        Task::destroy($arrCid);

        return redirect()->route('task_list_path')->withSuccess('Task deleted.');
    }

}