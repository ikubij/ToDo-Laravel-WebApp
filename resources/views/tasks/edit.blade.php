@extends('layouts.app')

@section('title', 'Edit')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-6 offset-sm-3 col-md-6 offset-md-3">
      
      <div class="my-3">

        @if (isset($task))

          <h3 class="text-center">Edit Task #{{ $task->id }}</h3>

          <form action="/task/{{ $task->id }}" method="POST">
            {{ csrf_field() }}

            {{ method_field('PUT') }}

            <!-- Todo title -->
            <div class="form-group">
              <label for="task-name" class="control-label">Task Title</label>
              <input type="text" 
                     name="task-name" 
                     id="task-name" 
                     class="form-control" 
                     value="{{ $task->name }}"
                     maxlength="100" 
                     required>
            </div>

            <!-- button -->
            <div class="float-right">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>

        @else
        <p class="text-center">Todo task does not exists!</p>
        @endif

      </div>

    </div>
  </div>
</div>
@endsection