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
            <h3>{{ $document['document_name'] }}
                <a href="{{ route( 'documentDownload', ['gusermail' => $meta['gusermail'], 'document_id' => $document['document_id']] ) }}">
                    <i class="fa fa-download pad-lr-10 orange-text"></i>
                </a>
            </h3>
            <hr>
            <iframe src="{{ $document['googledrive_url'] }}" frameborder="0" width="960" height="500" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
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