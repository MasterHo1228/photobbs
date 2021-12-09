<a href="{{ route('users.show',$user->id) }}?tab=followings">
  <strong id="following" class="user-stats">
    {{ count($user->followings) }}
  </strong>
  关注
</a>
<a href="{{ route('users.show',$user->id) }}?tab=followers">
  <strong id="followers" class="user-stats">
    {{ count($user->followers) }}
  </strong>
  粉丝
</a>
<a href="{{ route('users.show',$user->id) }}">
  <strong id="topics" class="user-stats">
    {{ $user->topics()->count() }}
  </strong>
  文章
</a>
<hr>
<p>
  @include('users._follow_form')
</p>
