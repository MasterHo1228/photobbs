@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

<div class="row">

  @include('users._stat')

  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <div class="card ">
      <div class="card-body">
          <h1 class="mb-0" style="font-size:22px;">{{ $user->nickname }} <small>{{ $user->email }}</small></h1>
      </div>
    </div>
    <hr>

    @include('users._info')

  </div>
</div>
@stop
