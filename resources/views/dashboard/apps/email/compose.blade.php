@extends('dashboard.base')

@section('css')
   
@endsection

@section('content')

<div class="container-fluid">
            <div class="card c-email-app">
              <div class="card-body">
                <form>
                  <div class="form-row mb-3">
                    <label class="col-2 col-sm-1 col-form-label" for="to">To:</label>
                    <div class="col-10 col-sm-11">
                      <input class="form-control" id="to" type="email" placeholder="Type email">
                    </div>
                  </div>
                  <div class="form-row mb-3">
                    <label class="col-2 col-sm-1 col-form-label" for="cc">CC:</label>
                    <div class="col-10 col-sm-11">
                      <input class="form-control" id="cc" type="email" placeholder="Type email">
                    </div>
                  </div>
                  <div class="form-row mb-3">
                    <label class="col-2 col-sm-1 col-form-label" for="bcc">BCC:</label>
                    <div class="col-10 col-sm-11">
                      <input class="form-control" id="bcc" type="email" placeholder="Type email">
                    </div>
                  </div>
                </form>
                <div class="row">
                  <div class="col-sm-11 mfs-auto">
                    <div class="toolbar" role="toolbar">
                      <div class="btn-group">
                        <button class="btn btn-light" type="button">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-bold') }}"></use>
                          </svg>
                        </button>
                        <button class="btn btn-light" type="button">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-italic') }}"></use>
                          </svg>
                        </button>
                        <button class="btn btn-light" type="button">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-underline') }}"></use>
                          </svg>
                        </button>
                      </div>
                      <div class="btn-group">
                        <button class="btn btn-light" type="button">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-align-left') }}"></use>
                          </svg>
                        </button>
                        <button class="btn btn-light" type="button">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-align-right') }}"></use>
                          </svg>
                        </button>
                        <button class="btn btn-light" type="button">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-align-center') }}"></use>
                          </svg>
                        </button>
                        <button class="btn btn-light" type="button">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-justify-center') }}"></use>
                          </svg>
                        </button>
                      </div>
                      <div class="btn-group">
                        <button class="btn btn-light" type="button">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-indent-increase') }}"></use>
                          </svg>
                        </button>
                        <button class="btn btn-light" type="button">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-indent-decrease') }}"></use>
                          </svg>
                        </button>
                      </div>
                      <div class="btn-group">
                        <button class="btn btn-light" type="button">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-list') }}"></use>
                          </svg>
                        </button>
                        <button class="btn btn-light" type="button">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-list-numbered') }}"></use>
                          </svg>
                        </button>
                      </div>
                      <button class="btn btn-light" type="button">
                        <svg class="c-icon">
                          <use xlink:href="{{ url('/icons/sprites/free.svg#cil-trash') }}"></use>
                        </svg>
                      </button>
                      <button class="btn btn-light" type="button">
                        <svg class="c-icon">
                          <use xlink:href="{{ url('/icons/sprites/free.svg#cil-paperclip') }}"></use>
                        </svg>
                      </button>
                      <div class="btn-group">
                        <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown">
                          <svg class="c-icon">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-tags') }}"></use>
                          </svg><span class="caret"></span>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">add label
                            <span class="badge badge-danger"> Home</span>
                          </a>
                          <a class="dropdown-item" href="#">add label
                            <span class="badge badge-info"> Job</span>
                          </a>
                          <a class="dropdown-item" href="#">add label
                            <span class="badge badge-success"> Clients</span>
                          </a>
                          <a class="dropdown-item" href="#">add label
                            <span class="badge badge-warning"> News</span>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div class="form-group mt-4">
                      <textarea class="form-control" id="message" name="body" rows="12" placeholder="Click here to reply"></textarea>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-success" type="submit">Send</button>
                      <button class="btn btn-light" type="submit">Draft</button>
                      <button class="btn btn-danger" type="submit">Discard</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

@endsection

@section('javascript')

@endsection