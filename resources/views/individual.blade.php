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
        <div class="container-fluid">
            <div class="container-blog">
            <!--Section heading-->

                <div class="card card-block jumbotron">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 text-right">

                            <a target="_blank" href="/{{ $u->g_username }}" class="media-left waves-light waves-effect waves-light"><img src="{{ $u->avatar }}" alt="image of {{$p->first_name}}" width="80" class="rounded-circle-imp"></a>
                               
                        </div>
                        <div class="col-md-10 col-sm-10">
                            <h3 class="section-heading text-left"> {{ $p->p_title}}</h3>
                            <div class="rating inline-ul">
                                        by <a target="_blank" href="/{{ $u->g_username }}">{{$u->first_name}} {{$u->last_name}}</a>
                                        <p class="time_right blue-grey-text">
                                            <i class="fa fa-clock-o"></i>
                                            {{ $p->updated_at->diffForHumans() }}
                                        </p>
                            </div>
                        </div>
                        <div class="container-blog">
                            <hr>
                                <p class="section-description text-left blue-grey-text">
                                    {{$p->p_short_dec}}
                                </p>
                            <hr>

                            <p class="text-left">
                                {!! $p->p_content !!}
                            </p>
                            @if(count($doc) > 0)
                            <hr>
                            <h4>Attachments</h4>
                            <table class="table">
                                <tbody>
                                    @foreach($doc as $d)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td class="filename">{{ $d->document_name }}</td>
                                        @if ( $d->thumbnail_url == "pptx" )
                                            <td>
                                                <a href="{{ route( 'documentView', ['gusermail' =>  $u->g_username, 'googledrive_id' => $d->googledrive_id] ) }}" target="_blank">
                                                    View
                                                </a>
                                            </td>
                                        @else
                                            <td>
                                                <a href="{{ route( 'documentDownload', ['gusermail' => $u->g_username, 'document_id' => $d->document_id] ) }}">
                                                    Download
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif                         
                        </div>
                    </div>

                </div>
            </div>
        </div>
</main>
    

<footer class="page-footer blue center-on-small-only">

    <!--Footer Links-->
    <div class="container-fluid">
        <div class="row">

            <!--First column-->
            <div class="col-md-8">
                <h5 class="title">Tags</h5>
                <p><?php
                    if( strlen($p->categories) > 1 ){
                        $ar = explode(",",$p->categories);
                        $l = count( $ar );
                        for($i = 0; $i < $l - 1 ; $i++) {
                            $val = $ar[$i];
                            echo "<a target='_blank' class='btn btn-outline-secondary light-blue lighten-4 waves-effect' href='/?cat=".$val."'>".$val."</a>";

                        }
                    }
                ?></p>
            </div>
            <!--/.First column-->

            <!--Second column-->
            <div class="col-md-4">
                <h5 class="title">Links</h5>
                <ul>
                    <li><a href="/{{$u->g_username}}">More from {{ $u->first_name }} </a></li>
                    <li><a href="/">MakersLog Home </a></li>
                </ul>
            </div>
            <!--/.Second column-->
        </div>
    </div>
    <!--/.Footer Links-->

    <!--Copyright-->
    <div class="footer-copyright">
        <div class="container-fluid">
            © 2017 Team MakersLog
        </div>
    </div>
    <!--/.Copyright-->

</footer>
    <!--/Main layout-->
    @if( Auth::check() )
    <div class="fx-action-btn">
        <a href="{{ route('createLog') }}" data-toggle="tooltip" data-placement="left" title="Add new log" class="btn-floating btn-large red">
            <i class="fa fa-pencil"></i>
        </a>
    </div> 
    @endif
    <div id="gotoTop" class="fx-action-btn hideOnMobile" style="right: 95px;">
        <a data-toggle="tooltip" data-placement="left" title="Goto top" class="btn-floating btn-med green">
            <i class="fa fa-chevron-up fa-1 med-btn-fonts" ></i>
        </a>
    </div>
    
    @include('includes.footerscripts')
</body>

</html>
