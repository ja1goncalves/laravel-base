@extends('layouts/contentLayoutMaster')

@section('title', 'App Calender')

@section('vendor-style')
        <!-- Vendor css files -->
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/calendars/fullcalendar.min.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/calendars/extensions/daygrid.min.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/calendars/extensions/timegrid.min.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection
@section('page-style')
        <!-- Page css files -->
        <link rel="stylesheet" href="{{ asset(mix('css/plugins/calendars/fullcalendar.css')) }}">
@endsection
@section('content')
<!-- Full calendar start -->
<section id="basic-examples">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <div class="cal-category-bullets d-none">
              <div class="bullets-group-1 mt-2">
                <div class="category-business mr-1">
                  <span class="bullet bullet-success bullet-sm mr-25"></span>
                  Business
                </div>
                <div class="category-work mr-1">
                  <span class="bullet bullet-warning bullet-sm mr-25"></span>
                  Work
                </div>
                <div class="category-personal mr-1">
                  <span class="bullet bullet-danger bullet-sm mr-25"></span>
                  Personal
                </div>
                <div class="category-others">
                  <span class="bullet bullet-primary bullet-sm mr-25"></span>
                  Others
                </div>
              </div>
            </div>
            <div id='fc-default'></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- calendar Modal starts-->
  <div class="modal fade text-left modal-calendar" tabindex="-1" role="dialog" aria-labelledby="cal-modal" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-text-bold-600" id="cal-modal">Events</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="#">
          <div class="modal-body"></div>
        </form>
      </div>
    </div>
  </div>
  <!-- calendar Modal ends-->
</section>
<!-- // Full calendar end -->
@endsection

@section('vendor-script')
  <!-- Vendor js files -->
  <script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/calendar/fullcalendar.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/calendar/extensions/daygrid.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/calendar/extensions/timegrid.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/calendar/extensions/interactions.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
@endsection
@section('page-script')
        <!-- Page js files -->
        <script src="{{ asset(mix('js/scripts/extensions/fullcalendar.js')) }}"></script>
@endsection

