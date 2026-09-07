<style>
    .sidebarLeftcol a.active {
        background-color: #0040E6;
        color: #fff;
    }
</style>
<div class="myaccount-tab-list nav sidebarLeftcol">
    <a href="{{ route('front.myaccount') }}" class="{{ Route::is('front.myaccount') ? 'active' : '' }}">Dashboard <i
            class="far fa-home"></i></a>
    <a href="{{ route('front.myleads') }}"
        class="{{ Route::is('front.myleads') || Route::is('front.mylead_detail') ? 'active' : '' }}">My Quotes <i
            class="far fa-file-alt"></i></a>
    <a href="{{ route('front.myorder') }}"
        class="{{ Route::is('front.myorder') || Route::is('order-detail') || Route::is('reschedule') || Route::is('cancelpackage') ? 'active' : '' }}">My
        Orders <i class="far fa-file-alt"></i></a>
    <a href="{{ route('front.myprofile') }}" class="{{ Route::is('front.myprofile') ? 'active' : '' }}">My Profile <i
            class="far fa-user"></i></a>
    <a href="{{ route('front.mywallet') }}" class="{{ Route::is('front.mywallet') ? 'active' : '' }}">Wallet <i
            class="far fa-wallet"></i></a>
    <a href="{{ route('front.refer_earn') }}" class="{{ Route::is('front.refer_earn') ? 'active' : '' }}">Refer And
        Earn <i class="fa-regular fa-gift"></i></a>
    <a href="{{ route('front.refral') }}" class="{{ Route::is('front.refral') ? 'active' : '' }}">Referral List<i
            class="fa-regular fa-gift"></i></a>
    <a href="{{ route('user_signout') }}" class="{{ Route::is('front.user_signout') ? 'active' : '' }}">Logout <i
            class="far fa-sign-out-alt"></i></a>
</div>
