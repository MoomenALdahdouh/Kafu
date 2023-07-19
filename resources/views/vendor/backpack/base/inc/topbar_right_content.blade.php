@php
    //$unreadNotificationsCount = auth("backpack")->user()->unreadNotifications->count();
    //$notifications = auth("backpack")->user()->notifications;
    $unreadNotificationsCount = \App\Models\Notification::query()->where('sender_type',1)->where('status',0)->count();
    $notifications = \App\Models\Notification::query()->where('sender_type',1)->latest()->get();
@endphp
    <!-- Add this to the head section of your Blade template -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<ul class="nav navbar-nav mr-auto">
    <li class="nav-item dropdown notifications-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            @if ($unreadNotificationsCount > 0)
                <span class="badge badge-warning">{{ $unreadNotificationsCount }}</span>
            @endif
        </a>
        <ul class="dropdown-menu dropdown-menu-right" style="width: 300px;">
            <li class="dropdown-header">You have {{ $unreadNotificationsCount }} notifications</li>
            <li>
                <ul class="menu list-unstyled">
                    @foreach ($notifications as $notification)
                        <li class="card alert-info p-1 m-1 ">
                            <a href="{{ backpack_url('job/'.$notification->model_id.'/show') }}">
                                <strong>{{ $notification->title }}</strong>
                                <p>{{ $notification->message }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </li>
</ul>

