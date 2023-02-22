@extends('dashboard.base')

@section('css')
   
@endsection

@section('content')

<div class="container-fluid">
            <div class="card c-email-app">
              <div class="card-body">
                <div class="toolbar mb-4">
                  <div class="btn-group">
                    <button class="btn btn-light" type="button">
                      <svg class="c-icon">
                        <use xlink:href="{{ url('/icons/sprites/free.svg#cil-envelope-closed') }}"></use>
                      </svg>
                    </button>
                    <button class="btn btn-light" type="button">
                      <svg class="c-icon">
                        <use xlink:href="{{ url('/icons/sprites/free.svg#cil-star') }}"></use>
                      </svg>
                    </button>
                    <button class="btn btn-light" type="button">
                      <svg class="c-icon">
                        <use xlink:href="{{ url('/icons/sprites/free.svg#cil-bookmark') }}"></use>
                      </svg>
                    </button>
                  </div>
                  <div class="btn-group">
                    <button class="btn btn-light" type="button">
                      <svg class="c-icon">
                        <use xlink:href="{{ url('/icons/sprites/free.svg#cil-share') }}"></use>
                      </svg>
                    </button>
                    <button class="btn btn-light" type="button">
                      <svg class="c-icon">
                        <use xlink:href="{{ url('/icons/sprites/free.svg#cil-share-all') }}"></use>
                      </svg>
                    </button>
                    <button class="btn btn-light" type="button">
                      <svg class="c-icon">
                        <use xlink:href="{{ url('/icons/sprites/free.svg#cil-share-boxed') }}"></use>
                      </svg>
                    </button>
                  </div>
                  <button class="btn btn-light" type="button">
                    <svg class="c-icon">
                      <use xlink:href="{{ url('/icons/sprites/free.svg#cil-trash') }}"></use>
                    </svg>
                  </button>
                  <div class="btn-group">
                    <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown">
                      <svg class="c-icon">
                        <use xlink:href="{{ url('/icons/sprites/free.svg#cil-tags') }}"></use>
                      </svg><span class="caret"></span>
                    </button>
                    <div class="dropdown-menu"><a class="dropdown-item" href="#">add label<span class="badge badge-danger"> Home</span></a><a class="dropdown-item" href="#">add label<span class="badge badge-info"> Job</span></a><a class="dropdown-item" href="#">add label<span class="badge badge-success"> Clients</span></a><a class="dropdown-item" href="#">add label<span class="badge badge-warning"> News</span></a></div>
                  </div>
                  <div class="btn-group float-right">
                    <button class="btn btn-light" type="button">
                      <svg class="c-icon">
                        <use xlink:href="{{ url('/icons/sprites/free.svg#cil-chevron-left') }}"></use>
                      </svg>
                    </button>
                    <button class="btn btn-light" type="button">
                      <svg class="c-icon">
                        <use xlink:href="{{ url('/icons/sprites/free.svg#cil-chevron-right') }}"></use>
                      </svg>
                    </button>
                  </div>
                </div>
                <div class="c-message">
                  <div class="c-message-details">
                    <div class="c-message-headers">
                      <div class="c-message-headers-subject">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
                      <div class="c-message-headers-from">Lukasz Holeczek<span class="text-muted">(email@email.com)</span></div>
                      <div class="c-message-headers-date">
                        <svg class="c-icon">
                          <use xlink:href="{{ url('/icons/sprites/free.svg#cil-paperclip') }}"></use>
                        </svg> Today, 3:47 PM
                      </div>
                    </div>
                    <hr>
                    <div class="c-message-body">
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                      <blockquote>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</blockquote>
                    </div>
                    <hr>
                    <div class="c-message-attachment"><span class="badge badge-danger mfe-2">zip</span><b>bootstrap.zip</b><i>(2,5MB)</i><span class="mfs-auto"><a class="btn btn-sm btn-link" href="#">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-eye') }}"></use>
                          </svg></a><a class="btn btn-sm btn-link" href="#">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-share') }}"></use>
                          </svg></a><a class="btn btn-sm btn-link" href="#">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-cloud-download') }}"></use>
                          </svg></a></span></div>
                    <div class="c-message-attachment"><span class="badge badge-info mfe-2">txt</span><b>readme.txt</b><i>(7KB)</i><span class="mfs-auto"><a class="btn btn-sm btn-link" href="#">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-eye') }}"></use>
                          </svg></a><a class="btn btn-sm btn-link" href="#">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-share') }}"></use>
                          </svg></a><a class="btn btn-sm btn-link" href="#">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-cloud-download') }}"></use>
                          </svg></a></span></div>
                    <div class="c-message-attachment"><span class="badge badge-success mfe-2">xls</span><b>spreadsheet.xls</b><i>(984KB)</i><span class="mfs-auto"><a class="btn btn-sm btn-link" href="#">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-eye') }}"></use>
                          </svg></a><a class="btn btn-sm btn-link" href="#">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-share') }}"></use>
                          </svg></a><a class="btn btn-sm btn-link" href="#">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-cloud-download') }}"></use>
                          </svg></a></span></div>
                    <form class="mt-3" method="post" action="">
                      <div class="form-group">
                        <textarea class="form-control" id="message" name="body" rows="12" placeholder="Click here to reply"></textarea>
                      </div>
                      <div class="form-group">
                        <button class="btn btn-success" tabindex="3" type="submit">Send message</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

@endsection

@section('javascript')

@endsection