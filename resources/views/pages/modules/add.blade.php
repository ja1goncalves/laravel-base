@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Module Page')

@section('vendor-style')
        {{-- Page Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection

@section('page-style')
        {{-- Page Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('css/plugins/forms/validation/form-validation.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">

@endsection

@section('content')
<!-- modules edit start -->
<section class="modules-edit">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
            <!-- modules edit media object ends -->
            <!-- modules edit account form start -->
            <form novalidate action="{{ url("/modules/add/") }}" enctype="multipart/form-data" method="POST">
              @csrf
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <div class="controls">
                      <label>Nome</label>
                      <input name="name" id="name" type="text" class="form-control" placeholder="Name" value="" required
                        data-validation-required-message="This name field is required">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Rota</label>
                      <input name="route" id="route" type="text" class="form-control" placeholder="Rota" value=""
                        required data-validation-required-message="This route field is required">
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status">
                      <option value="1">Ativo</option>
                      <option value="0">Inativo</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Ícone</label>
                      <input name="icon" id="icon" type="text" class="form-control" placeholder="Ícone" value=""
                             data-validation-required-message="This icon field is required">
                    </div>
                  </div>
                </div>
                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                  <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Salvar</button>
                </div>
              </div>
            </form>
            <!-- modules edit account form ends -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- modules edit ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-module.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
@endsection

