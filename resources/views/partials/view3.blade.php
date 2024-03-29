

<div class="d-flex align-items-start">
    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link active " id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home"
            type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">ภาพรวมทั้งหมด
            <!--{{ Helper::projectsType($project->project_type) }}{{ $project->reguiar_id }}-->
        </button>
        @if ($project['budget_it_operating'] > 0)
            <button class="nav-link " id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile"
                type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">งบกลาง
                ICT</button>
        @endif
        @if ($project['budget_it_investment'] > 0)
            <button class="nav-link " id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages"
                type="button" role="tab" aria-controls="v-pills-messages"
                aria-selected="false">งบดำเนินงาน</button>
        @endif
        @if ($project['budget_gov_utility'] > 0)
            <button class="nav-link " id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings"
                type="button" role="tab" aria-controls="v-pills-settings"
                aria-selected="false">งบสาธารณูปโภค</button>
        @endif
    </div>
    <div class="tab-content" id="v-pills-tabContent">
        <!-- 1 งาน -->
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="row g-3">
                <div class="col-md-6">
                    <!--งบประมาณ-->
                    <div class="card">
                        <div class="card-body">

                            <button id="popover_content_wrapper"
                            class="col-md-12 btn " data-bs-toggle="popover"
                             data-bs-placement="bottom"
                             data-bs-custom-class="custom-popover"
                             data-bs-title="งบประมาณที่ได้รับการจัดสรร" data-bs-content="
                            @if ($project['budget_it_operating'] > 0)
                                งบกลาง ICT :  {{ number_format($project['budget_it_operating']),2 }} บาท <br>
                            @endif
                            @if ($project['budget_it_investment'] > 0)
                                งบดำเนินงาน :{{ number_format($project['budget_it_investment']),2 }} บาท <br>
                            @endif
                            @if ($project['budget_gov_utility'] > 0)
                                งบสาธารณูปโภค : {{ number_format($project['budget_gov_utility']),2 }} บาท <br>
                            @endif
                            " data-bs-trigger="hover focus">

                                <div class="fs-4 fw-semibold">
                                    {{ number_format($budget['total'], 2) }}
                                </div>
                                <small class="text-xl">
                                    งบประมาณที่ได้รับการจัดสรร
                                </small>
                            </button>

{{--
                            <button class="btn" style="width: 13rem;" data-bs-toggle="popover" data-bs-content="งบประมาณที่ได้รับการจัดสรร"
                            disabled data-bs-trigger="hover focus">
                            <div class="fs-4 fw-semibold">
                                {{ number_format($budget['total'], 2) }}
                            </div>
                            <small class="text-xl">
                                งบประมาณที่ได้รับการจัดสรร
                            </small>
                        </button> --}}



                        </div>
                    </div>
                </div>



                <div class="col-md-6">
                    <!--คงเหลือ-->
                    <div class="card  ">
                        <div class="card-body">
                            {{-- <button class="col-md-12 btn "
                                data-bs-toggle="collapse" href="#multiCollapseExample1"
                                role="button" aria-expanded="false"
                                aria-controls="multiCollapseExample1">
                                @php
                                    $tmp_class_bal = $budget['balance'] > 1000000 ? 'success' : 'danger';
                                @endphp
                                <div class="fs-4 fw-semibold text-success">
                                    {{ number_format(floatval($budget['budget_total_mm_pr']), 2) }}
                                </div>

                                <small class="text-xl">งบประมาณคงเหลือที่ไช้ได้</small>
                            </button> --}}

                            <button id="popover_content_wrapper"
                            class="btn" data-bs-toggle="popover"
                             data-bs-placement="bottom"
                             data-bs-custom-class="custom-popover-2"
                             data-bs-title="งบประมาณคงเหลือที่ไช้ได้" data-bs-content="
                            @if ($project['budget_it_operating'] > 0)
                                งบกลาง ICT :   {{ number_format(floatval($op_refund_mm_pr), 2) }} บาท <br>
                            @endif
                            @if ($project['budget_it_investment'] > 0)
                                งบดำเนินงาน : {{ number_format(floatval($is_refund_mm_pr), 2) }}บาท <br>
                            @endif
                            @if ($project['budget_gov_utility'] > 0)
                                งบสาธารณูปโภค :  {{ number_format(floatval($ut_refund_mm_pr), 2) }} บาท <br>
                            @endif
                            " data-bs-trigger="hover focus">




                                <div class="fs-4 fw-semibold text-success">
{{--                                     {{ number_format(floatval($budget['budget_total_mm_pr']), 2) }} --}}
                                    {{ number_format(floatval( $budget['budget_total_task_budget_end']), 2) }}

                                </div>
                                <small class="text-xl">
                                    งบประมาณคงเหลือที่ไช้ได้
                                </small>
                            </button>


                        </div>
                    </div>
                </div>

                <div class="col d-none">
                    <!--รอเบิก-->
                    <div class="card">
                        <div class="card-body">

                            <button class="col-md-12 btn " data-bs-toggle="collapse"
                                href="#multiCollapseExample1" role="button" aria-expanded="false"
                                aria-controls="multiCollapseExample1">
                                <div class="fs-4 fw-semibold text-warning">
                                    {{ number_format($budget['cost']-$budget['pay'], 2) }}
                                </div>

                                <small class="text-xl">
                                    งบประมาณ  รอเบิกจ่ายใช้
                                </small>
                            </button>


                        </div>
                    </div>
                </div>

                <div class="col d-none">
                    <!--คงเหลือ-->
                    <div class="card  ">
                        <div class="card-body">
                            <button class="col-md-12 btn " data-bs-toggle="collapse"
                                href="#multiCollapseExample1" role="button" aria-expanded="false"
                                aria-controls="multiCollapseExample1">
                                @php
                                    $tmp_class_bal = $budget['balance'] > 1000000 ? 'success' : 'danger';
                                @endphp
                                <div class="fs-4 fw-semibold text-danger">
                                    {{ number_format(floatval($budget['pay']), 2) }}
                                </div>

                                <small class="text-xl">งบประมาณ ที่เบิกจ่าย</small>
                            </button>

                        </div>
                    </div>
                </div>

                <div class="col d-none">
                    <!--คงเหลือ-->
                    <div class="card  ">
                        <div class="card-body">
                            <button class="col-md-12 btn " data-bs-toggle="collapse"
                                href="#multiCollapseExample1" role="button" aria-expanded="false"
                                aria-controls="multiCollapseExample1">
                                @php
                                    $tmp_class_bal = $budget['balance'] > 1000000 ? 'success' : 'danger';
                                @endphp
                                <div class="fs-4 fw-semibold text">

                                    {{ number_format(floatval($budget['total']-$budget['pay']), 2) }}
                                    {{ number_format(floatval($budget['balance']), 2) }}
                                </div>

                                <small class="text-xl">กรอบงบประมาณคงเหลือ ที่เบิกจ่าย</small>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end1 งาน -->
        <!-- 2 งาน -->
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

            <div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <button class="btn "style="width: 12rem;" data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-transparent ">
                                        {{ number_format($project['budget_it_operating']) }}
                                    </div>
                                    <div>
                                        <small class="text-xl">
                                            งบประมาณ <p>ที่ได้รับการจัดสรร<p>
                                        </small>
                                    </div>
                                </button>
                            </div>

                        </div>
                    </div>
                    <div class="d-none col">

                        <div class="card">
                            <div class="card-body">
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-transparent ">
                                       {{--  {{ number_format($project['budget_it_operating'], 2) }} --}}
                                        {{ number_format(($op_budget), 2) }}
                                    </div>
                                    <small class="text-xl">
                                        1.วงเงินที่ขออนุมัติ MM/PR
                                    </small>
                                </button>
                            </div>
                            <div class="collapse" id="multiCollapseExample1">
                                <div class="card-body">

                                    <button class="col-md-12 btn " style="color:   #06268e"
                                        data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
                                        aria-expanded="false" aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold btn btn">
                                            {{ number_format($ospa, 2) }}
                                        </div>
                                        <small class="text-xl">1.1 จำนวนเงิน แบบมี PA
                                        </small>
                                    </button>
                                </div>
                                <div class="card-body">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold ">
                                            <!--จำนวนเงินแบบไม่มี PA-->{{ number_format($osa, 2) }}
                                        </div>
                                        <small class="text-xl">1.3 จำนวนเงิน แบบไม่มี PA
                                        </small>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">

                            <div class="card-body ">
                                <!--รอการเบิกจ่ายทั้งหมด 2-->
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-info ">
                                        <!--รอการเบิกจ่ายทั้งหมด-->
                                        {{ number_format($ospa + $osa, 2) }}
                                    </div>
                                    <div >
                                        <small class="text-xl ">วงเงินที่ใช้จริง<p>(รวมแบบมี PA และไม่มี PA)</small>
                                    </div>
                                </button>
                            </div>
                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                <div class="card-body">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold text-info">
                                            <!--การเบิกจ่าย PA -->
                                            {{ number_format($ospa, 2) }}
                                        </div>
                                        <small class="text-xl">วงเงินที่ใช้จริง<p> รวมแบบมี
                                            PA </small>

                                    </button>
                                </div>
                                <div class="card-body">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold text-info">
                                            <!--การเบิกจ่าย ไม่แบบ PA -->
                                            {{ number_format($osa , 2) }}
                                        </div>
                                        <div>
                                            <small class="text-xl"> วงเงินที่ใช้จริง <p>ไม่แบบ
                                                PA</small>
                                        </div>

                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>



                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <!--รอการเบิกจ่ายทั้งหมด 3-->
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-danger">
                                        <!--รอการเบิกจ่ายทั้งหมด-->
                                        {{ number_format($ospa - $otpsa1 - ($otpsa2 - $osa),2) }}
                                    </div>
                                    <div>
                                        <small class="text-xl">รอการเบิกจ่ายทั้งหมด<p>
                                            &nbsp;</small>
                                    </div>
                                </button>
                            </div>
                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                <div class="card-body">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold text-danger">
                                            <!--การเบิกจ่าย PA -->
                                            {{ number_format($ospa - $otpsa1, 2) }}
                                        </div>
                                        <small class="text-xl">รอการเบิกจ่าย <p>แบบมี PA
                                        </small>

                                    </button>
                                </div>
                                <div class="card-body">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold text-danger">
                                            <!--การเบิกจ่าย PA -->
                                            {{ number_format($osa - $otpsa2, 2) }}
                                        </div>
                                        <small class="text-xl">รอการเบิกจ่าย <p>แบบมีไม่ PA
                                        </small>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="card-body ">
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-warning">
                                        <!--รวมเบิกจ่ายทั้งหมด-->
                                        {{ number_format($otpsa1 + $otpsa2, 2) }}

                                    </div>
                                    <div>
                                        <small class="text-xl">เบิกจ่ายแล้วทั้งหมด<p>
                                            &nbsp;</small>
                                    </div>
                                </button>

                            </div>
                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                <div class="card-body">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold text-warning">
                                            {{ number_format($otpsa1, 2) }}
                                        </div>
                                        <small class="text-xl">การเบิกเงิน<p>
                                            แบบมี PA
                                        </small>
                                    </button>
                                </div>
                                <div class="card-body">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold text-warning">
                                            <!--จำนวนเงินแบบไม่มี PA-->{{ number_format($otpsa2, 2) }}
                                        </div>
                                        <small class="text-xl">การเบิกเงิน<p>
                                            แบบไม่มี PA
                                        </small>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-success">
                                       {{-- {{ number_format(floatval($op_refund_budget_pr), 2) }} --}}
                                       {{ number_format(floatval( $budget['budget_total_task_budget_end']), 2) }}
                                    </div>
                                    <div>
                                        <small class="text-xl">
                                            งบประมาณคงเหลือที่ไช้ได้<p>
                                                &nbsp;
                                        </small>
                                    </div>
                                </button>
                            </div>
                          {{--   <div class="collapse" id="multiCollapseExample1">
                                <div class="card-body">

                                    <button class="col-md-12 btn " style="color:   #06268e"
                                        data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
                                        aria-expanded="false" aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold">

                                        </div>
                                        <div>
                                            <small class="text-xl">วงเงินที่ขออนุมัติ <p>แบบมี PR
                                            </small>
                                        </div>
                                    </button>
                                </div>
                                <div class="card-body">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold">

                                        </div>
                                        <div>
                                            <small class="text-xl">วงเงินที่ขออนุมัติ <p>แบบไม่มีPR
                                            </small>
                                        </div>
                                    </button>
                                </div>

                            </div> --}}


                        </div>

                    </div>

                    <div class="col-1">
                        <div class="card-1 ">

                                <button class="btn btn-info"
                                type="button"
                                data-bs-toggle="collapse" data-bs-target=".multi-collapse"
                                 aria-expanded="true"
                                 aria-controls="multiCollapseExample
                                 multiCollapseExample1 multiCollapseExample2
                                 multiCollapseExample3">
                                 <i class="cil-plus"></i>

                               </button>





                        </div>

                    </div>


                    <div class="col d-none">
                        <div class="card">
                            <div class="card-body">
                                <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn" style="btn btn">
                                        <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                       {{--  {{ number_format($project['budget_it_operating'] - ($ospa + $osa), 2) }} --}}
                                        {{ number_format($project['budget_it_operating'] - ($otpsa1 + $otpsa2), 2) }}
                                    </div>
                                    <div>
                                        <small class="text-xl">5. กรอบงบประมาณคงเหลือ ที่เบิกจ่าย
                                        </small>
                                    </div>
                                </button>
                            </div>
                        </div>
                    {{--     <div class="card">
                            <div class="card-body">
                                <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-info" style="btn btn-warning">
                                        <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                        {{ number_format($project['total_pay'], 2) }}
                                    </div>
                                    <div>
                                        <small class="text-xl">เบิกจ่ายงบประมาณแล้ว</small>
                                    </div>
                                </button>
                            </div>
                        </div> --}}

                    </div>


                </div>
            </div>
        </div>

        <!-- 2 งาน จบ-->
        <!-- 3 งาน -->



        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
            <!-- 3 งาน -->
            <!--งบประมาณ-->
            <div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-transparent ">

                                        {{ number_format($project['budget_it_investment']) }}
                                    </div>
                                    <div>
                                        <small class="text-xl">
                                           งบประมาณ <p>ที่ได้รับการจัดสรร<p>
                                        </small>
                                    </div>
                                </button>
                            </div>

                        </div>
                    </div>
                    <div class="d-none col ">
                        <div class="card">
                            <div class="card-body">
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn">
                                        {{ number_format(($is_budget), 2) }}
                                       {{--  {{ number_format(($op_budget), 2) }} --}}
                                    </div>
                                    <div>
                                        <small class="text-xl">
                                           1. วงเงินที่ขออนุมัติ MM/PR
                                        </small>
                                    </div>
                                </button>
                            </div>
                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                <div class="card-body">

                                    <button class="btn " data-bs-toggle="collapse" style="width: 12rem;"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold">
                                            {{ number_format($ispa, 2) }}
                                        </div>
                                        <div>
                                            <small class="text-xl">จำนวนเงิน <p>แบบมี
                                                PA
                                            </small>
                                        </div>
                                    </button>
                                </div>
                                <div class="card-body">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold">
                                            <!--จำนวนเงินแบบไม่มี PA-->{{ number_format($isa, 2) }}
                                        </div>
                                        <small class="text-xl ">จำนวนเงินแบบ <p>ไม่มี PA
                                        </small>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card ">

                            <div class="card-body ">
                                <!--รอการเบิกจ่ายทั้งหมด 2-->
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-info">
                                        <!--รอการเบิกจ่ายทั้งหมด-->
                                        {{ number_format($ispa + $isa, 2) }}
                                    </div>
                                    <div>
                                        <small class="text-xl">วงเงินที่ใช้จริง <p>(รวมแบบมี PA และไม่มี PA)</small>
                                    </div>
                                </button>
                            </div>
                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                <div class="card-body">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold text-info">
                                            <!--การเบิกจ่าย PA -->
                                            {{ number_format($ispa, 2) }}
                                        </div>
                                        <small class="text-xl">วงเงินที่ใช้จริง <p>รวมแบบมี
                                            PA </small>

                                    </button>
                                </div>
                                <div class="card-body">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold text-info">
                                            <!--การเบิกจ่าย ไม่แบบ PA -->
                                            {{ number_format($isa , 2) }}
                                        </div>
                                        <div>
                                            <small class="text-xl">วงเงินที่ใช้จริง <p>ไม่แบบ
                                                PA</small>
                                        </div>

                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <!--รอการเบิกจ่ายทั้งหมด 3-->
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-danger">
                                        <!--รอการเบิกจ่ายทั้งหมด-->
                                        {{ number_format($ispa - $itpsa1 - ($itpsa2 - $isa), 2) }}
                                    </div>
                                    <div>
                                        <small class="text-xl ">รอการเบิกจ่ายทั้งหมด<p>
                                            &nbsp;</small>
                                    </div>

                                </button>
                            </div>

                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                <div class="card-body ">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold text-danger">
                                            <!--การเบิกจ่าย PA -->
                                            {{ number_format($ispa - $itpsa1, 2) }}
                                        </div>
                                        <small class="text-xl ">รอการเบิกจ่าย<p>
                                            แบบมี PA
                                        </small>

                                    </button>
                                </div>




                                <div class="card-body">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold  text-danger">
                                            <!--การเบิกจ่าย PA -->
                                            {{ number_format($isa - $itpsa2, 2) }}
                                        </div>
                                        <div>
                                            <small class="text-xl ">รอการเบิกจ่าย<p>
                                                แบบมีไม่ PA
                                            </small>
                                        </div>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold   btn btn-warning">
                                        <!--รวมเบิกจ่ายทั้งหมด-->
                                        {{ number_format($itpsa1 + $itpsa2, 2) }}

                                    </div>
                                    <div>
                                        <small class="text-xl">เบิกจ่ายแล้วทั้งหมด<p>
                                            &nbsp;
                                        </small>
                                    </div>
                                </button>
                            </div>
                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                <div class="card-body">

                                    <button class="btn " data-bs-toggle="collapse" style="width: 12rem;"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold  text-warning">
                                            {{ number_format($itpsa1, 2) }}
                                        </div>
                                        <div>
                                            <small class="text-xl ">การเบิกเงิน <p>แบบมี PA
                                            </small>
                                        </div>
                                    </button>
                                </div>
                                <div class="card-body">

                                    <button class="btn "style="width: 12rem;" data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold text-warning">
                                            <!--จำนวนเงินแบบไม่มี PA-->{{ number_format($itpsa2, 2) }}
                                        </div>
                                        <div>
                                            <small class="text-xl">การเบิกเงิน <p>แบบไม่มี PA
                                            </small>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-success">
                                    {{--    {{ number_format(floatval($is_refund_mm_pr), 2) }} --}}
                                    {{ number_format(floatval( $budget['budget_total_task_budget_end']), 2) }}
                                    </div>
                                    <div>
                                        <small class="text-xl">
                                            งบประมาณคงเหลือที่ไช้ได้<p>
                                                &nbsp;
                                        </small>
                                    </div>
                                </button>
                            </div>
                           {{--  <div class="collapse" id="multiCollapseExample1">
                                <div class="card-body">

                                    <button class="col-md-12 btn " style="color:   #06268e"
                                        data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
                                        aria-expanded="false" aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold">

                                        </div>
                                        <div>
                                            <small class="text-xl"> วงเงินที่ขออนุมัติ <p>แบบมี PR
                                            </small>
                                        </div>
                                    </button>
                                </div>
                                <div class="card-body">

                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold">

                                        </div>
                                        <div>
                                            <small class="text-xl">วงเงินที่ขออนุมัติ <p>แบบไม่มีPR
                                            </small>
                                        </div>
                                    </button>
                                </div>
                             {{--    <div class="card">
                                    <div class="card-body">
                                        <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                        <button class="btn "style="width: 12rem;" data-bs-toggle="collapse"
                                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample1">
                                            <div class="fs-4 fw-semibold btn btn-light">
                                                <!--ยอดงบประมาณคงเหลือทั้งหมด สาธารณูปโภค-->

                                                {{ number_format($project['budget_gov_utility'] - ($ut_budget_sum + $ut_budget_sum_no), 2) }}

                                            </div>
                                            <div>
                                                <small class="text-xl">1.3 งบประมาณทั้งหมด คงเหลือ</small>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <div class="col-1">
                        <div class="card-1 ">

                                <button class="btn btn-info"
                                type="button"
                                data-bs-toggle="collapse" data-bs-target=".multi-collapse"
                                 aria-expanded="true"
                                 aria-controls="multiCollapseExample
                                 multiCollapseExample1 multiCollapseExample2
                                 multiCollapseExample3">
                                 <i class="cil-plus"></i>

                               </button>





                        </div>

                    </div>

                    <div class="d-none col ">
                        <div class="card ">
                            <div class="card-body ">
                                <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold ">
                                        <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                        {{ number_format($project['budget_it_investment'] - ($ispa + $isa), 2) }}
                                    </div>
                                    <div>
                                        <small class="text-xl">5. กรอบงบประมาณคงเหลือ ที่เบิกจ่าย<p>
                                            &nbsp;
                                        </small>
                                    </div>
                                </button>
                            </div>
                        </div>


                 {{--        <div class="card">
                            <div class="card-body">
                                <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                <button class="btn "style="width: 12rem;" data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-info">
                                        <!--ยอดงบประมาณคงเหลือทั้งหมด สาธารณูปโภค-->

                                        {{ number_format($project['budget_it_investment'], 2) }}

                                    </div>
                                    <div>
                                        <small class="text-xl">5. กรอบงบประมาณคงเหลือ ที่เบิกจ่าย</small>
                                    </div>
                                </button>
                            </div>
                        </div> --}}
                    </div>


                </div>
            </div>
            <!-- end3 งาน -->
        </div>

        <!-- 4 งาน -->
        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
            <!-- ------------------------- -->
            <!-- 4 งาน -->
            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                aria-labelledby="v-pills-home-tab">



                <div class="row callout callout-primary d-none">
                    <div class="col">
                        <!--งบประมาณ-->
                        <div class="card">
                            <div class="card-body">

                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold">
                                        {{ number_format($project['budget_gov_utility']) }}
                                    </div>

                                    <small class="text-xl">
                                        งบประมาณ <p>ที่ได้รับการจัดสรร<p>
                                    </small>
                                </button>


                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <!--งบประมาณ-->
                        <div class="card">
                            <div class="card-body">

                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold">
                                        {{ number_format($ut_budget_sum + $ut_budget_sum_no, 2) }}
                                      {{--   {{ number_format($tasks->task_mm_budget, 2) }} --}}
                                    </div>

                                    <small class="text-xl">
                                        1.วงเงินที่ขออนุมัติ MM
                                    </small>
                                </button>


                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">

                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold">
                                        {{ number_format($ut_budget_sum + $ut_budget_sum_no, 2) }}
                                    </div>

                                    <small class="text-xl">
                                        1.1 วงเงินที่ขออนุมัติ PR
                                    </small>
                                </button>


                            </div>
                        </div>



                    </div>

                    <div class="col">
                        <!--รอเบิก-->
                        <div class="card">
                            <div class="card-body">

                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold text-warning">
                                        {{ number_format($budget['cost'], 2) }}
                                    </div>

                                    <small class="text-xl">
                                        2. (เบิกจ่าย)ใช้งบประมาณ PA
                                    </small>
                                </button>


                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <!--คงเหลือ-->
                        <div class="card  ">
                            <div class="card-body">
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">

                                    <div class="fs-4 fw-semibold text-info">
                                        {{ number_format($budget['pay'], 2) }}
                                    </div>

                                    <small class="text-xl">3.เบิก PP</small>
                                </button>

                            </div>
                        </div>
                    </div>



        <div class="row">

             <div class="col callout callout-danger">


             <div class="row">
                <div class="col">

                    <!--คงเหลือ-->
                    คำนวน 4
                    <div class="card  ">
                        <div class="card-body">
                            <button class="col-md-12 btn " data-bs-toggle="collapse"
                                href="#multiCollapseExample1" role="button" aria-expanded="false"
                                aria-controls="multiCollapseExample1">
                                @php
                                    $tmp_class_bal = $budget['balance'] > 1000000 ? 'success' : 'danger';
                                @endphp

                                <div class="fs-4 fw-semibold text-dark">
                                    {{ number_format($project['budget_gov_utility'] - ($ut_budget_sum + $ut_budget_sum_no), 2) }}
                                </div>

                                <small class="text-xl">4.กรอบงบประมาณคงเหลือ &nbsp; (0 - 1)</small>
                            </button>

                        </div>

                        <div class="card-body">
                            <button class="col-md-12 btn " data-bs-toggle="collapse"
                                href="#multiCollapseExample1" role="button" aria-expanded="false"
                                aria-controls="multiCollapseExample1">
                                {{--  @php
                                $tmp_class_bal = $budget['balance'] > 1000000 ? 'success' : 'danger';
                            @endphp --}}

                                <div class="fs-4 fw-semibold text-success">
                                    {{ number_format($project['budget_gov_utility'] - $budget['cost'], 2) }}
                                </div>

                                <small class="text-xl">4.1 กรอบงบประมาณคงเหลือ &nbsp;(0 - 2)</small>
                            </button>
                        </div>

                     <div class="card-body">
                            <button class="col-md-12 btn " data-bs-toggle="collapse"
                                href="#multiCollapseExample1" role="button" aria-expanded="false"
                                aria-controls="multiCollapseExample1">


                                <div class="fs-4 fw-semibold text-success">
                                    {{ number_format($project['budget_gov_utility'] - ($ut_budget_sum + $ut_budget_sum_no) + ($ut_budget_sum + $ut_budget_sum_no) -$budget['cost'], 2) }}
                                </div>

                                <small class="text-xl">4.2 กรอบงบประมาณคงเหลือ &nbsp;(0-(2+5)) </small>
                            </button>
                        </div>


                    </div>


                </div>
                <div class="col">

                    <!--คงเหลือ-->
                    คำนวน 5
                    <div class="card  ">
                        <div class="card-body">
                            <button class="col-md-12 btn " data-bs-toggle="collapse"
                                href="#multiCollapseExample1" role="button" aria-expanded="false"
                                aria-controls="multiCollapseExample1">
                                @php
                                    $tmp_class_bal = $budget['balance'] > 1000000 ? 'success' : 'danger';
                                @endphp

                                <div class="fs-4 fw-semibold text-danger">
                                    {{ number_format(($ut_budget_sum + $ut_budget_sum_no) -$budget['cost'] , 2) }}
                                </div>

                                <small class="text-xl">5. &nbsp; (1.1 - 2)</small>
                            </button>

                        </div>
                        <div class="card-body">
                            <button class="col-md-12 btn " data-bs-toggle="collapse"
                                href="#multiCollapseExample1" role="button" aria-expanded="false"
                                aria-controls="multiCollapseExample1">
                                {{--  @php
                                $tmp_class_bal = $budget['balance'] > 1000000 ? 'success' : 'danger';
                            @endphp --}}

                                <div class="fs-4 fw-semibold text-success">
                                    {{ number_format(floatval($budget['budget_total_mm_pr']), 2) }}
                                </div>

                                <small class="text-xl">mm/pr - pa  &nbsp;</small>
                            </button>
                        </div>
                        <div class="card-body">
                            <button class="col-md-12 btn " data-bs-toggle="collapse"
                                href="#multiCollapseExample1" role="button" aria-expanded="false"
                                aria-controls="multiCollapseExample1">
                                {{--  @php
                                $tmp_class_bal = $budget['balance'] > 1000000 ? 'success' : 'danger';
                            @endphp --}}

                                <div class="fs-4 fw-semibold text-pay">

                                </div>

                                <small class="text-xl">5.3  &nbsp;</small>
                            </button>
                        </div>




                    </div>
                </div>




                <div class="col">

                <!--คงเหลือ-->
                คำนวน 6
                <div class="card  ">
                    <div class="card-body">
                        <button class="col-md-12 btn " data-bs-toggle="collapse"
                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                            aria-controls="multiCollapseExample1">
                            @php
                                $tmp_class_bal = $budget['balance'] > 1000000 ? 'success' : 'danger';
                            @endphp

                            <div class="fs-4 fw-semibold text-pay">
                                {{ number_format($budget['cost'] - $budget['pay'], 2) }}
                            </div>

                            <small class="text-xl">6. รอการเบิก &nbsp; (2 - 3)</small>
                        </button>

                    </div>
                    <div class="card-body">
                        <button class="col-md-12 btn " data-bs-toggle="collapse"
                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                            aria-controls="multiCollapseExample1">
                            {{--  @php
                            $tmp_class_bal = $budget['balance'] > 1000000 ? 'success' : 'danger';
                        @endphp --}}

                            <div class="fs-4 fw-semibold text-pay">

                            </div>

                            <small class="text-xl">6.1 ก&nbsp;</small>
                        </button>
                    </div>
                </div>
            </div>


            <div class="col">

                <!--คงเหลือ-->
                คำนวน 7
                <div class="card  ">
                    <div class="card-body">
                        <button class="col-md-12 btn " data-bs-toggle="collapse"
                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                            aria-controls="multiCollapseExample1">
                            @php
                                $tmp_class_bal = $budget['balance'] > 1000000 ? 'success' : 'danger';
                            @endphp

                            <div class="fs-4 fw-semibold text-info">
                                {{ number_format($project['budget_gov_utility'] - ($utsc_pay_pa + $utsc_pay), 2) }}
                            </div>

                            <small class="text-xl">7.กรอบ(เบิก)งบประมาณคงเหลือ &nbsp; (0 - 3)</small>
                        </button>

                    </div>
                    <div class="card-body">
                        <button class="col-md-12 btn " data-bs-toggle="collapse"
                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                            aria-controls="multiCollapseExample1">
                            {{--  @php
                            $tmp_class_bal = $budget['balance'] > 1000000 ? 'success' : 'danger';
                        @endphp --}}

                            <div class="fs-4 fw-semibold text-pay">

                            </div>

                            <small class="text-xl">7.1 กรอบงบประมาณคงเหลือ &nbsp;()</small>
                        </button>
                    </div>
                </div>
            </div>


            </div>
                </div>
         </div>
    </div>
                <div>
                    <div class="row">

                    <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold btn btn-transparent ">
                                            {{ number_format($project['budget_gov_utility'], 2) }}

                                        </div>
                                        <div>
                                            <small class="text-xl">
                                                งบประมาณ <p>ที่ได้รับการจัดสรร<p>
                                            </small>
                                        </div>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="col d-none">
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn "style="width: 12rem;" data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold">
                                            {{ number_format(($ut_budget_sum + $ut_budget_sum_no), 2) }}
                                        </div>
                                        <div>
                                            <small class="text-xl">
                                               วงเงินที่ขออนุมัติ MM/PR
                                            </small>
                                        </div>
                                    </button>
                                </div>
                                <div class="collapse multi-collapse" id="multiCollapseExample1">
                                    <div class="card-body">

                                        <button class="col-md-12 btn " style="color:   #06268e"
                                            data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
                                            aria-expanded="false" aria-controls="multiCollapseExample1">
                                            <div class="fs-4 fw-semibold">
                                                {{ number_format($ut_budget_sum, 2) }}
                                            </div>
                                            <div>
                                                <small class="text-xl"> วงเงินที่ขออนุมัติ <p>แบบมี PR
                                                </small>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="card-body">

                                        <button class="col-md-12 btn " data-bs-toggle="collapse"
                                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample1">
                                            <div class="fs-4 fw-semibold">
                                                <!--จำนวนเงินแบบไม่มี PA-->{{ number_format($ut_budget_sum_no, 2) }}
                                            </div>
                                            <div>
                                                <small class="text-xl"> วงเงินที่ขออนุมัติ <p>แบบไม่มีPR
                                                </small>
                                            </div>
                                        </button>
                                    </div>
                                 {{--    <div class="card">
                                        <div class="card-body">
                                            <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                            <button class="btn "style="width: 12rem;" data-bs-toggle="collapse"
                                                href="#multiCollapseExample1" role="button" aria-expanded="false"
                                                aria-controls="multiCollapseExample1">
                                                <div class="fs-4 fw-semibold btn btn-light">
                                                    <!--ยอดงบประมาณคงเหลือทั้งหมด สาธารณูปโภค-->

                                                    {{ number_format($project['budget_gov_utility'] - ($ut_budget_sum + $ut_budget_sum_no), 2) }}

                                                </div>
                                                <div>
                                                    <small class="text-xl">1.3 งบประมาณทั้งหมด คงเหลือ</small>
                                                </div>
                                            </button>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>






                        <div class="col">
                            <div class="card">

                                <div class="card-body ">
                                    <!--รอการเบิกจ่ายทั้งหมด 2-->
                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold btn btn-info">
                                            <!--รอการเบิกจ่ายทั้งหมด-->
                                            {{ number_format($utpcs + $utsc, 2) }}
                                        </div>
                                        <div>
                                            <small class="text-xl">วงเงินที่ใช้จริง <p>(รวมแบบมี PA และไม่มี PA)</small>
                                        </div>
                                    </button>
                                </div>
                                <div class="collapse multi-collapse" id="multiCollapseExample1">
                                    <div class="card-body">

                                        <button class="col-md-12 btn " data-bs-toggle="collapse"
                                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample1">
                                            <div class="fs-4 fw-semibold text-info">
                                                <!--การเบิกจ่าย PA -->
                                                {{ number_format($utpcs, 2) }}
                                            </div>
                                            <small class="text-xl">วงเงินที่ใช้จริง <p>รวมแบบมี
                                                PA</small>

                                        </button>
                                    </div>
                                    <div class="card-body">

                                        <button class="col-md-12 btn " data-bs-toggle="collapse"
                                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample1">
                                            <div class="fs-4 fw-semibold text-info">
                                                <!--การเบิกจ่าย ไม่แบบ PA -->
                                                {{ number_format($utsc , 2) }}
                                            </div>
                                            <div>
                                                <small class="text-xl"> วงเงินที่ใช้จริง <p>ไม่แบบ
                                                    PA</small>
                                            </div>

                                        </button>
                                    </div>


                                </div>
                            </div>
                        </div>






                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <!--รอการเบิกจ่ายทั้งหมด 2-->
                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold btn btn-danger">
                                            <!--รอการเบิกจ่ายทั้งหมด-->
                                            {{ number_format($utpcs - $utsc_pay_pa + ($utsc - $utsc_pay), 2) }}
                                        </div>
                                        <div>
                                            <small class="text-xl">รอการเบิกจ่ายทั้งหมด<p>
                                                &nbsp;</small>
                                        </div>
                                    </button>
                                </div>
                                <div class="collapse multi-collapse" id="multiCollapseExample1">
                                    <div class="card-body">

                                        <button class="col-md-12 btn " data-bs-toggle="collapse"
                                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample1">
                                            <div class="fs-4 fw-semibold text-danger">
                                                <!--การเบิกจ่าย PA -->
                                                {{ number_format($utpcs - $utsc_pay_pa, 2) }}
                                            </div>
                                            <small class="text-xl">รอการเบิกจ่าย <p>แบบมี
                                                PA </small>

                                        </button>
                                    </div>
                                    <div class="card-body">

                                        <button class="col-md-12 btn " data-bs-toggle="collapse"
                                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample1">
                                            <div class="fs-4 fw-semibold text-danger">
                                                <!--การเบิกจ่าย ไม่แบบ PA -->
                                                {{ number_format($utsc - $utsc_pay, 2) }}
                                            </div>
                                            <div>
                                                <small class="text-xl">  รอการเบิกจ่าย <p>ไม่แบบ
                                                    PA</small>
                                            </div>

                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>




                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <button class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold btn btn-warning">
                                            <!--รวมเบิกจ่ายทั้งหมด-->
                                            {{ number_format($utsc_pay_pa + $utsc_pay, 2) }}

                                        </div>
                                        <div>
                                            <small class="text-xl">
                                                เบิกจ่ายแล้วทั้งหมด<p>
                                                    &nbsp;</small>
                                        </div>
                                    </button>
                                </div>
                                <div class="collapse multi-collapse" id="multiCollapseExample1">
                                    <div class="card-body">

                                        <button class="col-md-12 btn " data-bs-toggle="collapse"
                                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample1">
                                            <div class="fs-4 fw-semibold text-warning">
                                                {{ number_format($utsc_pay_pa, 2) }}
                                            </div>
                                            <small class="text-xl"> จำนวนเงิน <p>แบบมี PA
                                            </small>
                                        </button>
                                    </div>
                                    <div class="card-body">

                                        <button class="btn "style="width: 12rem;" data-bs-toggle="collapse"
                                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample1">
                                            <div class="fs-4 fw-semibold text-warning">
                                                <!--จำนวนเงินแบบไม่มี PA-->{{ number_format($utsc_pay, 2) }}
                                            </div>
                                            <div>
                                                <small class="text-xl"> จำนวนเงิน <p>แบบไม่มี
                                                    PA
                                                </small>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                      {{--   <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                    <button class="btn "style="width: 12rem;" data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold">
                                            <!--ยอดงบประมาณคงเหลือทั้งหมด สาธารณูปโภค-->
                                            {{ number_format($project['budget_gov_utility'] - ($utsc_pay_pa + $utsc_pay), 2) }}

                                     {{--        @if(number_format($ut_budget_sum + $ut_budget_sum_no, 2) == 0)

                                           mm {{ number_format($project['budget_gov_utility'] -($ut_budget_sum + $ut_budget_sum_no), 2) }}


                                            @elseif(number_format($ut_budget_sum + $ut_budget_sum_no, 2) < number_format($utpcs + $utsc, 2))
                                          mm- pr {{ number_format($project['budget_gov_utility']- (($ut_budget_sum + $ut_budget_sum_no)+($utpcs + $utsc) ), 2)     }}


                                       @elseif(number_format($ut_budget_sum + $ut_budget_sum_no, 2) == number_format($utpcs + $utsc, 2))
                                          pr {{ number_format($utpcs + $utsc, 2) }}
                                        @endif --}}

                                       {{--  {{ number_format( ($ut_budget_sum + $ut_budget_sum_no) - ($utpcs + $utsc)    , 2) }} --}}
    {{--                   {{ number_format($project['budget_gov_utility'] - ($ut_budget_sum + $ut_budget_sum_no), 2) }} --}}
  {{--   $project['budget_gov_utility'] - ($ut_budget_sum + $ut_budget_sum_no) --}}


                               {{--  <p>   2.  0-1  <p> {{ number_format(($project['budget_gov_utility']-$budget['budget_total_mm'] ), 2) }}
                                <p>  3. (0-1)+ <p> {{ number_format($project['budget_gov_utility']-(($utsc_mm_pa+$utsc_mm)- (($ut_budget_sum + $ut_budget_sum_no) -$budget['cost'])  ), 2) }}


                                    <p>   4. mm <p> {{ number_format($budget['budget_total_mm'] , 2) }}





                                    <p>  5. (0-1)+ <p> {{ number_format($project['budget_gov_utility'], 2) }}
                                        <p>  6. (0-1)+ <p> {{ number_format(($utsc_mm_pa+$utsc_mm) , 2) }}
                                            <p>  7. (0-1)+ <p> {{ number_format((($ut_budget_sum + $ut_budget_sum_no) -$budget['cost']), 2) }}
                                                <p>  8. (0-1)+ <p> {{ number_format(($budget['cost']), 2) }}
                                    <p>   9.  <p>{{ number_format($project['budget_gov_utility'] - ($utpcs + $utsc), 2) }} --}}
                                      {{-- $utpcs - $utsc_pay_pa + ($utsc - $utsc_pay)  --}}

                             {{--            </div>
                                        <div>
                                            <small class="text-xl">5. กรอบงบประมาณคงเหลือ ที่เบิกจ่าย</small>
                                        </div>
                                    </button>
                                </div>
                            </div> --}}
{{--
                            <div class="card">
                                <div class="card-body">
                                    <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                    <button class="btn "style="width: 12rem;" data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold btn btn-info">
                                            <!--ยอดงบประมาณคงเหลือทั้งหมด สาธารณูปโภค-->

                                            {{ number_format($utpcs - $utsc_pay_pa, 2) }}

                                        </div>
                                        <div>
                                            <small class="text-xl">เบิกจ่ายงบประมาณแล้ว</small>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn "class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold btn btn-success">
                                           {{--  {{ number_format(floatval($ut_refund_mm_pr), 2) }} --}}

                                            {{ number_format(floatval( $budget['budget_total_task_budget_end']), 2) }}
                                        </div>
                                        <div>
                                            <small class="text-xl">
                                                งบประมาณคงเหลือที่ไช้ได้<p>
                                                    &nbsp;
                                            </small>
                                        </div>
                                    </button>
                                </div>
                              {{--   <div class="collapse" id="multiCollapseExample1">
                                    <div class="card-body">

                                        <button class="col-md-12 btn " style="color:   #06268e"
                                            data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
                                            aria-expanded="false" aria-controls="multiCollapseExample1">
                                            <div class="fs-4 fw-semibold">

                                            </div>
                                            <div>
                                                <small class="text-xl">วงเงินที่ขออนุมัติ <p>แบบมี PR
                                                </small>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="card-body">

                                        <button class="col-md-12 btn " data-bs-toggle="collapse"
                                            href="#multiCollapseExample1" role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample1">
                                            <div class="fs-4 fw-semibold">

                                            </div>
                                            <div>
                                                <small class="text-xl">วงเงินที่ขออนุมัติ <p>แบบไม่มีPR
                                                </small>
                                            </div>
                                        </button>
                                    </div>
                                 {{--    <div class="card">
                                        <div class="card-body">
                                            <!--ยอดงบประมาณคงเหลือทั้งหมด-->
                                            <button class="btn "style="width: 12rem;" data-bs-toggle="collapse"
                                                href="#multiCollapseExample1" role="button" aria-expanded="false"
                                                aria-controls="multiCollapseExample1">
                                                <div class="fs-4 fw-semibold btn btn-light">
                                                    <!--ยอดงบประมาณคงเหลือทั้งหมด สาธารณูปโภค-->

                                                    {{ number_format($project['budget_gov_utility'] - ($ut_budget_sum + $ut_budget_sum_no), 2) }}

                                                </div>
                                                <div>
                                                    <small class="text-xl">1.3 งบประมาณทั้งหมด คงเหลือ</small>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        <div class="col-1">
                            <div class="card-1 ">

                                    <button class="btn btn-info"
                                    type="button"
                                    data-bs-toggle="collapse" data-bs-target=".multi-collapse"
                                     aria-expanded="true"
                                     aria-controls="multiCollapseExample
                                     multiCollapseExample1 multiCollapseExample2
                                     multiCollapseExample3">
                                     <i class="cil-plus"></i>

                                   </button>





                            </div>

                        </div>






                    </div>
                </div>
            </div>
            <!-- ------------------------- -->
        </div>
        <!-- nav end -->
    </div>
</div>
