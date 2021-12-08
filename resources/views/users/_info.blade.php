{{-- 用户发布的内容 --}}
<div class="card ">
  <div class="card-body">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link bg-transparent {{ active_class(if_query('tab', null)) }}" href="{{ route('users.show', $user->id) }}">
          Ta 的话题
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'replies')) }}" href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">
          Ta 的回复
        </a>
      </li>
    </ul>
    @if (if_query('tab', 'replies'))
      @include('users._replies', ['replies' => $user->replies()->with('topic')->recent()->paginate(5)])
    @else
      @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
    @endif
  </div>
</div>
