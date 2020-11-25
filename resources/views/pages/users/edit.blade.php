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
            <!-- users edit media object start -->
            <div class="media mb-2">
              <a class="mr-2 my-25" href="#">
                <img src="{{ asset('images/portrait/small/avatar-s-12.jpg') }}" alt="users avatar"
                  class="users-avatar-shadow rounded" height="64" width="64">
              </a>
              <div class="media-body mt-50">
                <h4 class="media-heading">{{ $user['name'] }}</h4>
                <div class="col-12 d-flex mt-1 px-0">
                  <a href="#" class="btn btn-primary d-block d-sm-none mr-75"><i
                      class="feather icon-edit-1"></i></a>
                  <a href="#" class="btn btn-outline-danger d-none d-sm-block">Remover</a>
                  <a href="#" class="btn btn-outline-danger d-block d-sm-none"><i class="feather icon-trash-2"></i></a>
                </div>
              </div>
            </div>
            <!-- users edit media object ends -->
            <!-- users edit account form start -->
            <form novalidate action="{{ url("/users/edit/".$user['id']) }}" enctype="multipart/form-data" method="POST">
              @csrf
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <div class="controls">
                      <label>Nome</label>
                      <input name="id" id="id" type="number" class="form-control" placeholder="Name" value="{{ $user['id'] }}" required hidden
                        data-validation-required-message="This name field is required">
                      <input name="name" id="name" type="text" class="form-control" placeholder="Name" value="{{ $user['name'] }}" required
                        data-validation-required-message="This name field is required">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="controls">
                      <label>E-mail</label>
                      <input name="email" id="email" type="email" class="form-control" placeholder="E-mail" value="{{ $user['email'] }}"
                        required data-validation-required-message="This email field is required">
                    </div>
                  </div>
                  @if(Auth::user()->role == 'admin')
                  <div class="form-group">
                    <div class="controls">
                      <label>Senha</label>
                      <input name="password" id="password" type="password" class="form-control" placeholder="Senha" value=""
                             data-validation-required-message="This password field is required">
                    </div>
                  </div>
                  @endif
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status">
                      @foreach($status as $key => $option):
                      <option {{ $user['status'] == $option ? 'selected' : '' }} value="{{$key}}">{{ $option }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" name="role" id="role">
                      @foreach($roles as $key => $role):
                      <option {{ $user['role'] == $role ? 'selected' : ''}}" value="{{$key}}">{{ $role }}</option>
                      @endforeach
                    </select>
                  </div>
                  @if(Auth::user()->role == 'admin')
                    <div class="form-group">
                      <div class="controls">
                        <label>Confimar senha</label>
                        <input name="password_confirmation" id="password_confirmation" type="password" class="form-control" placeholder="Confirmação de Senha"
                               value="" data-validation-required-message="This password field is required">
                      </div>
                    </div>
                  @endif
                </div>
                <div class="col-12">
                  <div class="table-responsive border rounded px-1 ">
                    <h6 class="border-bottom py-1 mx-1 mb-0 font-medium-2"><i
                        class="feather icon-lock mr-50 "></i>Permission</h6>
                    <table class="table table-borderless">
                      <thead>
                        <tr>
                          <th>Module</th>
                          <th>Read</th>
                          <th>Write</th>
                          <th>Create</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Users</td>
                          <td>
                            <div class="custom-control custom-checkbox"><input type="checkbox" id="users-checkbox1"
                                class="custom-control-input" checked>
                              <label class="custom-control-label" for="users-checkbox1"></label>
                            </div>
                          </td>
                          <td>
                            <div class="custom-control custom-checkbox"><input type="checkbox" id="users-checkbox2"
                                class="custom-control-input"><label class="custom-control-label"
                                for="users-checkbox2"></label>
                            </div>
                          </td>
                          <td>
                            <div class="custom-control custom-checkbox"><input type="checkbox" id="users-checkbox3"
                                class="custom-control-input"><label class="custom-control-label"
                                for="users-checkbox3"></label>
                            </div>
                          </td>
                          <td>
                            <div class="custom-control custom-checkbox"><input type="checkbox" id="users-checkbox4"
                                class="custom-control-input" checked>
                              <label class="custom-control-label" for="users-checkbox4"></label>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>Articles</td>
                          <td>
                            <div class="custom-control custom-checkbox"><input type="checkbox" id="users-checkbox5"
                                class="custom-control-input"><label class="custom-control-label"
                                for="users-checkbox5"></label>
                            </div>
                          </td>
                          <td>
                            <div class="custom-control custom-checkbox"><input type="checkbox" id="users-checkbox6"
                                class="custom-control-input" checked>
                              <label class="custom-control-label" for="users-checkbox6"></label>
                            </div>
                          </td>
                          <td>
                            <div class="custom-control custom-checkbox"><input type="checkbox" id="users-checkbox7"
                                class="custom-control-input"><label class="custom-control-label"
                                for="users-checkbox7"></label>
                            </div>
                          </td>
                          <td>
                            <div class="custom-control custom-checkbox"><input type="checkbox" id="users-checkbox8"
                                class="custom-control-input" checked>
                              <label class="custom-control-label" for="users-checkbox8"></label>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>Staff</td>
                          <td>
                            <div class="custom-control custom-checkbox"><input type="checkbox" id="users-checkbox9"
                                class="custom-control-input" checked>
                              <label class="custom-control-label" for="users-checkbox9"></label>
                            </div>
                          </td>
                          <td>
                            <div class="custom-control custom-checkbox"><input type="checkbox" id="users-checkbox10"
                                class="custom-control-input" checked>
                              <label class="custom-control-label" for="users-checkbox10"></label>
                            </div>
                          </td>
                          <td>
                            <div class="custom-control custom-checkbox"><input type="checkbox" id="users-checkbox11"
                                class="custom-control-input"><label class="custom-control-label"
                                for="users-checkbox11"></label>
                            </div>
                          </td>
                          <td>
                            <div class="custom-control custom-checkbox"><input type="checkbox" id="users-checkbox12"
                                class="custom-control-input"><label class="custom-control-label"
                                for="users-checkbox12"></label>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
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

