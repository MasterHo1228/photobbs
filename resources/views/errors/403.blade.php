@extends('layouts.app')
@section('title', '403')

@section('content')
    <div style="text-align: center  ">
        <h1>403</h1>
        <h2>无权限</h2>
        <a style='text-align: center' href="{{ redirect()->back()->getTargetUrl() }}">返回上一页</a>
    </div>
@stop
