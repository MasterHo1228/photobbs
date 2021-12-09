@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="col-md-10 offset-md-1">
      <div class="card ">

        <div class="card-body">
          <h2 class="">
            <i class="far fa-edit"></i>
            @if($topic->id)
            编辑话题
            @else
            新建话题
            @endif
          </h2>

          <hr>

          @if($topic->id)
            <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
              <input type="hidden" name="_method" value="PUT">
          @else
            <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
          @endif

              <input type="hidden" name="_token" value="{{ csrf_token() }}">

              @include('shared._error')

              <div class="form-group">
                <input class="form-control" type="text" name="title" value="{{ old('title', $topic->title ) }}" placeholder="请填写标题" required />
              </div>

              <div class="form-group">
                <select class="form-control" name="category_id" required>
                  <option value="" hidden disabled @empty($topic->category_id) selected @endempty>请选择分类</option>
                  @foreach ($categories as $value)
                  <option value="{{ $value->id }}" {{ $topic->category_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <textarea name="body" class="form-control" id="editor" rows="6" placeholder="请填入至少三个字符的内容。" required>{{ old('body', $topic->body ) }}</textarea>
              </div>

              <div class="well well-sm">
                <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i> 保存</button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('styles')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor-markdown.css') }}">
@stop

@section('scripts')
  <script type="text/javascript" src="{{ asset('js/module.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/hotkeys.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/uploader.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/simditor.min.js') }}"></script>

  <script>
    $(document).ready(function() {
      var editor = new Simditor({
        textarea: $('#editor'),
        toolbar: ['bold', 'fontScale', 'italic', 'underline', 'strikethrough', 'color', '|',
                     'ol', 'ul', 'hr', '|',
                     'blockquote', 'code', '|',
                     'image', 'alignment'],
        upload:{
          url: '{{ route('topics.upload_image') }}',
          params: {
            _token: '{{ csrf_token() }}'
          },
          fileKey: 'upload_file',
          connectionCount: 3,
          leaveConfirm: '图片还在上传哦，中途离开了图片不会保存下来的，确定要离开？',
          pasteImage: true,
        }
      });
    });
  </script>
@stop
