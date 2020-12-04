@extends('layouts/contentLayoutMaster')

@section('title', 'View User Page')

@section('page-style')
        {{-- Page Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
@endsection

@section('content')
<!-- page users view start -->
<section class="page-users-view">
  <div class="row">
    <!-- account start -->
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Usuário</div>
          <div class="row">
            <div class="col-2 users-view-image">
              <img src="{{ asset('images/portrait/small/avatar-s-12.jpg') }}" class="w-100 rounded mb-2"
                alt="avatar">
              <!-- height="150" width="150" -->
            </div>
            <p hidden type="text" id="user-id">{{$user['id']}}</p>
            <div class="col-sm-4 col-12">
              <table>
                <tr>
                  <td class="font-weight-bold">Nome</td>
                  <td>{{ $user['name'] }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">E-mail</td>
                  <td>{{ $user['email'] }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Criado em</td>
                  <td>{{ $user['created_at'] }}</td>
                </tr>
              </table>
            </div>
            <div class="col-md-6 col-12 ">
              <table class="ml-0 ml-sm-0 ml-lg-0">
                <tr>
                  <td class="font-weight-bold">Status</td>
                  <td>{{ $user['status'] }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Papel</td>
                  <td>{{ $user['role'] }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Horas e Pontos</td>
                  <td>{{ $hours . ' - ' . $points }}</td>
                </tr>
              </table>
            </div>
            <div class="col-12">
              <a href="{{ url('/users/edit/'.$user['id']) }}" class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> Editar</a>
              @if(Auth::user()->role == 'admin')
              <button class="btn btn-outline-danger" id="del-user"><i class="feather icon-trash-2"></i> Deletar</button>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- social links end -->
    <!-- permissions start -->
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <h6 class="border-bottom py-1 mx-1 mb-0 font-medium-2"><i class="feather icon-lock mr-50 "></i>Horários
            </h6>
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th>Dia</th>
                  <th>Início</th>
                  <th>Fim</th>
                  <th>Horas</th>
                  <th>Pontos</th>
                </tr>
              </thead>
              <tbody>
              @foreach($user['checks'] as $key => $check)
                <tr>
                  <td>{{ $key }}</td>
                  <td>{{ $check['start'] }}</td>
                  <td>{{ $check['end'] }}</td>
                  <td>{{ $check['hours'] }}</td>
                  <td>{{ intdiv(strtotime($check['hours']), 720000) }}</td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
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
                      <input type="checkbox" id="{{ 'permission-'.$module['user_module']['id'] }}"
                             class="custom-control-input permission" {{ $module['user_module']['auth'] ? 'checked' : '' }} disabled>
                      <label class="custom-control-label" for="users-checkbox1"></label>
                    </div>
                  </td>
                  <td>{{ $module['name'] }}</td>
                  @foreach($module['user_module']['actions'] as $action)
                  <td>
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" id="{{ 'permission-'.$action['id'] }}"
                        class="custom-control-input permission" {{ $action['auth'] ? 'checked' : '' }} disabled>
                      <label class="custom-control-label" for="users-checkbox1"></label>
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
    <!-- permissions end -->
  </div>
</section>
<!-- page users view end -->
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-user.js')) }}"></script>
@endsection
