    @if( Auth::check() )

        <!--/. Sidebar navigation -->

        <ul id="slide-out" class="side-nav fixed sn-bg-1 custom-scrollbar">
            <li>
                <div class="user-box">
                    <img src="{{ $meta['avatar'] }}" class="img-fluid rounded-circle">
                    <p class="user text-center black-text">{{ $meta['firstName'] }} {{$meta['lastName']}}</p>
                </div>
            </li>

            <li>
                <ul class="collapsible collapsible-accordion">
                    <li><a href="{{ route('indexroot') }}" class="waves-effect">Search</a></li>
                    <li><a href="{{ route('createLog') }}" class="waves-effect">Add New Log</a></li>
                    <li><a href="{{ route('gusermail', ['gusermail' => $meta['gusermail']] ) }}" class="waves-effect">My Logs</a></li>
                    <li><a href="{{ route('getProfile', ['gusermail' => $meta['gusermail']] ) }}" class="waves-effect">Edit Account</a></li>
                    <li><a href="{{ route('documents', ['gusermail' => $meta['gusermail']] ) }}" class="waves-effect">Attachments</a></li>
                </ul>
            </li>
            <!--/. Side navigation links -->
            <div class="sidenav-bg mask-strong"></div>
        </ul>
        
        <!--/. Sidebar navigation -->
    @endif