@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/cropper.css') }}" rel="stylesheet">
@endsection

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>{{ __('coreuiforms.media.media') }}</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div style="float:left;">
                            @if($parentFolder !== 'disable')
                                <a class="btn btn-primary mt-2" href="{{ route('media.folder.index', [ 'id' => $parentFolder ]) }}">
                                    <i class="cil-level-up"></i>
                                    {{ __('coreuiforms.media.back') }}
                                </a>
                            @endif
                            <a class="btn btn-primary mt-2" href="{{ route('media.folder.add', [ 'thisFolder' => $thisFolder ]) }}">
                                <i class="cil-plus"></i> 
                                <i class="cil-folder"></i>
                                {{ __('coreuiforms.media.new_folder') }}
                            </a>
                        </div>
                        <div style="float:left;">
                            <form method="POST" action="{{ route('media.file.add') }}" enctype="multipart/form-data" id="file-file-form">
                                @csrf
                                <input type="hidden" name="thisFolder" value="{{ $thisFolder }}" id="this-folder-id"/> 
                                <label class="btn btn-primary mt-2 ml-1">
                                    <i class="cil-plus"></i>
                                    <i class="cil-file"></i>
                                    {{ __('coreuiforms.media.new_file') }} <input type="file" name="file" id="file-file-input" hidden>
                                </label> 
                                
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <table class="table table-striped table-bordered datatable">
                            <tbody>
                                @foreach($mediaFolders as $mediaFolder)
                                    <tr>
                                        <td>
                                            <a href="{{ route('media.folder.index', [ 'id' => $mediaFolder->id ]) }}">
                                                <i class="cil-folder"></i> 
                                                {{ $mediaFolder->name }}
                                            </a>
                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-primary file-change-folder-name"
                                                atr="{{ $mediaFolder->id }}"
                                            >
                                                {{ __('coreuiforms.media.rename') }}
                                            </button>
                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            <button 
                                                class="btn btn-primary file-move-folder"
                                                atr="{{ $mediaFolder->id }}"
                                            >
                                                {{ __('coreuiforms.media.move') }}
                                            </button>
                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            <button 
                                                class="btn btn-danger file-delete-folder"
                                                atr="{{ $mediaFolder->id }}"
                                            >
                                                {{ __('coreuiforms.media.delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach($medias as $media)
                                    <tr>
                                        <td class="click-file" atr="{{ $media->id }}">
                                            <i class="cil-file"></i> 
                                            {{ $media->name }}
                                        </td>
                                        <td>
                                            <a 
                                                href="<?php echo $media->getUrl(); ?>"
                                                class="btn btn-primary"
                                            >
                                                {{ __('coreuiforms.media.open') }}
                                            </a>
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-primary file-change-file-name"
                                                atr="{{ $media->id }}"
                                            >
                                                {{ __('coreuiforms.media.rename') }}
                                            </button>
                                        </td>
                                        <td>
                                            <a 
                                                href="{{ route('media.file.copy', ['id' => $media->id, 'thisFolder' => $thisFolder]) }}"
                                                class="btn btn-primary"
                                            >   
                                                {{ __('coreuiforms.media.copy') }}
                                            </a>
                                        </td>
                                        <td>
                                            <button 
                                                class="btn btn-primary file-move-file"
                                                atr="{{ $media->id }}"
                                            >
                                                {{ __('coreuiforms.media.move') }}
                                            </button>
                                        </td>
                                        <td>
                                            <?php 
                                                $mime = explode('/', $media->mime_type);
                                                if($mime[0] === 'image'){
                                            ?>
                                                <button 
                                                    class="btn btn-success file-cropp-file"
                                                    atr="{{ $media->id }}"
                                                >
                                                    {{ __('coreuiforms.media.cropp') }}
                                                </button>
                                            <?php 
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <button 
                                                class="btn btn-danger file-delete-file"
                                                atr="{{ $media->id }}"
                                            >
                                                {{ __('coreuiforms.media.delete') }}
                                            </button>

                                            <!--
                                            <a 
                                                class="btn btn-danger" 
                                                href="{{ route('media.file.delete', ['id' => $media->id, 'thisFolder' => $thisFolder]) }}"
                                            >
                                                Delete
                                            </a>
                                            -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-4">

                    <div class="card border-primary" id="file-move-folder">
                            <div class="card-header">
                                <h4>{{ __('coreuiforms.media.move_folder') }}</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('media.folder.move') }}">
                                    @csrf
                                    <input type="hidden" name="thisFolder" value="{{ $thisFolder }}">
                                    <input type="hidden" name="id" value="" id="file-move-folder-id">
                                    <table class="table table-striped table-bordered">
                                        @if($parentFolder !== 'disable')
                                            <tr>
                                                <td>
                                                    <input type="radio" name="folder" value="moveUp">
                                                </td>
                                                <td>
                                                    {{ __('coreuiforms.media.move_up') }}
                                                </td>
                                            </tr>
                                        @endif
                                        @foreach($mediaFolders as $mediaFolder)
                                            <tr>
                                                <td>
                                                    <input 
                                                        type="radio" 
                                                        name="folder" 
                                                        value="{{ $mediaFolder->id }}"
                                                        class="file-move-folder-radio"
                                                    >
                                                </td>
                                                <td>
                                                    {{ $mediaFolder->name }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <button type="submit" class="btn btn-primary mt-3">{{ __('coreuiforms.save') }}</button>
                                    <button type="button" class="btn btn-primary mt-3" id="file-move-folder-cancel">{{ __('coreuiforms.cancel') }}</button>
                                </form>
                            </div>
                        </div>

                        <div class="card border-primary" id="file-move-file">
                            <div class="card-header">
                                <h4>{{ __('coreuiforms.media.move_file') }}</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('media.file.move') }}">
                                    @csrf
                                    <input type="hidden" name="thisFolder" value="{{ $thisFolder }}">
                                    <input type="hidden" name="id" value="" id="file-move-file-id">
                                    <table class="table table-striped table-bordered">
                                        @if($parentFolder !== 'disable')
                                            <tr>
                                                <td>
                                                    <input type="radio" name="folder" value="moveUp">
                                                </td>
                                                <td>
                                                    {{ __('coreuiforms.media.move_up') }}
                                                </td>
                                            </tr>
                                        @endif
                                        @foreach($mediaFolders as $mediaFolder)
                                            <tr>
                                                <td>
                                                    <input type="radio" name="folder" value="{{ $mediaFolder->id }}">
                                                </td>
                                                <td>
                                                    {{ $mediaFolder->name }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <button type="submit" class="btn btn-primary mt-3">{{ __('coreuiforms.save') }}</button>
                                    <button type="button" class="btn btn-primary mt-3" id="file-move-file-cancel">{{ __('coreuiforms.cancel') }}</button>
                                </form>
                            </div>
                        </div>

                        <div class="card border-primary" id="file-rename-file-card">
                            <div class="card-header">
                                <h4>{{ __('coreuiforms.media.rename_file') }}</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('media.file.update') }}">
                                    @csrf
                                    <input type="hidden" name="thisFolder" value="{{ $thisFolder }}">
                                    <input type="hidden" name="id" value="" id="file-rename-file-id">
                                    <input 
                                        type="text" 
                                        name="name" 
                                        id="file-rename-file-name"
                                        class="form-control"
                                    >
                                    <button type="submit" class="btn btn-primary mt-3">{{ __('coreuiforms.save') }}</button>
                                    <button type="button" class="btn btn-primary mt-3" id="file-rename-file-cancel">{{ __('coreuiforms.cancel') }}</button>
                                </form>
                            </div>
                        </div>
                        <div class="card border-primary" id="file-rename-folder-card">
                            <div class="card-header">
                                <h4>{{ __('coreuiforms.media.rename_folder') }}</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('media.folder.update') }}">
                                    @csrf
                                    <input type="hidden" name="thisFolder" value="{{ $thisFolder }}">
                                    <input type="hidden" name="id" value="" id="file-rename-folder-id">
                                    <input 
                                        type="text" 
                                        name="name" 
                                        id="file-rename-folder-name"
                                        class="form-control"
                                    >
                                    <button type="submit" class="btn btn-primary mt-3">{{ __('coreuiforms.save') }}</button>
                                    <button type="button" class="btn btn-primary mt-3" id="file-rename-folder-cancel">{{ __('coreuiforms.cancel') }}</button>
                                </form>
                            </div>
                        </div>

                        <div class="card border-primary" id="file-info-card">
                            <div class="card-header">
                                <h4>{{ __('coreuiforms.media.file_info') }}</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td>
                                            {{ __('coreuiforms.media.name') }}
                                        </td>
                                        <td id="file-div-name">
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('coreuiforms.media.real_name') }}
                                        </td>
                                        <td id="file-div-real-name">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('coreuiforms.media.url') }}
                                        </td>
                                        <td id="file-div-url">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('coreuiforms.media.mime_type') }}
                                        </td>
                                        <td id="file-div-mime-type">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('coreuiforms.media.size') }}
                                        </td>
                                        <td id="file-div-size">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('coreuiforms.media.created_at') }}
                                        </td>
                                        <td id="file-div-created-at">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{ __('coreuiforms.media.updated_at') }}
                                        </td>
                                        <td id="file-div-updated-at">

                                        </td>
                                    </tr>
                                </table> 
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="remove-file-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{ __('coreuiforms.media.delete_file') }}</h4>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <p>{{ __('coreuiforms.media.are_you_sure') }}</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('media.file.delete') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="thisFolder" value="{{ $thisFolder }}">
                                        <input type="hidden" name="id" value="" id="file-delete-file-id">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('coreuiforms.cancel') }}</button>
                                        <button class="btn btn-primary" type="submit">{{ __('coreuiforms.delete') }}</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content-->
                        </div>
                        <!-- /.modal-dialog-->
                    </div>

                    <div class="modal fade" id="remove-folder-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{ __('coreuiforms.media.delete_folder') }}</h4>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <p>{{ __('coreuiforms.media.delete_folder_warn') }}</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('media.folder.delete') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="thisFolder" value="{{ $thisFolder }}">
                                        <input type="hidden" name="id" value="" id="file-delete-folder-id">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('coreuiforms.cancel') }}</button>
                                        <button class="btn btn-primary" type="submit">{{ __('coreuiforms.delete') }}</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content-->
                        </div>
                        <!-- /.modal-dialog-->
                    </div>

                    <div class="modal fade" id="cropp-img-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">{{ __('coreuiforms.media.cropp_image') }}</h4>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    
                                    <img src="" id="cropp-img-img" />


                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('coreuiforms.cancel') }}</button>
                                    <button class="btn btn-primary" type="button" id="cropp-img-save-button">{{ __('coreuiforms.save') }}</button>
                                </div>
                            </div>
                            <!-- /.modal-content-->
                        </div>
                        <!-- /.modal-dialog-->
                    </div>


                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<style>
    #cropp-img-img{
        max-width:500px;
        max-height:500px;
    }

</style>

@endsection

@section('javascript')
<script src="{{ asset('js/axios.min.js') }}"></script> 
<script src="{{ asset('js/cropper.js') }}"></script>
<script src="{{ asset('js/media.js') }}"></script> 
<script src="{{ asset('js/media-cropp.js') }}"></script>

@endsection