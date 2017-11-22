<nav class="nav">

    <div class="nav-top">
        <img src="/img/logo.png" alt="" class="logo-small">

        <a href="" class="my-profile-link my-profile-link--blue">

            <img src="{{$authUser->avatar}}" alt="" class="my-profile-link__image">

        </a>
    </div>

    <div class="nav-bottom">
        <a href="/myProgress" class="nav__link nav__link--blue {{Request::is('myProgress') ? 'nav__link--active-blue' : ''}}">My Progress</a>
        <a href="/group" class="nav__link nav__link--blue {{Request::is('group') ? 'nav__link--active-blue' : ''}} ">Group</a>
        <a href="/achievements" class="nav__link nav__link--blue {{Request::is('achievements') ? 'nav__link--active-blue' : ''}}">Achievements</a>
    </div>

    <div class="nav-bottom__underline nav-bottom__underline--blue"></div>

</nav>