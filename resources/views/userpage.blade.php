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
     <main class="" id="app-main">
            <div class="container-fluid">
                <!-- First row -->
                <div class="row">
                    @if( !Auth::check() ||  (Auth::check() && $user->provider_id != Auth::user()->provider_id) )
                    <div class="col-md-3 mb-1">
                        <div class="card contact-card with-padding">
                            <div class="card-body text-center text-overflow-ellipsis">
                                <div class="mt-1 mb-1">
                                    <img src="{{ $user->avatar }}" alt="" class="img-fluid rounded-circle contact-avatar mx-auto"/>
                                </div>
                                <h3 class="h3-responsive">{{$user->first_name}} {{$user->last_name}}</h3>
                                <p class="text-center grey-text">{{$user->bio}}</p>
                                <ul class="striped">
                                    <li class="text-overflow-ellipsis"> {{$user->g_username}}</li>
                                    <li class="text-overflow-ellipsis"> <a href="mailto:{{$user->email}}"> {{$user->email}} </a></li>
                                    {{-- @if( $user->mobile_number != "")  --}}
                                    {{-- <li><strong>Mobile number:</strong> {{$user->mobile_number}}</li> --}}
                                    {{-- @endif --}}
                                    @if( $user->website != "") 
                                    <li><strong>Website:</strong> {{$user->website}}</li>
                                    @endif
                                    <li><strong>Total Blogs:</strong> {{$postcount}}</li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                    @else
                    <div class="col-md-12">
                    @endif
                        <div class="row">
                            <div class="col-md-12 mb-1">

                                <!--Card-->
                                <div class="card card-cascade narrower">
                                    <div class="admin-panel info-admin-panel">

                                        <!--Card content-->
                                        <div class="card-block">

                                            <div class="list-group">
                                                <div class="col-lg-12 pad-lr-30"
                                                    v-if="logsCollection.length <= 0" v-cloak>
                                                    <div class="alert blue-text text-center" >Can not find any logs here.</div>
                                                </div>   

                                              <div class="list-group-item list-group-item-action flex-column align-items-start" v-cloak
                                                v-for="(p, index) in logsCollection">
                                                  
                                                <div class="d-flex w-100 justify-content-between">
                                                    <a :href="getUrl(p)">
                                                        <h4 class="mb-1 blue-text"> @{{ p.p_title }} </h4>
                                                    </a>
                                                  <small class="blue-grey-text">
                                                   @if (Auth::check() && $user->provider_id == Auth::user()->provider_id  )
                                                    <div class="btn-group">
                                                        <a class="btn btn-floating orange med-btn-fonts" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-chevron-circle-down"></i> </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" :href="'/log/edit/'+p.p_id">Edit</a>
                                                            <a class="dropdown-item" v-on:click="deletePost(p.p_id, index)">Delete</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item grey-text" href="">Rights</a>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                <p class="mb-1">@{{ p.p_short_dec }}</p>
                                                <i class="fa fa-clock-o" area-hidden="true"></i> @{{ p.updated_at }}</small>
                                              </div>

                                            </div>
                                            
                                        </div>
                                        <!--/.Card content-->
                                    </div>
                                </div>
                                <!--/.Card-->
                            </div>
                        </div>
                    </div>
                    <!-- /.First column -->
                   
                </div>
                <!-- /.First row -->
            </div>
        </main>
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
    <script type="text/javascript">

        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        var RootScope = new Vue({
            el: "#app-main",
            data : {
                logsCollection : [],
                dataloading : false,
                gusermail : document.location.pathname.replace( /\//g,""),
            },
            methods:{
              getUrl: function (p) {
                    return "/"+this.gusermail+"/"+p.p_id+"/"+p.uri;
                },
                deletePost: function( p_id, index ){
                    // console.log(p_id);
                    if( confirm("Are you sure to delete that post? ") ) {
                        var self = this;
                        axios.post('/api/log/delete', {
                            p_id: p_id,
                            }).then( function (response) {
                            toastr.error(p_id + " Deleted");
                            self.logsCollection.splice(index,1);
                        });
                    }
                }
            },
            mounted:function () {
                var self = this;
                axios.post('/api/logs/'+this.gusermail,{ }).then(function( response ){
                    self.logsCollection = response.data.collection;
                })
            }   

        })
    </script>
</body>

</html>