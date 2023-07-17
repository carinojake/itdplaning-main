
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laravel File Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
</head>
<body>
<div class="container">
    <h1 class="page-header text-center">Laravel 9 Multiple File Upload | File Storage</h1>
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">Upload Form</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('upload.file') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="text" name="project_id" ><br><br>
                        <input type="text" name="task_id" ><br><br>
                        <input type="text" name="contract_id" ><br><br>
                        <input type="file" name="file[]" multiple><br><br>




                        <button type="submit" class="btn btn-primary">Upload</button>

                </div>
            </div>
            <div style="margin-top:20px;">

        </div>

        <div class="input-group control-group increment" >
            <input type="file" name="file[]" class="form-control" >
            <div class="input-group-btn">
              <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
            </div>
          </div>
          <div class="clone hide d-none">
            <div class="control-group input-group" style="margin-top:10px">
              <input type="file" name="file[]" class="form-control" >
              <div class="input-group-btn">
                <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
              </div>
            </div>
          </div>
          <div style="margin-top:20px;">
            @if(count($errors) > 0)
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger text-center">
                        {{$error}}
                    </div>
                @endforeach
            @endif

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{session('success')}}
                </div>
            @endif
            </div>
        </div>




          <button type="submit" class="btn btn-primary" style="margin-top:10px">Submit</button>


    </form>
        <div class="col-8">
            <h2>Files Table</h2>
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Photo</th>
                        <th>File Name</th>
                        <th>File project_id</th>
                        <th>File task_id</th>
                        <th>File contract_id</th>
                        <th>File Size</th>
                        <th>Date Uploaded</th>
                        <th>File Location</th>
                    </thead>
                    <tbody>
                        @if(count($files) > 0)
                            @foreach($files as $file)
                                <tr>
                                    <td><img src='storage/{{$file->name}}' name="{{$file->name}}" style="width:90px;height:90px;"></td>
                                    <td>{{ $file->name }}</td>
                                    <td>{{ $file->project_id }}</td>
                                    <td>{{ $file->task_id }}</td>
                                    <td>{{ $file->contract_id }}</td>


                                    <td>
                                        @if($file->size < 1000)
                                            {{ number_format($file->size,2) }} bytes
                                        @elseif($file->size >= 1000000)
                                            {{ number_format($file->size/1000000,2) }} mb
                                        @else
                                            {{ number_format($file->size/1000,2) }} kb
                                        @endif
                                    </td>
                                    <td>{{ date('M d, Y h:i A', strtotime($file->created_at)) }}</td>
                                    <td><a href="{{ $file->location }}">{{ $file->location }}</a></td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No Table Data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
        </div>
    </div>
</div>
</body>
</html>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> --}}

<script type="text/javascript">


    $(document).ready(function() {

      $(".btn-success").click(function(){
          var html = $(".clone").html();
          $(".increment").after(html);
      });

      $("body").on("click",".btn-danger",function(){
          $(this).parents(".control-group").remove();
      });

    });

</script>

