@extends('layouts/contentLayoutMaster')

@section('title', 'Checks')

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
          @if(!is_null($checks['uncompleted']) && !empty($checks['uncompleted']))
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
            <!-- modules edit account form start -->
            <form novalidate action="{{ url("/checks/end/".$checks['uncompleted']['id']) }}" enctype="multipart/form-data" method="POST">
              @csrf
              <div class="row">
                <div class="col-12 row">
                  <div class="form-group col-5">
                    <div class="controls">
                      <label>Entrada</label>
                      <input name="start" id="start" type="text" class="form-control" placeholder="Entrada" value="{{$checks['uncompleted']['start'] }}"
                             required disabled>
                    </div>
                  </div>
                  <div class="form-group col-5">
                    <div class="controls">
                      <label>Saída</label>
                      <input name="end" id="end" type="text" value="1" required hidden class="form-control" placeholder="Saída" >
                      <input name="end" id="end" type="text" value="{{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}"
                             required disabled class="form-control" placeholder="Saída" >
                    </div>
                  </div>
                  <div class="col-2 justify-content-end mt-2">
                    <button type="submit" class="btn btn-danger glow mb-1 mb-sm-0 mr-0 mr-sm-1">Finalizar</button>
                  </div>
                </div>
              </div>
            </form>
            <!-- modules edit account form ends -->
          </div>
          @else
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
            <!-- modules edit account form start -->
            <form novalidate action="{{ url("checks/init") }}" enctype="multipart/form-data" method="POST">
              @csrf
              <div class="row">
                <div class="col-12 row">
                  <div class="form-group col-5">
                    <div class="controls">
                      <label>Entrada</label>
                      <input name="start" id="start" type="text" class="form-control" placeholder="Entrada" value="1" required hidden>
                      <input name="start-fake" id="start-fake" type="text" value="{{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}"
                             disabled class="form-control" placeholder="Entrada">
                    </div>
                  </div>
                  <div class="form-group col-5">
                    <div class="controls">
                      <label>Saída</label>
                      <input name="end" id="end" type="text" class="form-control" placeholder="Saída" value="" disabled>
                    </div>
                  </div>
                  <div class="col-2 justify-content-end mt-2">
                    <button type="submit" class="btn btn-success glow mb-1 mb-sm-0 mr-0 mr-sm-1">Iniciar</button>
                  </div>
                </div>
              </div>
            </form>
            <!-- modules edit account form ends -->
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="divider"><div class="divider-text">Antigos</div></div>
  @foreach($checks['completed'] as $completed)
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
            <div class="row">
              <div class="col-12 row">
                <div class="form-group col-5">
                  <div class="controls">
                    <label>Entrada</label>
                    <input name="start" id="start" type="text" class="form-control" placeholder="Entrada" value="{{$completed['start']}}" disabled>
                  </div>
                </div>
                <div class="form-group col-5">
                  <div class="controls">
                    <label>Saída</label>
                    <input name="end" id="end" type="text" class="form-control" placeholder="Saída" value="{{$completed['end']}}" disabled>
                  </div>
                </div>
                <div class="col-2 justify-content-end mt-2">
                  <button type="submit" disabled class="btn btn-outline-warning glow mb-1 mb-sm-0 mr-0 mr-sm-1">Finalizado</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach
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
{{--  <script src="{{ asset(mix('js/scripts/pages/app-module.js')) }}"></script>--}}
  <script src="{{ asset(mix('js/scripts/navs/navs.js')) }}"></script>
@endsection

