<x-layout bodyClass="">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <x-navbars.navs.guest signup='register' signin='login'></x-navbars.navs.guest>
            </div>
        </div>
    </div>
    <div class="page-header justify-content-center min-vh-100"
        style="background-image: url('
        background: linear-gradient(to right, rgba(0, 0, 0, 1) 30%, rgba(0,0,0,0) 100%), url('{{ asset('assets') }}/img/bg-login.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <h1 class="text-light text-center">Welcome to KDW: Management Tools</h1>
        </div>
    </div>
        <x-footers.guest></x-footers.guest>
</x-layout>
