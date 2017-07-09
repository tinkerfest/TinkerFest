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
        <form action="{{ route('postProfile', ['gusermail' => $meta['gusermail']] ) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div class="container-fluid">
                <!-- Section: Edit Account -->
                <section class="section">
                    <!-- First row -->
                    <div class="row">
                        <!-- First column -->
                        <div class="col-lg-4">

                            <!-- Card -->
                            <div class="card contact-card card-cascade narrower mb-r">
                                <div class="admin-panel info-admin-panel">
                                    <!-- Card title -->
                                    <div class="view primary-color">
                                        <h5>Edit Photo</h5>
                                    </div>
                                    <!-- /.Card title -->

                                    <!-- Card content -->
                                    <div class="card-block text-center">
                                        <img src="{{ $meta['avatar']}}" alt="User Photo" class="rounded-circle contact-avatar my-2 mx-auto" /></br>
                                        <h3>{{ $meta['firstName']}} {{ $meta['lastName']}}</h3>
                                        <h5>{{ $meta['gusermail']}}</h5>
                                        {{-- <button class="btn btn-primary">Upload New Photo</button> --}}
                                    </div>
                                    <!-- /.Card content -->
                                </div>
                            </div>
                            <!-- /.Card -->

                        </div>
                        <!-- /.First column -->
                        <!-- Second column -->
                        <div class="col-lg-8">
                            <!--Card-->
                            <div class="card card-cascade narrower mb-r">
                                <div class="admin-panel info-admin-panel">
                                    <!--Card image-->
                                    <div class="view primary-color">
                                        <h5>Edit Account</h5>
                                    </div>
                                    <!--/Card image-->
                                    <!--Card content-->
                                    <div class="card-block">
                                        <!-- Edit Form -->
                                        <form>
                                            <!--First row-->
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <input type="email" id="email" name="email" class="form-control" value="{{ $meta['email']}}">
                                                        <label for="email">Email address</label>
                                                    </div>
                                                </div>
                                                <!--Second column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <input type="text" id="gusermail" name="gusermail" class="form-control" value="{{ $meta['gusermail']}}">
                                                        <label for="gusermail">Username</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--First row-->
                                            <!--First row-->
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <input type="text" id="firstName" name="firstName" class="form-control" value="{{ $meta['firstName']}}">
                                                        <label for="firstName">First Name</label>
                                                    </div>
                                                </div>
                                                <!--Second column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <input type="text" id="lastName" name="lastName" class="form-control" value="{{ $meta['lastName']}}">
                                                        <label for="lastName">Last Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/.First row-->
                                            <!--Second row-->
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <input type="number" id="mobileNumber" name="mobileNumber" class="form-control" value="{{ $meta['mobileNumber']}}">
                                                        <label for="mobileNumber">Mobile Number</label>
                                                    </div>
                                                </div>
                                                <!--Second column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <input type="text" id="website" name="website" class="form-control" value="{{ $meta['website']}}">
                                                        <label for="website">Website Address</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/.Second row-->
                                            <!--Third row-->
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-12">
                                                    <div class="md-form">
                                                        <textarea type="text" id="bio" name="bio" class="md-textarea">{{ $meta['bio']}}</textarea>
                                                        <label for="bio">About me</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/.Third row-->
                                            <!--Fourth row-->
                                            <div class="row">
                                                <!--First column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        @if ( $meta['gender'] == 'male')
                                                            <div class="form-group">
                                                                <input name="gender" type="radio" id="male" value="male" checked>
                                                                <label for="male">Male</label>
                                                            </div>

                                                            <div class="form-group">
                                                                <input name="gender" type="radio" value="female" id="female">
                                                                <label for="female">Female</label>
                                                            </div>

                                                            <div class="form-group">
                                                                <input name="gender" type="radio" value="other" id="other">
                                                                <label for="other">Other</label>
                                                            </div>
                                                        @elseif ( $meta['gender'] == 'female')
                                                            <div class="form-group">
                                                                <input name="gender" type="radio" id="male">
                                                                <label for="male">Male</label>
                                                            </div>

                                                            <div class="form-group">
                                                                <input name="gender" type="radio" value="female" id="female" checked>
                                                                <label for="female">Female</label>
                                                            </div>

                                                            <div class="form-group">
                                                                <input name="gender" type="radio" value="other" id="other">
                                                                <label for="other">Other</label>
                                                            </div>
                                                        @elseif ( $meta['gender'] == 'other')
                                                            <div class="form-group">
                                                                <input name="gender" type="radio" id="male">
                                                                <label for="male">Male</label>
                                                            </div>

                                                            <div class="form-group">
                                                                <input name="gender" type="radio" value="female" id="female">
                                                                <label for="female">Female</label>
                                                            </div>

                                                            <div class="form-group">
                                                                <input name="gender" type="radio" value="other" id="other" checked>
                                                                <label for="other">Other</label>
                                                            </div>
                                                        @else
                                                            <div class="form-group">
                                                                <input name="gender" type="radio" value="male" id="male">
                                                                <label for="male">Male</label>
                                                            </div>

                                                            <div class="form-group">
                                                                <input name="gender" type="radio" value="female" id="female">
                                                                <label for="female">Female</label>
                                                            </div>

                                                            <div class="form-group">
                                                                <input name="gender" type="radio" value="other" id="other">
                                                                <label for="other">Other</label>
                                                            </div>
                                                        @endif
                                                        <label for="gender" class="active">Gender</label>
                                                    </div>
                                                </div>
                                                <!--Second column-->
                                                <div class="col-md-6">
                                                    <div class="md-form">
                                                        <input type="date" id="birthday" name="birthday" class="form-control" value="{{ $meta['birthday']}}">
                                                        <label for="birthday" class="active">Birth Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/.Fourth row-->
                                            <!-- Fifth row -->
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <input type="submit" value="Update Account" class="btn btn-primary">
                                                </div>
                                            </div>
                                            <!-- /.Fifth row -->
                                        </form>
                                        <!-- Edit Form -->
                                    </div>
                                    <!--/.Card content-->
                                </div>
                            </div>
                            <!--/.Card-->
                        </div>
                        <!-- /.Second column -->
                    </div>
                    <!-- /.First row -->
                </section>
                <!-- /.Section: Edit Account -->
            </div>
        </form>
    </main>
    <!--/Main layout-->

    <div class="fx-action-btn">
        <a href="{{ route('createLog') }}" data-toggle="tooltip" data-placement="left" title="Add new log" class="btn-floating btn-large red">
            <i class="fa fa-pencil"></i>
        </a>
    </div>
    @include('includes.footerscripts')
</body>

</html>