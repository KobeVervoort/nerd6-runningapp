<nav class="nav">

    <a href="" class="logo">Nerd Running</a>

    <a href="" class="nav__link">item 1</a>
    <a href="" class="nav__link">item 2</a>
    <a href="" class="nav__link">item 3</a>
    <a href="" class="nav__link">item 4</a>

    <a href="" class="my-profile-link">

        <p>{{Auth::User()->firstname}}</p>
        <p>{{Auth::User()->lastname}}</p>

        <img src="{{Auth::User()->avatar}}" alt="" class="my-profile-link__image">

    </a>

</nav>