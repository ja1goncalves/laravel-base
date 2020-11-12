<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-left mb-0">@yield('title')</h2>
                <div class="breadcrumb-wrapper col-12">
                    @if(@isset($breadcrumbs))
                    <ol class="breadcrumb">
                        {{-- this will load breadcrumbs dynamically from controller --}}
                        @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item">
                            @if(isset($breadcrumb['link']))
                            <a href="{{ $breadcrumb['link'] }}">
                                @endif
                                {{$breadcrumb['name']}}
                                @if(isset($breadcrumb['link']))
                            </a>
                            @endif
                        </li>
                        @endforeach
                    </ol>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
        <div class="form-group breadcrum-right">
            <div class="dropdown">
                <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                        class="feather icon-user"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="page-user-profile"><i class="feather icon-user"></i> Edit Profile</a>
                  <a class="dropdown-item customizer-toggle" href="javascript:void(0)"><i class="feather icon-settings fa fa-spin fa-fw white"></i> Costumizer</a>
                  <a class="dropdown-item text-danger" ref="{{ route('logout') }}"
                     onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();"><i class="feather icon-power"></i> Logout</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
