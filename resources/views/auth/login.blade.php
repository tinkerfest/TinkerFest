<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    @include('includes.head')
</head>

    <body class="@if(Auth::check()) fixed-sn @else hidden-sn @endif white-skin">
        

    <!--Main layout-->
    <main class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-lg-5 login-form mx-auto float-none">
                    
                    <!--Form with header-->
                            <h1 class="text-center makerslog-titile">MakersLog</h1>
                        <div class="card text-center">
                            <div class="card-block">
                            Sign up or Login with
                            <a href="/auth/google" type="button" class="btn btn-lg btn-gplus"><i class="fa fa-google left"></i> Google</a>
                    </div>
                    <!--/Form with header-->

                </div>
            </div>
        </div>
     </main>
    <!--/Main layout-->

    @include('includes.footerscripts')
</body>

</html>
