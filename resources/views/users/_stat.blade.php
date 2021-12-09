<div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
  <div class="card ">
    <img class="card-img-top" src="{{ $user->avatar }}" alt="{{ $user->name }}">
    <div class="card-body">
        <h5><strong>个人简介</strong></h5>
        <p>{{ $user->introduction ?? '(这个人很懒，没有写简介~)' }}</p>
        <hr>
        <h5><strong>注册于</strong></h5>
        <p>{{ $user->created_at->diffForHumans() }}</p>
        <hr>
        <h5><strong>最后活跃</strong></h5>
        <p title="{{  $user->last_actived_at }}">{{ $user->last_actived_at->diffForHumans() }}</p>
        <hr>
        @include('users._sms_info')
    </div>
  </div>
</div>
