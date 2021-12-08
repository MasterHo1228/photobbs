@if (count($users))
  <ul class="list-unstyled">
    @foreach ($users as $user)
      <li class="media follower-list">
        <div class="media-left">
          <a href="{{ route('users.show', [$user->id]) }}">
            <img class="media-object img-thumbnail mr-3" style="width: 52px; height: 52px;" src="{{ $user->avatar }}" title="{{ $user->nickname }}">
          </a>
        </div>

        <div class="media-body">
          <a class="media-heading" href="{{ route('users.show', [$user->id]) }}" title="{{ $user->nickname }}">
              {{ $user->nickname }}
          </a>
        </div>
      </li>

      @if ( ! $loop->last)
        <hr>
      @endif

    @endforeach
  </ul>

@else
  <div class="empty-block">暂无数据 ~_~ </div>
@endif

{{-- 分页 --}}
<div class="mt-4 pt-1">
  {!! $users->appends(Request::except('page'))->render() !!}
</div>
