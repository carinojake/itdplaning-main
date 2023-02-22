@extends('dashboard.base')

@section('css')
   
@endsection

@section('content')

          <div class="container-fluid">
            <div class="c-fade-in">
              <div class="card">
                <div class="card-header">Google Maps<a class="badge badge-danger" href="https://coreui.io/pro/">CoreUI Pro Component</a>
                  <div class="card-header-actions"><a class="card-header-action" href="https://google-developers.appspot.com/maps/documentation/javascript/reference" target="_blank"><small class="text-muted">docs</small></a></div>
                </div>
                <div class="card-body">
                  <div id="map" style="height:360px;"></div>
                </div>
              </div>
            </div>
          </div>

@endsection

@section('javascript')
    <script src="https://maps.googleapis.com/maps/api/js?callback=InitMap&amp;key=AIzaSyASyYRBZmULmrmw_P9kgr7_266OhFNinPA"></script>
    <script src="{{ asset('js/google-maps.js') }}"></script>
@endsection
