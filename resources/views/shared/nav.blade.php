<nav class="nav">

    <!--<a href="/dashboard" class="logo">Nerd Running</a>

    <a href="/myactivities" class="nav__link">My activities</a>-->

    <a href="/dashboard" class="nav__link {{Request::is('dashboard') ? 'nav__link--active' : ''}} nav__link--left">dashboard</a>
    <a href="/myactivities" class="nav__link {{Request::is('myactivities') ? 'nav__link--active' : ''}} nav__link--right">my progress</a>

    <a href="" class="my-profile-link">

        <p class="my-profile-link__name">{{$authUser->firstname}}</p>

        <img src="{{$authUser->avatar}}" alt="" class="my-profile-link__image">

    </a>

</nav>