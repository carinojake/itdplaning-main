@if(count($files_project) > 0)
<table class="table table-bordered table-striped">
    <thead>
       {{--  <th>Photo</th> --}}
        <th>File Name</th>
      {{--   <th>File project_id</th>
        <th>File task_id</th>
        <th>File contract_id</th> --}}
        <th>File Size</th>
        <th>Date Uploaded</th>
        <th>File Location</th>
       {{--  <th>File Location</th> --}}
    </thead>
    <tbody>
        @if(count($files_project) > 0)
            @foreach($files_project as $file)
                <tr>
                   {{--  <td><img src='storage/{{$file->name}}' name="{{$file->name}}" style="width:90px;height:90px;"></td> --}}
                    <td>{{ $file->name }}</td>
           {{--          <td>{{ $file->project_id }}</td>
                    <td>{{ $file->task_id }}</td>
                    <td>{{ $file->contract_id }}</td> --}}


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


                    <td><a href="{{ asset('storage/uploads/contracts/' . $file->project_id . '/0/' . $file->name) }}">{{ $file->name }}</a></td>

                   {{--  <td><a href="{{ $file->location }}">{{ $file->location }}</a></td> --}}



                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="12" class="text-center">No Table Data</td>
            </tr>
        @endif
    </tbody>
</table>
@endif
