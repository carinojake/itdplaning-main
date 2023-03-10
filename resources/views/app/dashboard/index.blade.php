<x-app-layout>
    <x-slot:content>
        <div class="mb-3 row container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="accordion " id="accordionPanelsStayOpenExample">
                                    <div class="accordion-item ">
                                        <h2 class="accordion-header " id="panelsStayOpen-headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                                aria-controls="panelsStayOpen-collapseOne">
                                                <span style="color: #0d6efd "> งบประมาณ ประจำปี 2566 </span>
                                            </button>
                                        </h2>

                                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="panelsStayOpen-headingOne">
                                            <div class="accordion-body">
                                                <div class="mb-2 row ">
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">

                                                                <div class="fs-4 fw-semibold "><span
                                                                        style="color: green ">{{ Helper::millionFormat($budgets) }}
                                                                    </span></div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">งบประมาณ</small>
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold "><span
                                                                        style="color: rgb(10, 10, 10) ">{{ Helper::millionFormat($budgetscentralict) }}</span>
                                                                </div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">งบกลาง
                                                                    ict</small>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    {{ Helper::millionFormat($budgetsinvestment) }}
                                                                </div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">งบดำเนินงาน</small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    {{ Helper::millionFormat($budgetsut) }}</div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">ค่าสาธารณูปโภค</small>
                                                            </div>

                                                        </div>
                                                    </div>




                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo"
                                                aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                                <span style="color: #6f42c1 ">การใช้จ่ายงบประมาณ PA</span>
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="panelsStayOpen-headingTwo">
                                            <div class="accordion-body">
                                                <div class="mb-1 row ">
                                                    <div class="col-sm-5 col-md-4 col-lg-2">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    <span
                                                                        style="color: #dc3545 ">{{ Helper::millionFormat($coats) }}</span>
                                                                </div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">งบประมาณ</small>
                                                            </div>


                                                        </div>
                                                    </div>


                                                    <div class="col-sm-5 col-md-4 col-lg-2">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    {{ Helper::millionFormat($coats_ict) }}</div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">งบกลาง
                                                                    ict</small>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-5 col-md-4 col-lg-2">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    {{ Helper::millionFormat($coats_inv) }}</div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">งบดำเนินงาน</small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-md-4 col-lg-2">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    {{ Helper::millionFormat($coats_ut) }}</div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">ค่าสาธารณูปโภค</small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5 col-md-4 col-lg-2">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="dropdown">
                                                                    <button class="btn  dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                                                                      <div class="fs-4 fw-semibold ">
                                                                        {{ Helper::millionFormat($coats_ut) }}</div>
                                                                    <svg class="icon icon-xl text-end">
                                                                        <use
                                                                            xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                        </use>
                                                                    </svg>
                                                                    <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">คืน</small>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                      <li><a class="dropdown-item" href="#">คืนงบกลาง ICT   {{ Helper::millionFormat($coats_ut) }}</a></li>
                                                                      <li><a class="dropdown-item" href="#">คืนงบดำเนินงาน  {{ Helper::millionFormat($coats_ut) }}</a></li>
                                                                      <li><a class="dropdown-item" href="#"> คืนค่าสาธารณูปโภค  {{ Helper::millionFormat($coats_ut) }}</a></li>
                                                                    </ul>
                                                                  </div>


                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    <span
                                                                        style="color:green;">{{ Helper::millionFormat($totals_budgets) }}
                                                                </div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">
                                                                    รวมทั้งหมด</small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    {{ Helper::millionFormat($totals_ict) }} </div>

                                                                    <svg class="icon icon-xl">
                                                                        <use
                                                                            xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                        </use>
                                                                    </svg>
                                                                    <small
                                                                        class="text-medium-emphasis text-uppercase fw-semibold">งบกลาง
                                                                        ICT</small>
                                                                </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    {{ Helper::millionFormat($totals_inv) }}</div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">งบดำเนินงาน</small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    {{ Helper::millionFormat($coats_ut) }}</div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">ค่าสาธารณูปโภค</small>
                                                            </div>

                                                        </div>
                                                    </div>





                                                </div>






                                            </div>
                                        </div>
                                    </div>


                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapseThree">
                                                <span style="color: #ec1616 "> สถานะการเบิกจ่าย </span>
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse"
                                            aria-labelledby="panelsStayOpen-headingThree">
                                            <div class="accordion-body">
                                                <div class="mb-2 row ">
                                                    <div class="col-sm-6 col-md-4 col-lg-3">

                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold"><span
                                                                        style="color:rgb(247, 10, 10);">{{ Helper::millionFormat($coatcons) }}
                                                                </div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">
                                                                    รวมทั้งหมด</small>
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold">
                                                                    {{ Helper::millionFormat($coatcons_ict) }} </div>

                                                                <svg class="icon icon-xl">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">งบกลาง
                                                                    ICT</small>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    {{ Helper::millionFormat($coatcons_inv) }}</div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">งบดำเนินงาน</small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    {{ Helper::millionFormat($coatcons_ut) }}</div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">ค่าสาธารณูปโภค</small>
                                                            </div>

                                                        </div>
                                                    </div>
-------------------------------------------------------------------------------------------------------------
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold"><span
                                                                    style="color:green;">{{ Helper::millionFormat($total_budgets) }}
                                                            </div>
                                                            <svg class="icon icon-xl text-end">
                                                                <use
                                                                    xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                </use>
                                                            </svg>
                                                            <small
                                                                class="text-medium-emphasis text-uppercase fw-semibold">
                                                                รวมทั้งหมด</small>
                                                        </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold">
                                                                    {{ Helper::millionFormat($total_ict) }} </div>

                                                                <svg class="icon icon-xl">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">งบกลาง
                                                                    ICT</small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    {{ Helper::millionFormat($total_inv) }}</div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">งบดำเนินงาน</small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card ">
                                                            <div class="card-body">
                                                                <div class="fs-4 fw-semibold ">
                                                                    {{ Helper::millionFormat($total_ut) }}</div>
                                                                <svg class="icon icon-xl text-end">
                                                                    <use
                                                                        xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-money') }}">
                                                                    </use>
                                                                </svg>
                                                                <small
                                                                    class="text-medium-emphasis text-uppercase fw-semibold">ค่าสาธารณูปโภค</small>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 ">
                        <div class="card" href="#" role="button">
                            <div class="card-body ">
                                <a class="btn btn-outline-primary" href="/itdplaning-main/public/project"
                                    role="button">
                                    <div class="fs-4 fw-semibold">{{ $project_type_j }}</div>
                                    <svg class="icon icon-xl">
                                        <use
                                            xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-building') }}">
                                        </use>
                                    </svg>
                                    <small class="text-medium-emphasis text-uppercase fw-semibold">งานประจำ</small>
                                </a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body ">
                                <a class="btn btn-outline-primary" href="/itdplaning-main/public/project/7dnamnzl"
                                    role="button">
                                    <div class="fs-4 fw-semibold">{{ $project_type_p }}</div> <svg
                                        class="icon icon-xl">
                                        <use
                                            xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-notes') }}">
                                        </use>
                                    </svg>
                                    <small class="text-medium-emphasis text-uppercase fw-semibold">โครงการ</small>
                                </a>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body ">
                                <a class="btn btn-outline-primary" href="/itdplaning-main/public/contract"
                                    role="button">
                                    <div class="fs-4 fw-semibold">{{ $contracts }}</div> <svg
                                        class="icon icon-xl">
                                        <use
                                            xlink:href=" {{ asset('vendors/@coreui/icons/sprites/free.svg#cil-notes') }}">
                                        </use>
                                    </svg>
                                    <small class="text-medium-emphasis text-uppercase fw-semibold">สัญญา</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title fs-5 fw-semibold">แยกงานประจำ/โครงการ ตามปีงบประมาณ 2566 </div>
                        <div id="chart-totalbot2-div" class="chartdiv"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="card">
                <div class="card-body">
                    <div class="card-title fs-5 fw-semibold">Project</div>
                    <div id="gantt_here" style='width:100%; height:100vh;'></div>
                </div>
            </div>
        </div>

        <!-- Widget Chart yaer -->
      <!--  <div class="mb-3 row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title fs-5 fw-semibold">งบประมาณ</div>
                        <div id="chart-project-div" class="chartdiv"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title fs-5 fw-semibold">สัญญา แยกตามปีงบประมาณ</div>
                        <div id="chart-contract-div" class="chartdiv"></div>
                    </div>
                </div>
            </div>
        </div> -->
        <!--<div class="col-sm-6 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title fs-5 fw-semibold">สัญญา เตือน </div>

                    <ul class="list-group list-group-flush">
                        @foreach ($contractsstart as $contractdr)
                            <?php
                            $start_date = \Carbon\Carbon::createFromTimestamp($contractdr->contract_start_date);
                            $end_date = \Carbon\Carbon::createFromTimestamp($contractdr->contract_end_date);
                            $duration_p = \Carbon\Carbon::parse($contractdr->contract_end_date)->diffInMonths(\Carbon\Carbon::parse($contractdr->contract_start_date)) - \Carbon\Carbon::parse($contractdr->contract_start_date)->diffInMonths(\Carbon\Carbon::parse());
                            $color = $duration_p < 3 ? 'red' : 'rgb(5, 255, 5)';
                            ?>
                            <li class="list-group-item">
                                {{ $contractdr->contract_number }}/
                                <span style="color: {{ $color }}">{{ $duration_p }} เดือน</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-3">
                        {{ $contractsstart->links() }}
                    </div>
                </div>
            </div>
        </div>  -->
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
        <table class="table table-responsive-sm table-striped" id="datatables">
            <thead>
              <tr>

                <th>{{ __('ลำดับ') }}</th>
                <th>{{ __('สัญญาที่') }}</th>
                <th></th>
                <th>{{ __('กี่เดีอนเหลือ') }}</th>
                <th>{{ __('กี่เดีอนเหลือ2') }}</th>
                <th></th>
              </tr>
            </thead>
          </table>

                </div>
            </div>
        </div>



        <style>
            .chartdiv {
                width: 100%;
                height: 250px;
            }
        </style>
    </x-slot:content>

    <x-slot:css>
        <link rel="stylesheet" href="{{ asset('/vendors/dhtmlx/dhtmlxgantt.css') }}" type="text/css">
        <link href="{{ asset('vendors/DataTables/datatables.css') }}" rel="stylesheet" />

    </x-slot:css>
    <x-slot:javascript>
        <!-- Resources -->
        <script src="{{ asset('js/jquery-3.6.1.min.') }}"></script>
        <script src="{{ asset('vendors/amcharts5/index.js') }}"></script>
        <script src="{{ asset('vendors/amcharts5/xy.js') }}"></script>
        <script src="{{ asset('vendors/amcharts5/percent.js') }}"></script>
        <script src="{{ asset('vendors/amcharts5/themes/Animated.js') }}"></script>
        <script src="{{ asset('/vendors/dhtmlx/dhtmlxgantt.js') }}"></script>
        <!-- Chart code -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
            crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script>
            am5.ready(function() {

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("chart-project-div");

                root._logo.dispose();


                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);


                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    pinchZoomX: true
                }));

                // Add cursor
                // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                cursor.lineY.set("visible", false);


                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xRenderer = am5xy.AxisRendererX.new(root, {
                    minGridDistance: 30
                });
                xRenderer.labels.template.setAll({
                    rotation: -90,
                    centerY: am5.p50,
                    centerX: am5.p100,
                    paddingRight: 15
                });

                var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    maxDeviation: 0.3,
                    categoryField: "fiscal_year",
                    renderer: xRenderer,
                    tooltip: am5.Tooltip.new(root, {})
                }));

                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation: 0.3,
                    renderer: am5xy.AxisRendererY.new(root, {})
                }));


                // Create series
                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: "Series 1",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "total_budget",
                    sequencedInterpolation: true,
                    categoryXField: "fiscal_year",
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{valueY}"
                    })
                }));

                series.columns.template.setAll({
                    cornerRadiusTL: 5,
                    cornerRadiusTR: 5
                });
                series.columns.template.adapters.add("fill", function(fill, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                });

                series.columns.template.adapters.add("stroke", function(stroke, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                });


                // Set data
                // var data = {!! $project_bu_fiscal_years !!}
                var data = {!! $project_bu_fiscal_years !!}

                //[{"fiscal_year":2566,"total_budget":110131828.00}
                //,{"fiscal_year":2565,"total_budget":92362300.00}
                //,{"fiscal_year":2564,"total_budget":97323835.00}]
                xAxis.data.setAll(data);
                series.data.setAll(data);


                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                series.appear(1000);
                chart.appear(1000, 100);

            }); // end am5.ready()
        </script>
        <script>
            am5.ready(function() {

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("chart-contract-div");
                root._logo.dispose();


                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);


                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    pinchZoomX: true
                }));

                // Add cursor
                // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                cursor.lineY.set("visible", false);


                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xRenderer = am5xy.AxisRendererX.new(root, {
                    minGridDistance: 30
                });
                xRenderer.labels.template.setAll({
                    rotation: -90,
                    centerY: am5.p50,
                    centerX: am5.p100,
                    paddingRight: 15
                });

                var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    maxDeviation: 0.3,
                    categoryField: "fiscal_year",
                    renderer: xRenderer,
                    tooltip: am5.Tooltip.new(root, {})
                }));

                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation: 0.3,
                    renderer: am5xy.AxisRendererY.new(root, {})
                }));


                // Create series
                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: "Series 1",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "total",
                    sequencedInterpolation: true,
                    categoryXField: "fiscal_year",
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{valueY}"
                    })
                }));

                series.columns.template.setAll({
                    cornerRadiusTL: 5,
                    cornerRadiusTR: 5
                });
                series.columns.template.adapters.add("fill", function(fill, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                });

                series.columns.template.adapters.add("stroke", function(stroke, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                });


                // Set data
                var data = {!! $contract_groupby_fiscal_years !!}

                xAxis.data.setAll(data);
                series.data.setAll(data);


                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                series.appear(1000);
                chart.appear(1000, 100);

            }); // end am5.ready()
        </script>


        <script>
            am5.ready(function() {

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("chart-task-div");
                root._logo.dispose();


                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);


                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    pinchZoomX: true
                }));

                // Add cursor
                // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                cursor.lineY.set("visible", false);


                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xRenderer = am5xy.AxisRendererX.new(root, {
                    minGridDistance: 30
                });
                xRenderer.labels.template.setAll({
                    rotation: -90,
                    centerY: am5.p50,
                    centerX: am5.p100,
                    paddingRight: 15
                });

                var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    maxDeviation: 0.3,
                    categoryField: "fiscal_year",
                    renderer: xRenderer,
                    tooltip: am5.Tooltip.new(root, {})
                }));

                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation: 0.3,
                    renderer: am5xy.AxisRendererY.new(root, {})
                }));


                // Create series
                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: "Series1",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "total",
                    sequencedInterpolation: true,
                    categoryXField: "fiscal_year",
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{valueY}"
                    })
                }));

                series.columns.template.setAll({
                    cornerRadiusTL: 5,
                    cornerRadiusTR: 5
                });
                series.columns.template.adapters.add("fill", function(fill, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                });

                series.columns.template.adapters.add("stroke", function(stroke, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                });


                // Set data $project_groupby_reguiar   project_groupby_fiscal_years
                var data = {!! $project_groupby_reguiar !!}


                xAxis.data.setAll(data);
                series.data.setAll(data);


                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                series.appear(1000);
                chart.appear(1000, 100);

            }); // end am5.ready()
        </script>

        <script>
            am5.ready(function() {

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("chart-d-div");
                root._logo.dispose();


                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);


                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    pinchZoomX: true
                }));

                // Add cursor
                // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                cursor.lineY.set("visible", false);


                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xRenderer = am5xy.AxisRendererX.new(root, {
                    minGridDistance: 30
                });
                xRenderer.labels.template.setAll({
                    rotation: -90,
                    centerY: am5.p50,
                    centerX: am5.p100,
                    paddingRight: 15
                });

                var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    maxDeviation: 0.3,
                    categoryField: "fiscal_year",
                    renderer: xRenderer,
                    tooltip: am5.Tooltip.new(root, {})
                }));

                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation: 0.3,
                    renderer: am5xy.AxisRendererY.new(root, {})
                }));


                // Create series
                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: "Series1",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "total",
                    sequencedInterpolation: true,
                    categoryXField: "fiscal_year",
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{name}, {categoryX}: {valueY}"
                    })
                }));

                series.columns.template.setAll({
                    cornerRadiusTL: 5,
                    cornerRadiusTR: 5
                });
                series.columns.template.adapters.add("fill", function(fill, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                });

                series.columns.template.adapters.add("stroke", function(stroke, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                });


                // Set data $project_groupby_reguiar   project_groupby_fiscal_years
                var data = {!! $taskcosttotals !!}

                xAxis.data.setAll(data);
                series.data.setAll(data);


                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                series.appear(1000);
                chart.appear(1000, 100);

            }); // end am5.ready()
        </script>



        <!-- Chart code -->
        <script>
            am5.ready(function() {

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("chart-totalbot-div");


                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);


                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: false,
                    panY: false,

                    wheelX: "panX",
                    wheelY: "zoomX",
                    layout: root.verticalLayout
                }));


                // Add legend
                // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                var legend = chart.children.push(am5.Legend.new(root, {
                    centerX: am5.p50,
                    x: am5.p50
                }));

                var data = {!! $project_bu_fiscal_years !!}

                [{
                        "year": "1",
                        "งบการ ICT": null,
                        "งบดำเนินงาน": null,
                        "ค่าสาธารณูปโภค": null,

                    },

                    {
                        "year": "2",
                        "งบการ ICT": null,
                        "งบดำเนินงาน": null,
                        "ค่าสาธารณูปโภค": null,
                    },

                    {
                        "year": "3",
                        "งบการ ICT": null,
                        "งบดำเนินงาน": null,
                        "ค่าสาธารณูปโภค": null,
                    },
                    {
                        "year": "4",
                        "งบการ ICT": null,
                        "งบดำเนินงาน": null,
                        "ค่าสาธารณูปโภค": null,
                    },
                    {
                        "year": "5",
                        "งบการ ICT": 1380000,
                        "งบดำเนินงาน": 10053592,
                        "ค่าสาธารณูปโภค": null,

                    },
                    {
                        "year": "6",
                        "งบการ ICT": null,
                        "งบดำเนินงาน": null,
                        "ค่าสาธารณูปโภค": null,
                    },

                    {
                        "year": "7",
                        "งบการ ICT": null,
                        "งบดำเนินงาน": null,
                        "ค่าสาธารณูปโภค": 10250000,

                    },
                    {
                        "year": "8",
                        "งบการ ICT": null,
                        "งบดำเนินงาน": null,
                        "ค่าสาธารณูปโภค": null,
                    },
                    {
                        "year": "9",
                        "งบการ ICT": null,
                        "งบดำเนินงาน": null,
                        "ค่าสาธารณูปโภค": null,
                    },
                    {
                        "year": "10",
                        "งบการ ICT": null,
                        "งบดำเนินงาน": null,
                        "ค่าสาธารณูปโภค": null,
                    },
                    {
                        "year": "11",
                        "งบการ ICT": null,
                        "งบดำเนินงาน": null,
                        "ค่าสาธารณูปโภค": null,
                    },
                    {
                        "year": "12",
                        "งบการ ICT": null,
                        "งบดำเนินงาน": null,
                        "ค่าสาธารณูปโภค": null,
                    },

                ];


                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xRenderer = am5xy.AxisRendererX.new(root, {
                    cellStartLocation: 0.1,
                    cellEndLocation: 0.9
                });

                var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    categoryField: "year",

                    renderer: xRenderer,
                    tooltip: am5.Tooltip.new(root, {})
                }));

                xRenderer.grid.template.setAll({
                    location: 1
                })

                xAxis.data.setAll(data);

                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    min: 0,

                    calculateTotals: true,
                    extraMax: 0.1,
                    renderer: am5xy.AxisRendererY.new(root, {
                        strokeOpacity: 0.1
                    })
                }));


                // Add series
                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                function makeSeries(name, fieldName, stacked) {
                    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                        stacked: stacked,
                        name: name,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: fieldName,
                        categoryXField: "year",
                        stacked: true,
                        maskBullets: false

                    }));

                    series.columns.template.setAll({
                        tooltipText: "{name}, {categoryX}:{valueY}",
                        width: am5.percent(90),
                        tooltipY: am5.percent(10)
                    });
                    series.data.setAll(data);

                    // Make stuff animate on load
                    // https://www.amcharts.com/docs/v5/concepts/animations/
                    series.appear();

                    series.bullets.push(function() {
                        return am5.Bullet.new(root, {
                            locationY: 0.5,
                            sprite: am5.Label.new(root, {
                                text: "{valueY}",
                                fill: root.interfaceColors.get("alternativeText"),
                                centerY: am5.percent(50),
                                centerX: am5.percent(50),
                                populateText: true
                            })
                        });
                    });

                    legend.data.push(series);
                }
                makeSeries("งบกลาง ICT", "งบการ ICT", true);
                makeSeries("งบดำเนินงาน", "งบดำเนินงาน", true);
                makeSeries("ค่าสาธารณูปโภค", "ค่าสาธารณูปโภค", true);





                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                chart.appear(1000, 100);

            }); // end am5.ready()
        </script>

        <!-- HTML -->
        <script>
            gantt.plugins({
                marker: true,
                fullscreen: true,
                critical_path: true,
                // auto_scheduling: true,
                tooltip: true,
                // undo: true
            });

            //Marker
            var date_to_str = gantt.date.date_to_str(gantt.config.task_date);
            var today = new Date();
            gantt.addMarker({
                start_date: today,
                css: "today",
                text: "Today",
                title: "Today: " + date_to_str(today)
            });




            //Template
            var leftGridColumns = {
                columns: [{
                        name: "",
                        width: 60,
                        resize: false,
                        template: function(task) {
                            return "<span class='gantt_grid_wbs'>" + gantt.getWBSCode(task) + "</span>"
                        }
                    },



                    {
                        name: "text",
                        width: 50,
                        label: "ปี",
                        template: function(task) {
                            if (task.project_fiscal_year) {
                                return new Intl.NumberFormat(
                                    'th-TH', {

                                        useGrouping: false
                                    }
                                ).format(task.project_fiscal_year);
                            } else {
                                return '';
                            }

                        }
                    },
                    {
                        name: "text",
                        width: 300,
                        label: "โครงการ/งานประจำ",
                        tree: true,
                        resize: true,
                        template(task) {
                            if (gantt.getState().selected_task == task.id) {
                                return "<b>" + task.text + "</b>";
                            } else {
                                return task.text;
                            };
                        }
                    },
                    //{name:"start_date", label:"Start time", align: "center" },
                    // {name:"owner", width: 200, label:"Owner", template:function(task){
                    //   return task.owner}
                    // }
                ]
            };
            var rightGridColumns = {
                columns: [{
                        name: "budget",
                        width: 100,
                        label: "งบประมาณ",
                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.budget) {
                                return new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.budget);
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        name: "cost",
                        width: 100,
                        label: "ใช้จ่ายแล้ว",
                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.cost) {
                                return '<span style="color:red;">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.cost) + '</span>';
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        name: "balance",
                        width: 100,
                        label: "คงเหลือ",
                        template: function(task) {
                            //console.log((task.budget).toLocaleString("en-US", {style: 'currency', currency: 'USD'}));
                            if (task.balance) {
                                var tmp_class = task.balance > 0 ? 'green' : 'red';
                                return '<span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                                    style: 'currency',
                                    currency: 'THB'
                                }).format(task.balance) + '</span>';
                            } else {
                                return '';
                            }
                        }
                    }
                ]
            };
            gantt.templates.tooltip_text = function(start, end, task) {
                var budget_gov = task.budget_gov ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_gov) : '';
                var budget_it = task.budget_it ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_it) : '';
                var budget = task.budget ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget) : '';
                var budget_gov_operating = task.budget_gov_operating ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_gov_operating) : '';
                var budget_gov_investment = task.budget_gov_investment ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_gov_investment) : '';
                var budget_gov_utility = task.budget_gov_utility ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_gov_utility) : '';
                var budget_it_operating = task.budget_it_operating ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_it_operating) : '';
                var budget_it_investment = task.budget_it_investment ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.budget_it_investment) : '';

                var cost = task.cost ? new Intl.NumberFormat('th-TH', {
                    style: 'currency',
                    currency: 'THB'
                }).format(task.cost) : '';

                var html = '<b>โครงการ/งาน:</b> ' + task.text + '<br/>';
                html += task.owner ? '<b>เจ้าของ:</b> ' + task.owner + '<br/>' : '';

                if (budget) {
                    html += '<table class="table table-sm " style="font-size:9px">';
                    html += '<tr class="text-center align-middle">\
                                                      <td colspan="3">เงินงบประมาณ<br>(งบประมาณขอรัฐบาล)</td>\
                                                      <td colspan="2">งบกลาง IT</td>\
                                                      <td rowspan="2">รวมทั้งหมด<br>(เงินงบประมาณ+งบกลาง)</td>\
                                                    </tr>';
                    html += '<tr>\
                                                      <td>งบดำเนินงาน<br>(ค่าใช้สอยต่างๆ)</td>\
                                                      <td>งบลงทุน IT<br>(ครุภัณฑ์ต่างๆ)</td>\
                                                      <td>ค่าสาธารณูปโภค</td>\
                                                      <td>งบดำเนินงาน<br>(ค่าใช้สอยต่างๆ)</td>\
                                                      <td>งบลงทุน<br>(ครุภัณฑ์ต่างๆ)</td>\
                                                    </tr>';
                    html += '<tr class="text-end">\
                                                      <td>' + budget_gov_operating + '</td>\
                                                      <td>' + budget_gov_investment + '</td>\
                                                      <td>' + budget_gov_utility + '</td>\
                                                      <td>' + budget_it_operating + '</td>\
                                                      <td>' + budget_it_investment + '</td>\
                                                      <td class="text-success">' + budget + '</td>\
                                                    </tr>';
                    html += '</table>';
                }

                if (task.cost) {
                    html += '<b>ค่าใช้จ่าย:</b> <span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                        style: 'currency',
                        currency: 'THB'
                    }).format(task.cost) + '</span><br/>';
                }
                if (task.balance) {
                    var tmp_class = task.balance > 0 ? 'green' : 'red';
                    html += '<b>คงเหลือ:</b> <span style="color:' + tmp_class + ';">' + new Intl.NumberFormat('th-TH', {
                        style: 'currency',
                        currency: 'THB'
                    }).format(task.balance) + '</span><br/>';
                }

                return html;
            };

            gantt.ext.fullscreen.getFullscreenElement = function() {
                return document.querySelector("#gantt_here");
            };
            //Config
            gantt.config.date_format = "%Y-%m-%d";

            gantt.config.drag_links = false;
            gantt.config.drag_move = false;
            gantt.config.drag_progress = false;
            gantt.config.drag_resize = false;
            gantt.config.grid_resize = true;
            gantt.config.layout = {
                css: "gantt_container",
                rows: [{
                        cols: [{
                                view: "grid",
                                width: 500,
                                scrollX: "scrollHor",
                                scrollY: "scrollVer",
                                config: leftGridColumns
                            },
                            {
                                resizer: true,
                                width: 1
                            },
                            {
                                view: "timeline",
                                scrollX: "scrollHor",
                                scrollY: "scrollVer"
                            },
                            {
                                resizer: true,
                                width: 1
                            },
                            {
                                view: "grid",
                                width: 300,
                                bind: "task",
                                scrollY: "scrollVer",
                                config: rightGridColumns
                            },
                            {
                                view: "scrollbar",
                                id: "scrollVer"
                            }
                        ]

                    },
                    {
                        view: "scrollbar",
                        id: "scrollHor",
                        height: 20
                    }
                ]
            };
            gantt.config.readonly = true;
            gantt.config.scales = [{
                    unit: "year",
                    step: 1,
                    format: "%Y"
                },
                {
                    unit: "month",
                    step: 2,
                    format: "%M, %Y"
                },
                // {unit: "day", step: 3, format: "%D %M, %Y"},
            ];
            //ganttModules.zoom.setZoom("months");

            gantt.init("gantt_here");
            gantt.parse({
                data: {!! $gantt !!}
            });
        </script>


        <!-- xy2 -->
        <!-- Chart code -->
        <script>
            am5.ready(function() {



                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new("chart-totalbot2-div");


                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([
                    am5themes_Animated.new(root)
                ]);


                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: false,
                    panY: false,
                    wheelX: "panX",
                    wheelY: "zoomX",

                    layout: root.verticalLayout
                }));


                // Add legend
                // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                var legend = chart.children.push(
                    am5.Legend.new(root, {
                        centerX: am5.p50,
                        x: am5.p50
                    })
                );



                var data = {!! $project_groupby !!}
                var data1 = {!! $taskcosttotals !!}
                var date2 = {!! $taskcosttotals2_json !!}
                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xRenderer = am5xy.AxisRendererX.new(root, {
                    cellStartLocation: 0.1,
                    cellEndLocation: 0.9,
                    minGridDistance: 10
                });
                xRenderer.grid.template.set("location", 0.5);
                xRenderer.labels.template.setAll({
                    location: 0.5,
                    multiLocation: 0.5
                });


                var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    categoryField: "fiscal_year_b",

                    renderer: xRenderer,
                    tooltip: am5.Tooltip.new(root, {}),

                }));

                xRenderer.grid.template.setAll({
                    location: 1
                })
                xAxis.data.setAll(data);




                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    renderer: am5xy.AxisRendererY.new(root, {
                        strokeOpacity: 0.1
                    })
                }));


                // Add series
                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                function makeSeries(name, fieldName) {
  var series = chart.series.push(am5xy.ColumnSeries.new(root, {
    name: name,
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: fieldName,
    categoryXField: "fiscal_year_b",

  }));

  series.columns.template.setAll({
    tooltipText: "[bold]{name}[/]\n {categoryX}[/]\n:{valueY}",
    width: am5.percent(100),

    stacked: true,
    fill: am5.color(0x68dc76),

  });

  series.data.setAll(data);
  // Make stuff animate on load
  // https://www.amcharts.com/docs/v5/concepts/animations/
  series.appear();

  series.bullets.push(function() {
    return am5.Bullet.new(root, {
      locationY: 0,
      sprite: am5.Label.new(root, {
        text: "{valueY}",
        populateText: true,
        fill: root.interfaceColors.get("alternativeText"),
        centerY: 0,
        centerX: am5.p50,
        populateText: true
      })
    });
  });

  legend.data.push(series);
};
              //  makeSeries("การใช้จ่ายประมาณ", "total_cost");
                 makeSeries("งบประมาณ", "total_budgot")
                ;


                function makeSeries2(name, fieldName) {
                    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                        name: name,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: fieldName,


                        categoryXField: "fiscal_year_b"
                    }));

                    series.columns.template.setAll({
                        tooltipText: "[bold]{name}[/]\n {categoryX}[/]\n:{valueY}[/]\n:{percentage}%",
                        width: am5.percent(100),
                        fill: am5.color(0xb30000),
                        tooltipY: 0,
                        strokeOpacity: 0
                    });

                    series.data.setAll(date2);
                    // Make stuff animate on load
                    // https://www.amcharts.com/docs/v5/concepts/animations/
                    series.appear();

                    series.bullets.push(function() {
                        return am5.Bullet.new(root, {
                            locationY: 0,
                            sprite: am5.Label.new(root, {
                                text: "{valueY}",
                                populateText: true,
                                fill: root.interfaceColors.get("alternativeText"),
                                centerY: 0,
                                centerX: am5.p50,
                                populateText: true
                            })
                        });
                    });

                    legend.data.push(series);
                };

              //  makeSeries("การใช้จ่ายประมาณ", "total_cost");
                 makeSeries2("การใช้จ่ายประมาณ", "total_cost")
                ;






                function createSeries(name, field) {
                    var series = chart.series.push(
                        am5xy.LineSeries.new(root, {
                            name: name,
                            xAxis: xAxis,
                            yAxis: yAxis,
                            valueYField: field,
                            stroke:  am5.color(0xb30000),
                            categoryXField: "fiscal_year_b",
                            tooltip: am5.Tooltip.new(root, {
                                pointerOrientation: "horizontal",
                               labelText: "[bold]{name}[/]\nแผน{categoryX}\n: {valueY} บาท\n: {percentage} %"
                            })
                        })
                    );
                    series.bullets.push(function() {
                        return am5.Bullet.new(root, {
                            sprite: am5.Circle.new(root, {
                                text: "{valueY}",
                                strokeWidth: 3,
                                stroke: series.get("stroke"),
                                radius: 5,

                                fill: am5.color(0xb30000),

                            })
                        });
                    });

                    // create hover state for series and for mainContainer, so that when series is hovered,
                    // the state would be passed down to the strokes which are in mainContainer.



                    series.set("setStateOnChildren", true);
                    series.states.create("hover", {});

                    series.mainContainer.set("setStateOnChildren", true);
                    series.mainContainer.states.create("hover", {});

                    series.strokes.template.states.create("hover", {
                        strokeWidth: 4,



                    });
                    series.data.setAll(date2);


                }
                chart.set("cursor", am5xy.XYCursor.new(root, {}));
               // createSeries("งบประมาณ", "total_budgot");
                createSeries("ภาพรวมค่าใช้จ่าย ", "total_cost")



                legend.data.setAll(chart.series.values);

                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                chart.appear(1000, 100);



            }); // end am5.ready()
        </script>



<script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>
    <script>
      $(document).ready(function() {
        var token = $('meta[name="csrf-token"]').attr('content');
        var modal = $('.modal')
        var form = $('.form')
        var btnAdd = $('.add'),
          btnSave = $('.btn-save'),
          btnUpdate = $('.btn-update');
        var table = $('#datatables').DataTable({
          autoWidth: false,
          processing: true,
          serverSide: true,
          responsive: true,
          ajax: "{{ route('contract.index') }}",
          language: {
            processing: "กำลังประมวลผล...",
            search: "ค้นหา:",
            lengthMenu: "แสดง _MENU_ รายการ",
            info: "แสดงรายที่ _START_ ถึง _END_ ทั้งหมด _TOTAL_ รายการ",
            infoEmpty: "แสดงรายที่ 0 ถึง 0 ทั้งหมด 0 รายการ",
            infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
            infoPostFix: "",
            loadingRecords: "Chargement en cours...",
            zeroRecords: "ไม่พบข้อมูล",
            emptyTable: "ไม่พบข้อมูล",
            paginate: {
              first: "หน้าแรก",
              previous: "ย้อนกลับ",
              next: "ถัดไป",
              last: "หน้าสุดท้าย"
            },
            aria: {
              sortAscending: ": เรียงจากน้อยไปหามาก",
              sortDescending: ": เรียงจากมากไปหาน้อย"
            }
          },
          columns: [{
            data: 'DT_RowIndex',
              name: 'DT_RowIndex',
              orderable: false,
              searchable: false
            },
            {
              data: 'contract_number_output',
              name: 'contract_number'
            },
            {
              data: 'contract_name_output',
              name: 'contract_name'
            },
            {
              data: 'contract_fiscal_year'
            },
            {
              className: "text-end",
              data: 'action',
              orderable: false,
              searchable: false
            }
          ]
        });

        btnUpdate.click(function() {
          if (!confirm("Are you sure?")) return;
          var formData = form.serialize() + '&_method=PUT&_token=' + token
          var updateId = form.find('input[name="id"]').val()
          $.ajax({
            type: "POST",
            url: "/" + updateId,
            data: formData,
            success: function(data) {
              if (data.success) {
                table.draw();
                modal.modal('hide');
              }
            }
          }); //end ajax
        })


        $(document).on('click', '.btn-delete', function() {
          if (!confirm("Are you sure?")) return;

          var rowid = $(this).data('rowid')
          var el = $(this)
          if (!rowid) return;


          $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: "{{ url('contract') }}/" + rowid,
            data: {
              _method: 'delete',
              _token: token
            },
            success: function(data) {
              if (data.success) {
                table.row(el.parents('tr'))
                  .remove()
                  .draw();
              }
            }
          }); //end ajax
        })
      });
    </script>






    </x-slot:javascript>


</x-app-layout>
