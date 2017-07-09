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
        <div class="container">
                <div class="card">
                    <h3 class="card-header default-color-dark white-text text-center">Documents</h3>
                    <div class="card-block">
                        <table class="table">
                            <tbody>
                                @foreach($documents as $doc)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    @if ( $doc->thumbnail_url == "pptx" || $doc->thumbnail_url == "ppt" || $doc->thumbnail_url == "odp" )
                                        <td><i class="fa fa-file-powerpoint-o fa-2x orange-text" ></i></td>
                                        <td class="filename">{{ $doc->document_name }}</td>
                                        <td>
                                            <a href="{{ route( 'documentView', ['gusermail' => $meta['gusermail'], 'googledrive_id' => $doc->googledrive_id] ) }}" target="_blank">
                                                View
                                            </a>
                                        </td>
                                    @else
                                        @if ( $doc->thumbnail_url == "pdf" )
                                            <td><i class="fa fa-file-pdf-o fa-2x red-text" ></i></td>
                                        @elseif ( $doc->thumbnail_url == "xlsx" || $doc->thumbnail_url == "xls" || $doc->thumbnail_url == "ods" )
                                            <td><i class="fa fa-file-excel-o fa-2x green-text"></i></td>
                                        @elseif ( $doc->thumbnail_url == "docx" || $doc->thumbnail_url == "doc" || $doc->thumbnail_url == "odf" )
                                            <td><i class="fa fa-file-word-o fa-2x blue-text"></i></td>
                                        @else
                                            <td><i class="fa fa-file fa-2x"></i></td>
                                        @endif
                                        <td class="filename">{{ $doc->document_name }}</td>
                                        <td>
                                            <a href="{{ route( 'documentDownload', ['gusermail' => $meta['gusermail'], 'document_id' => $doc->document_id] ) }}">
                                                Download
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>   
                    </div>
                </div>
        </div>
    </main>
    <div class="fx-action-btn">
        <a href="{{ route('createLog') }}" data-toggle="tooltip" data-placement="left" title="Add new log" class="btn-floating btn-large red">
            <i class="fa fa-pencil"></i>
        </a>
    </div>
    @include('includes.footerscripts')
</body>

</html>