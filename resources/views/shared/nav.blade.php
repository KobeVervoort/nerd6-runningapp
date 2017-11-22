<nav class="nav">

    <div class="nav-top">
        <img src="/img/logo-blue.png" alt="" class="logo-small">

        <a href="" class="my-profile-link">

            <img src="{{$authUser->avatar}}" alt="" class="my-profile-link__image">

        </a>
    </div>

    <div class="nav-bottom">
        <a href="/myProgress" class="nav__link {{Request::is('myProgress') ? 'nav__link--active' : ''}}">My Progress</a>
        <a href="/group" class="nav__link {{Request::is('group') ? 'nav__link--active' : ''}}">Group</a>
        <a href="/achievements" class="nav__link {{Request::is('achievements') ? 'nav__link--active' : ''}}">Achievements</a>
    </div>

    <div class="nav-bottom__underline"></div>

</nav>