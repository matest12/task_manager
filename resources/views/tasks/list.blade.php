@extends('layouts.app')

@section('content')

<div class="container">

  @if(session('status'))
  <div class="alert alert-success alert-dismissible" role="alert">
    <span class="text-sm">{{ session('status') }}</span>
  </div>
  @endif

  <div class="card m-4">
    <div class="card-header">
      <h4>{{ __('tasks.list_task') }}</h4>
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

      <table class="table table-bordered data-table">

        <thead>

          <tr>

            <th>{{ __('tasks.id') }}</th>
            <th>{{ __('tasks.subject') }}</th>
            <th style="width: 30%;">{{ __('tasks.description') }}</th>

            @if( auth()->user()->can('is-admin') )
            <th>{{ __('tasks.client') }}</th>
            <th>{{ __('tasks.email') }}</th>
            @endif

            <th>{{ __('tasks.file') }}</th>
            <th>{{ __('tasks.created_at') }}</th>
            <th>{{ __('tasks.start_at') }}</th>
            <th>{{ __('tasks.finish_at') }}</th>

            @if( auth()->user()->can('is-admin') )
            <th></th>
            @endif
          </tr>

        </thead>

        <tbody>

          @forelse($tasks as $task)
          <tr
          @if($task->status)
          class="table-success"
          @else
          class="table-danger"
          @endif
          >
          <td>{{ $task->id }}</td>
          <td>{{ $task->subject }}</td>
          <td>{{ $task->description }}</td>

          @if( auth()->user()->can('is-admin') )
          <td>{{ $task->user->name }}</td>
          <td>{{ $task->user->email }}</td>
          @endif

          <td>
            @if( isset($task->file_path) )
            <a href="{{ asset($task->file_path ) }}">Скачать файл</a>
            @endif
          </td>
          <td>{{ $task->created_at->format('d.m.Y') }}</td>
          <td>{{ $task->start_at->format('d.m.Y H:i') }}</td>
          <td>{{ $task->finish_at->format('d.m.Y H:i') }}</td>

          @if( auth()->user()->can('is-admin') )
          <td>
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-success fs-4 lh-1">&#9998;</a>
          </td>
          @endif
        </tr>
        @empty

        <tr>

          <td colspan="9" class="text-center">{{ __('messages.empty') }}</td>

        </tr>

        @endforelse

      </tbody>

    </table>

    {!! $tasks->withQueryString()->links('pagination::bootstrap-5') !!}
  </div>
</div>
</div>
@endsection
