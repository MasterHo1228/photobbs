@extends('layouts.default')
@section('title',$user->name)

@section('content')
<div class="row">
  <div class="offset-md-2 col-md-8">
    <div class="col-md-12">
      <div class="offset-md-2 col-md-8">
        <section class="user_info">
          @include('shared._user_info', ['user' => $user])
        </section>
        <section class="article">
          @if ($articles->count() > 0)
            <ul class="list-unstyled">
              @foreach ($articles as $article)
                @include('articles._article')
              @endforeach
            </ul>
            <div class="mt-5">
              {!! $articles->render() !!}
            </div>
          @else
            <p>没有数据！</p>
          @endif
        </section>
      </div>
    </div>
  </div>
</div>
@stop
