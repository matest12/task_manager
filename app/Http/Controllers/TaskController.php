<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;

use App\Rules\TooManyTasksRule;

class TaskController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {


    if ( auth()->user()->can('is-admin') ) {
      $tasks = Task::orderBy('id', 'desc')->paginate(25);
    } else {
      $tasks = Task::where( 'user_id', auth()->user()->id )->paginate(25);
    }

    return view('tasks.list', compact('tasks'));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('tasks.create');
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \App\Http\Requests\StoreTaskRequest  $request
  * @return \Illuminate\Http\Response
  */
  public function store(StoreTaskRequest $request)
  {
    $request_data = $request->all();

    $request->validate([
      'subject'     => 'required',
      'description' => 'required',
      'file'        => 'file|mimes:doc,docx,txt,xls,xlsx|max:2048',
      'start_at' => 'required|after:now',
      'finish_at' => ['required', 'after:start_at', new TooManyTasksRule($request_data)],
    ]);

    $user_id = auth()->user()->id;

    $data = [
      'subject'     => $request_data['subject'],
      'description' => $request_data['description'],
      'start_at'    => $request_data['start_at'],
      'finish_at'   => $request_data['finish_at'],
      'user_id'     => $user_id,
      'status'      => 0
    ];

    if( $request->file() ) {
      $original_name = $request->file->getClientOriginalName();
      $file_name = time().'_'.$original_name;
      $path = $request->file('file')->storeAs('uploads', $file_name, 'public');

      $data['file_path'] = '/storage/' . $path;
    }

    $task = Task::create($data);
    return redirect()->route('tasks.index')->with('status', __('messages.task_created'));
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Models\Task  $task
  * @return \Illuminate\Http\Response
  */
  public function show(Task $task)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Models\Task  $task
  * @return \Illuminate\Http\Response
  */
  public function edit(Task $task)
  {
    if ( auth()->user()->can('is-admin') ) {
      return view('tasks.edit', compact('task'));
    }

    return redirect()->route('tasks.index')->with('status', __('messages.access'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \App\Http\Requests\UpdateTaskRequest  $request
  * @param  \App\Models\Task  $task
  * @return \Illuminate\Http\Response
  */
  public function update(UpdateTaskRequest $request, Task $task)
  {
    if ( auth()->user()->can('is-admin') ) {
      $request_data = $request->all();

      $task->update($request_data);

      return redirect()->route('tasks.index')->with('status', __('messages.task_updated'));
    }

    return redirect()->route('tasks.index')->with('status', __('messages.access'));

  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Models\Task  $task
  * @return \Illuminate\Http\Response
  */
  public function destroy(Task $task)
  {
    //
  }
}
