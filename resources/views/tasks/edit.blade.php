@extends('layouts.app')

@section('content')

<div class="container">
  <div class="card m-4">
    <div class="card-header">
      <h4>{{ __('tasks.edit_task') }}</h4>
    </div>
    <div class="card-body">
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form method="post" action="{{ route('tasks.update', $task) }}">
        @method('PUT')
        @csrf
        <div class="form-group mt-2">
          <label for="subject">{{ __('tasks.subject') }}</label>
          <input type="text" class="form-control" name="subject" value="{{ $task->subject }}"/>
        </div>
        <div class="form-group mt-2">
          <label for="description">{{ __('tasks.description') }}</label>
          <textarea class="form-control" name="description" rows="7">{{ $task->description }}</textarea>
        </div>
        <div class="form-group mt-2">
          <label for="start_at">{{ __('tasks.start_at') }}</label>
          <input type="datetime-local" name="start_at" id="start_at" class="form-control datetimepicker" value="{{ $task->start_at }}">
        </div>
        <div class="form-group mt-2">
          <label for="finish_at">{{ __('tasks.finish_at') }}</label>
          <input type="datetime-local" name="finish_at" id="finish_at" class="form-control datetimepicker" value="{{ $task->finish_at }}">
        </div>
        @if( $task->file_path )
        <div class="form-group mt-2">
          <label class="custom-file-label" for="file">{{ __('tasks.file_label') }}</label>
          <a href="{{ asset($task->file_path) }}"></a>
        </div>
        @endif


        <div class="form-group mt-2">
          <label for="status">{{ __('tasks.status') }}</label>
          <select name="status" id="status" class="form-control">
            <option value="0" @selected(0 == $task->status)>
                открыта
            </option>
            <option value="1" @selected(1 == $task->status)>
                закрыта
            </option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary mt-5">{{ __('tasks.save_task') }}</button>
      </form>
    </div>
  </div>
</div>
@endsection
