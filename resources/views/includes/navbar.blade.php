  <!-- Navbar -->
        <nav class="navbar fixed-top navbar-toggleable-md navbar-dark scrolling-navbar double-nav">

            <!-- SideNav slide-out button -->
            <div class="float-left">
                @if( Auth::check() )

                <a href="/" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
                @endif
            </div>

            <!-- Breadcrumb-->
            <ol class="breadcrumb hidden-lg-down">
                <li class="breadcrumb-item active"><a href="/">Makers Log</a></li>
                <li class="breadcrumb-item active">{{ $meta['pageName']}}</li>
            </ol>

            <!--Navbar links-->
            <ul class="nav navbar-nav nav-flex-icons ml-auto">

                @if( Auth::check() )
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="/" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="hidden-sm-down">Ouick Access</span>
                        </a>
                        <div class="dropdown-menu dropdown-ins dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="/{{ $meta['gusermail']}}">My Logs</a>
                            <a class="dropdown-item" href="{{ route('contributors') }}">Contributors</a>
                            <a class="dropdown-item" href="/feedback/reportbug">Report Bug</a>
                            <a type="submit" class="dropdown-item" href="{{ route('logout') }}">Log Out</a>
                        </div>
                    </li>

                @else
                    <li class="nav-item" style="display: inline-flex;">
                        <a class="nav-link" href="{{ route('contributors') }}">Contributors</a>
                        <a class="nav-link" href="/login">Login / Sign up</a>
                    </li>
                @endif


            </ul>
            <!--/Navbar links-->

        </nav>
        <!-- /.Navbar -->
