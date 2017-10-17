<nav class="nav">

    <a href="/dashboard" class="logo">Nerd Running</a>

    <a href="/myactivities" class="nav__link">My activities</a>
    <a href="" class="nav__link">item 2</a>
    <a href="" class="nav__link">item 3</a>
    <a href="" class="nav__link">item 4</a>

    <a href="/profile" class="my-profile-link">

        <p>{{$authUser->firstname . " " . $authUser->lastname}}</p>

        <img src="{{$authUser->avatar}}" alt="" class="my-profile-link__image">

    </a>

</nav>