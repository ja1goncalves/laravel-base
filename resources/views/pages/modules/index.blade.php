@extends('layouts/contentLayoutMaster')

@section('title', 'Module List Page')

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
                  <input type="text" class="ag-grid-filter form-control w-50 mr-1 mb-1 mb-sm-0" id="filter-text-box"
                    placeholder="Pesquisar...." />
                  <div class="action-btns">
                    <div class="btn-dropdown ">
                      <div class="btn-group dropdown actions-dropodown">
                        <a type="button" class="btn btn-white px-2 py-75 waves-effect waves-light"
                          aria-haspopup="true" aria-expanded="false" href="/modules/add">
                          Adicionar módulo
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
  <script src="{{ asset(mix('js/scripts/pages/app-module.js')) }}"></script>
@endsection
