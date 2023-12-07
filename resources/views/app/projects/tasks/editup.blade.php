<x-app-layout>
    <x-slot:content>
        <div class="container-fluid">
            {{--  {{ Breadcrumbs::render('project.task.edit', $project, $task) }} --}}
            <div class="animated fadeIn">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row ">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <x-card title="{{ __('แก้ไขกิจกรรม') }} {{ $task->task_name }}">
                            <form id = 'formId' method="POST"
                                action="{{ route('project.task.filesup', ['project' => $project->hashid, 'task' => $task->hashid]) }}"
                                enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf

                                <!-- Input for File Upload -->
                                <div class="form-group mt-3">
                                    <label for="file" class="form-label">{{ __('เอกสารแนบ') }}</label>
                                    <input type="file" name="file[]" id="file" class="form-control" multiple>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary mt-3">Upload</button>

                                <x-button class="btn-success" type="submit">{{ __('coreuiforms.save') }}</x-button>
                                <x-button onclick="history.back()" class="text-black btn-light">
                                    {{ __('coreuiforms.return') }}</x-button>
                            </form>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:content>
    <x-slot:css>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
            rel="stylesheet" />

    </x-slot:css>
    <x-slot:javascript>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js">
        </script>
        {{--  <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker.js') }}"></script> --}}
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
        <script src="{{ asset('vendors/bootstrap-datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

        <script>
        $(document).ready(function () {
            $('form').on('submit', function (e) {
                // ตรวจสอบว่าไฟล์ถูกเลือกหรือไม่
                if ($('#file').get(0).files.length === 0) {
                    e.preventDefault(); // หยุดการส่งฟอร์ม
                    alert('กรุณาเลือกไฟล์');
                }
            });
        });
        </script>
        <script>
            $(document).ready(function() {
                $(":input").inputmask();
            });
        </script>



        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict'
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                const forms = document.querySelectorAll('.needs-validation')
                // Loop over them and prevent submission
                Array.prototype.slice.call(forms)
                    .forEach(form => {
                        form.addEventListener('submit', event => {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }
                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
        </script>








    </x-slot:javascript>
</x-app-layout>
