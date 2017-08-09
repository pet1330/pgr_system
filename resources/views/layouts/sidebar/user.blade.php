<div class="user-panel">
    <div class="pull-left image">
        <img src="{{ $user->avitar ?? asset('imgs/usericon.jpg') }}" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <a href="#">
            <i class="fa fa-circle text-success"></i> {{ Auth::user()->user_type }}</a>
    </div>
</div>
