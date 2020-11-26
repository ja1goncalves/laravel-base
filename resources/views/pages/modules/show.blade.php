@extends('layouts/contentLayoutMaster')

@section('title', 'View Module Page')

@section('page-style')
        {{-- Page Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('css/pages/app-user.css')) }}">
@endsection

@section('content')
<!-- page modules view start -->
<section class="page-modules-view">
  <div class="row">
    <!-- account start -->
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Usuário</div>
          <div class="row">
            <div class="col-2 modules-view-image">
              <img src="{{ asset('images/portrait/small/avatar-s-12.jpg') }}" class="w-100 rounded mb-2"
                alt="avatar">
              <!-- height="150" width="150" -->
            </div>
            <p hidden type="text" id="module-id">{{$modules['id']}}</p>
            <div class="col-sm-4 col-12">
              <table>
                <tr>
                  <td class="font-weight-bold">Nome</td>
                  <td>{{ $modules['name'] }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Rota</td>
                  <td>{{ $modules['route'] }}</td>
                </tr>
              </table>
            </div>
            <div class="col-md-6 col-12 ">
              <table class="ml-0 ml-sm-0 ml-lg-0">
                <tr>
                  <td class="font-weight-bold">Status</td>
                  <td>{{ $modules['status'] ? 'Ativo' : 'Inativo'}}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Ícone</td>
                  <td>{{ $modules['icon'] }}</td>
                </tr>
              </table>
            </div>
            <div class="col-12">
              <a href="{{ url('/modules/edit/'.$module['id']) }}" class="btn btn-primary mr-1"><i class="feather icon-edit-1"></i> Editar</a>
              @if(Auth::user()->role == 'admin')
              <button class="btn btn-outline-danger" id="del-module"><i class="feather icon-trash-2"></i> Deletar</button>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- social links end -->
  </div>
</section>
<!-- page modules view end -->
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-module.js')) }}"></script>
@endsection
