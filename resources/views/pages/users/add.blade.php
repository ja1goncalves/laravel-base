@extends('layouts/contentLayoutMaster')

@section('title', 'Edit User Page')

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
<!-- users edit start -->
<section class="users-edit">
  <div class="card">
    <div class="card-content">
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
            <!-- users edit media object ends -->
            <!-- users edit account form start -->
            <form novalidate action="{{ url("/users/add/") }}" enctype="multipart/form-data" method="POST">
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
                      <label>E-mail</label>
                      <input name="email" id="email" type="email" class="form-control" placeholder="E-mail" value=""
                        required data-validation-required-message="This email field is required">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>Senha</label>
                      <input name="password" id="password" type="password" class="form-control" placeholder="Senha" value=""
                             data-validation-required-message="This password field is required">
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status">
                      @foreach($status as $key => $option):
                      <option value="{{$key}}">{{ $option }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" name="role" id="role">
                      @foreach($roles as $key => $role):
                      <option value="{{$key}}">{{ $role }}</option>
                      @endforeach
                    </select>
                  </div>
                    <div class="form-group">
                      <div class="controls">
                        <label>Confimar senha</label>
                        <input name="password_confirmation" id="password_confirmation" type="password" class="form-control" placeholder="Confirmação de Senha"
                               value="" data-validation-required-message="This password field is required">
                      </div>
                    </div>
                </div>
                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                  <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Salvar</button>
                </div>
              </div>
            </form>
            <!-- users edit account form ends -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- users edit ends -->
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
  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
@endsection

