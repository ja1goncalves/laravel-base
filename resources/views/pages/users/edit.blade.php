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
                      <input name="password" id="password" type="password" class="form-control" placeholder="Senha" value="">
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
                               value="">
                      </div>
                    </div>
                  @endif
                </div>
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive">
                        <h6 class="border-bottom py-1 mx-1 mb-0 font-medium-2"><i class="feather icon-lock mr-50 "></i>Permissões
                        </h6>
                        <table class="table table-borderless">
                          <thead>
                          <tr>
                            <th></th>
                            <th>Módulo</th>
                            <th>Início</th>
                            <th>Visualização</th>
                            <th>Edição</th>
                            <th>Criação</th>
                            <th>Remoção</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($user['modules'] as $module)
                            <tr>
                              <td>
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" id="{{ $module['user_module']['id'] }}" {{ Auth::user()->role == 'admin' ? '' : 'disabled' }}
                                         class="custom-control-input permission-module" {{ $module['user_module']['auth'] ? 'checked' : '' }}
                                         onchange="permissionModule({{$module['user_module']['id']}})">
                                  <label class="custom-control-label" for="{{ $module['user_module']['id'] }}"></label>
                                </div>
                              </td>
                              <td>{{ $module['name'] }}</td>
                              @foreach($module['user_module']['actions'] as $action)
                                <td>
                                  <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="{{ $action['id'] }}" {{ Auth::user()->role == 'admin' ? '' : 'disabled' }}
                                           class="custom-control-input permission" {{ $action['auth'] ? 'checked' : '' }}
                                           onchange="permissionAction({{ $action['id'] }})">
                                    <label class="custom-control-label" for="{{ $action['id'] }}"></label>
                                  </div>
                                </td>
                              @endforeach
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
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

