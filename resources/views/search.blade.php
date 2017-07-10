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
    <!--/.Double navigation-->

    <!--Main layout-->
    <main class="" id="appmain">
        <div class="container-fluid">

            <!--Section heading-->
                
                <h4 class="text-left"></h4>

            <div class="tabs-wrapper"> 
                <ul class="nav classic-tabs indigo tabs-2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link waves-light" id="fellowMakers" data-toggle="tab" href="#panel51" role="tab">
                        <i class="fa fa-coffee pad-lr-10"></i>
                        Fellow Tinkers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link waves-light active" id="recentLogs" data-toggle="tab" href="#panel52" role="tab">
                        <i class="fa fa-list-ul pad-lr-10"></i>
                        Recent Logs</a>
                    </li>
                </ul>
            </div>

            <!-- Tab panels -->
            <div class="tab-content card">

                <!--Panel 1-->
                <div class="tab-pane fade" id="panel51" role="tabpanel">
                    <div class="md-form col-md-8 offset-md-2 ">
                        <input type="search" id="form-autocomplete-f" class="form-control" placeholder="Search Fellow Makers of TT17 " v-model="text" v-on:keyup="typed">
                    </div>

                    <div class="row pad-lr-20">
                            <div class="col-lg-12 pad-lr-30" v-if="users.length <= 0 && !dataloading" v-cloak>
                                <div class="alert blue-text text-center" >Result Not Found</div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 pad-lr-10 pad-tb-10" 
                            v-for="user in users">
                                <div class="card testimonial-card view overlay hm-white-slight" v-cloak>
                                
                                <div class="card-up" :class="getColor(user.g_username,user.first_name,user.last_name)"></div>
                                <a v-bind:href="user.g_username">
                                        <div class="mask waves-effect waves-light"></div>
                                </a>
                                <div class="avatar"><img  width="100" v-bind:src="user.avatar" class="rounded-circle img-responsive">
                                </div>
                                <div class="card-block">
                                    <h4 class="card-title" >@{{user.first_name}} @{{user.last_name}}</h4>
                                    <hr> <a :href="'/'+user.g_username">@{{user.g_username}}</a>
                                </div>
                                 <div class="card-data">
                                    <ul>
                                        <li ><i class="fa fa-bars" ></i> @{{user.post_count}} Logs</li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            <div v-if="dataloading && !end_of_results" class="text-center row col-sm-12"> @include('includes.isloading')</div>

                    </div>

                </div>
                <!--/.Panel 1-->

                <!--Panel 2-->
                <div class="tab-pane fade in show active" id="panel52" role="tabpanel">
                    <div class="md-form col-md-8 offset-md-2 ">
                        <input type="search" id="form-autocomplete-b" class="form-control" placeholder="Search from what Makers think of"  v-model="text" v-on:keyup="typed">
                    </div>
                    <form class="scrollmenu new-scroll">
                            <fieldset class="form-group" v-cloak v-for="(c, index) in categories">
                                <input type="checkbox" class="filled-in" v-on:click="searchOnCheck" v-model="c.checked" v-bind:id="'chk' + index.toString()">
                                <label v-bind:for="'chk' + index.toString()" >@{{ c.c_name }}</label>
                            </fieldset>
                        </form>
                        <br>
                        <br>
                   <div class="row pad-lr-20">
                        <div class="col-lg-12 pad-lr-30" v-if="logsCollection.length <= 0 && !dataloading" v-cloak>
                            <div class="alert blue-text text-center" >Result Not Found</div>
                        </div>
                        <div class="col-md-12 pad-lr-10 pad-tb-10" 
                            v-for="p in logsCollection" v-cloak>
                            <div class="media mb-1">
                                <div class="hideOnMobile">
                                    <a target="_blank" :href="makeUrl(p.g_username)" class="media-left waves-light">
                                        <img class="rounded-circle-imp" v-bind:src="p.avatar" alt="image of @{{p.first_name}}" width="80">
                                    </a>
                                </div>
                                <div class="media-body pad-lr-15">
                                    <a target="_blank" :href="makeUrl(p.g_username,p.p_id,p.uri)">
                                        <h5 class="media-heading">@{{getLimit(p.p_title,100)}}</h5>
                                    </a>
                                        <ul class="rating inline-ul">
                                        by <a target="_blank" :href="makeUrl(p.g_username)">@{{ p.first_name+" "+p.last_name }}</a>
                                    </ul>
                                    <p>@{{getLimit(p.p_short_dec,140)}}</p>
                                    <p class="time_right blue-grey-text">
                                        <i class="fa fa-clock-o"></i>
                                        @{{ p.updated_at }}
                                    </p>
                                </div>
                            </div>
                            <hr />
                        </div>
                        <div v-if="dataloading && !end_of_results" class="text-center row col-sm-12"> @include('includes.isloading')</div>
                    </div>
                <!--/.Panel 2-->
                </div>

            </div>
            <br>

        </div>
        <br><br>
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
    <script type="text/javascript" src='/js/home-app.js'>
    </script>
</body>

</html>