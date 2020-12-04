@extends('layouts/contentLayoutMaster')

@section('title', 'Check List Page')

@section('vendor-style')
        {{-- Page Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-grid.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/ag-grid/ag-theme-material.css')) }}">
@endsection

@section('page-style')
        {{-- Page Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/pages/aggrid.css')) }}">
@endsection

@section('content')
<!-- modules list start -->
<section class="modules-list-wrapper">
  <!-- Ag Grid modules list section start -->
  <div id="basic-examples">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="ag-grid-btns d-flex justify-content-between flex-wrap mb-1">
                <div class="dropdown sort-dropdown mb-1 mb-sm-0">
                  <button class="btn btn-white filter-btn dropdown-toggle border text-dark" type="button"
                    id="dropdownMenuButton6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    1 - 20 of 50
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton6">
                    <a class="dropdown-item" href="#">20</a>
                    <a class="dropdown-item" href="#">50</a>
                  </div>
                </div>
                <div class="ag-btns d-flex flex-wrap">
                  <input type="text" class="ag-grid-filter form-control w-100 mb-1 mb-sm-0" id="filter-text-box"
                    placeholder="Pesquisar...." />
                </div>
              </div>
            </div>
          </div>
          @foreach($checks['data'] as $check)
          <div class="modal text-left" id="popup{{$check['id']}}" role="dialog" aria-labelledby="cal-modal" aria-modal="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title text-text-bold-600" id="cal-modal">Events</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                  <!-- modules edit account form start -->
                  <form novalidate action="{{ url("checks/init") }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-12 row">
                        <div class="form-group col-5 ml-1">
                          <div class="controls">
                            <label>Entrada</label>
                            <input name="start-fake" id="start-fake" type="text" value="{{$check['start']}}" disabled class="form-control" placeholder="Entrada">
                          </div>
                        </div>
                        <div class="form-group col-5">
                          <div class="controls">
                            <label>Saída</label>
                            <input name="end" id="end" type="text" class="form-control" placeholder="Saída" value="{{$check['end']}}" disabled>
                          </div>
                        </div>
                        <div class="col-1 justify-content-end mt-2">
                          <button type="submit" class="btn btn-warning outline mb-1 mb-sm-0 mr-0 mr-sm-1" disabled><i class="fa fa-check-circle"></i></button>
                        </div>
                      </div>
                    </div>
                  </form>
                  <!-- modules edit account form ends -->
              </div>
              </div>
            </div>
          </div>
          @endforeach
          <div id="myGrid" class="aggrid ag-theme-material"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- Ag Grid modules list section end -->
</section>
<!-- modules list ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/tables/ag-grid/ag-grid-community.min.noStyle.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-checks.js')) }}"></script>
@endsection
