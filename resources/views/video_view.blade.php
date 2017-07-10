<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    @include('includes.head')
</head>

    <body class="@if(Auth::check()) fixed-sn @else hidden-sn @endif white-skin">
        
     <header>
        @include('includes.sidebar')
        @include('includes.navbar')
        
    </header>

    <!--Main layout-->
    <main class="">
        <div class="container-fluid text-center">
            <div class="row">
                @foreach ($videos as $v)
                <div class="col-4-md">
                    <iframe src="https://www.youtube.com/embed/{{$v->youtube_id}}?ecver=2" width="480" height="270" frameborder="0" style="width:100%;left:0" allowfullscreen></iframe>
                </div>
                @endforeach
            </div>
        </div>
    </main>
    <!--/Main layout-->

    <form>
    
</form>

    <div class="fx-action-btn">
        <a href="{{ route('createLog') }}" data-toggle="tooltip" data-placement="left" title="Add new log" class="btn-floating btn-large red">
            <i class="fa fa-pencil"></i>
        </a>
    </div>
    @include('includes.footerscripts')
</body>

</html>