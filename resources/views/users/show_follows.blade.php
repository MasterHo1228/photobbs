@extends('layouts.default')
@section('title', $title)

@section('content')
<div class="offset-md-2 col-md-8">
  <h2 class="mb-4 text-center">{{ $title }}</h2>

  <ul class="list-group list-group-flush">
    @foreach ($users as $user)
      <li class="list-group-item">
        <img class="mr-3" src="{{ $user->gravatar() }}" alt="{{ $user->name }}" width=32>
        <a href="{{ route('users.show', $user) }}">
          {{ $user->name }}
        </a>
        <span class="follow-time badge"> 关注时间：{{ $user->created_at->diffForHumans() }} </span>
      </li>
    @endforeach
  </ul>

  <div class="mt-3">
    {!! $users->render() !!}
  </div>
</div>
@stop
