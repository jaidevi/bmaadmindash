<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button  class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>

                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                            aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            {{-- <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended"
                        placeholder="{{ __('Search') }}" aria-label="Search">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <span class="fa fa-search"></span>
                </div>
            </div>
        </div>
        </form> --}}
        <!-- Navigation -->
        <ul class="navbar-nav" id="navbar-nav">
            <h6 class="navbar-heading text-muted" style="padding: 0rem 1.5rem;">Navigation</h6>
            @can('dashboard')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-tachometer-alt text-primary"></i> {{ __('Dashboard') }}
                </a>
            </li>
            @endcan

            @can('role_access')
            <li class="nav-item">
                <a class="nav-link" href="{{route('roles.index')}}">
                    <i class="fas fa-id-badge text-blue"></i> {{ __('Role') }}
                </a>
            </li>
            @endcan
            @can('user_access')

            <li class="nav-item">
                <a class="nav-link" href="{{route('users.index')}}">
                    <i class="fas fa-user text-blue"></i> {{ __('User') }}
                </a>
            </li>
            @endcan
            {{-- 'fueltype' => 'FuelTypeController',
            'subfueltype' => 'SubFuelTypeController', --}}
            @can('fuelType_access')
            <li class="nav-item">
                <a class="nav-link" href="{{route('fueltype.index')}}">
                    <i class="fas fa-gas-pump text-blue"></i> {{ __('Drinking Water') }}
                </a>
            </li>
            @endcan
            @can('subfueltype_access')
            <li class="nav-item">
                <a class="nav-link" href="{{route('subfueltype.index')}}">
                    <i class="fas fa-tint text-blue"></i> {{ __('Sub Type') }}
                </a>
            </li>
            @endcan
            @can('vehicleBrand_access')
            <li class="nav-item">
                <a class="nav-link" href="{{route('vehicleBrand.index')}}">
                    <i class="fas fa-bullseye text-blue"></i> {{ __('Vehicle Brand') }}
                </a>
            </li>
            @endcan
            @can('vehicleModel_access')
            <li class="nav-item">
                <a class="nav-link" href="{{route('vehicleModel.index')}}">
                    <i class="fas fa-car-side text-blue"></i> {{ __('Vehicle Model') }}
                </a>
            </li>
            @endcan
            <li class="nav-item">
                <a class="nav-link" href="{{route('booking')}}">
                    <i class="fas fa-stream text-blue"></i> {{ __('Booking') }}
                </a>
            </li>
            





            @can('appuser_access')
            <li class="nav-item">
                {{-- appuser.index --}}
                <a class="nav-link" href="{{route('appuser.index')}}">
                    <i class="fas fa-user-friends text-blue"></i> {{ __('Customer') }}
                </a>
            </li>
            @endcan
            <li class="nav-item">
                {{-- appuser.index --}}
                <a class="nav-link" href="{{route('provider.index')}}">
                    <i class="fas fa-truck-monster text-blue"></i> {{ __('Water Provider') }}
                </a>
            </li>
            {{-- @canany(['booking_access','branch_booking_access'])
            <li class="nav-item">
                <a class="nav-link" href="{{ route('booking.index') }}">
            <i class="fas fa-cut text-blue"></i> {{ __('Booking') }}
            </a>
            </li>
            @endcan --}}
            
            @can('earning_access')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('earning.index') }}">
            <i class="fas fa-dollar-sign text-blue"></i> {{ __('Earning') }}
            </a>
            </li>
            @endcan
            {{-- @can('report_access')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('report.index') }}">
            <i class="far fa-file-word text-blue"></i> {{ __('Report') }}
            </a>
            </li>
            @endcan --}}
    
            

            <li class="nav-item" onclick="scrolldown()" >
                <a class="nav-link" href="#navbar-maps" data-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="navbar-maps">
                    <i class="ni ni-map-big text-primary"></i>
                    <span class="nav-link-text">Other</span>
                </a>
                <div class="collapse " id="navbar-maps" style="">
                    <ul class="nav nav-sm flex-column">
                        @can('notification_access')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('notification.index') }}">
                                <i class="fas fa-bell text-blue"></i> {{ __('Notification') }}
                            </a>
                        </li>
                        @endcan
                       
                       @can('custom_notification_access')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('custom.index') }}">
                                    <i class="fas fa-concierge-bell text-blue"></i> {{ __('Custom Notification') }}
                                </a>
                            </li>
                            @endcan
                            @can('setting_access')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('setting.index') }}">
                                    <i class="fas fa-cog text-blue"></i> {{ __('Setting') }}
                                </a>
                            </li>
                            @endcan
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('review') }}">
                                    <i class="fas fa-star-half-alt text-blue"></i> {{ __('Review') }}
                                </a>
                            </li>
                            @can('privacy_access')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pp') }}">
                                    <i class="far fa-handshake text-blue"></i> {{ __('Privacy and Policy') }}
                                </a>
                            </li>
                            @endcan
                            @can('loadingText_access')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('loadingtext.index') }}">
                                    <i class="fas fa-spinner text-blue fa-spin mr-4" style="min-width:0"></i> {{ __('Loader Text') }}
                                </a>
                            </li>
                            @endcan
                    </ul>
                </div>
            </li>
            {{-- @can('faq_access')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('faq.index') }}">
            <i class="fas fa-question text-blue"></i> {{ __('FAQ') }}
            </a>
            </li>
            @endcan --}}
            {{-- @canany(['review_access','branch_review_access'])
            <li class="nav-item">
                <a class="nav-link" href="{{ route('review.index') }}">
            <i class="far fa-smile-beam text-blue"></i> {{ __('Review') }}
            </a>
            </li>
            @endcan --}}


        </ul>

        <hr class="my-3">
    </div>
    </div>
</nav>