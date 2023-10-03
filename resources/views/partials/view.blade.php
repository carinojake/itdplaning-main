

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
            <div class="row">
                <div class="col-md-auto">
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



                        </div>
                    </div>
                </div>



                <div class="col-md-auto">
                    <!--คงเหลือ-->
                    <div class="card  ">
                        <div class="card-body">


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
                                    @if ( $budget['project_type'] == 1)
                                    {{ number_format(floatval( $budget['budget_total_task_budget_end']), 2) }}

                                    {{-- {{ number_format(floatval( $budget['budget_total_task_budget_end']), 2) }} --}}

                                    @elseif( $budget['project_type'] == 2 && $tasks['task_refund_pa_status'] == '3')
                                    {{ number_format(floatval( $budget['budget_total_task_budget_end_p2_mm']), 2) }}

                                    @elseif( $budget['project_type'] == 2)
                                    {{ number_format(floatval( $budget['budget_total_task_budget_end_p2']), 2) }}



                                    @endif
                                </div>
                                <small class="text-xl">
                                    งบประมาณคงเหลือที่ไช้ได้
                                </small>
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!-- end1 งาน -->
        <!-- 2 งาน -->
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

            <div class="col-md-auto">
                <div class="row">
                    <div class="col-md-auto">
                        <div class="card">
                            <div class="card-body">
                                <button class="col-md-12 btn "data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-transparent ">

                                        {{ number_format($project['budget_it_operating'],2) }}
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


                    <div class="col-md-auto">
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
                                        <small class="text-xl ">วงเงินที่ใช้จริง<p>(รวมแบบมี PA และแบบไม่มี PA)</small>
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
                                            <small class="text-xl"> วงเงินที่ใช้จริง <p>แบบไม่มี
                                                PA</small>
                                        </div>

                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>



                    <div class="col-md-auto">
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
                                        <small class="text-xl">รอการเบิกจ่าย <p>แบบไม่มี PA
                                        </small>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-auto">
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

                    <div class="col-md-auto">
                        <div class="card">
                            <div class="card-body">
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-success">
                                        @if ( $budget['project_type'] == 1)
                                        {{-- {{ number_format(floatval( $budget['budget_total_task_budget_end']), 2) }} --}}
                                        {{ number_format(floatval($op_refund_mm_pr), 2) }}
                                        @elseif( $budget['project_type'] == 2)
                                        {{ number_format(floatval( $budget['budget_total_task_budget_end_p2']), 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <small class="text-xl">
                                            งบประมาณคงเหลือที่ไช้ได้<p>
                                                &nbsp;
                                        </small>
                                    </div>
                                </button>
                            </div>


                        </div>

                    </div>

                    <div class="col-md-auto">
                        <div class="card ">
                            <div class="form-check form-switch">
                                <input class="form-check-input "

                                       type="checkbox"
                                       role="switch"
                                       id="flexSwitchCheckDefault"
                                       data-bs-toggle="collapse"
                                       data-bs-target=".multi-collapse"
                                       aria-expanded="true"
                                       aria-controls="multiCollapseExample">
                                <label class="form-check-label" for="flexSwitchCheckDefault">เปิด</label>
                            </div>
                        </div>
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
                    <div class="col-md-auto">
                        <div class="card">
                            <div class="card-body">
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-transparent ">

                                        {{ number_format($project['budget_it_investment'],2) }}
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

                    <div class="col-md-auto">
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
                                        <small class="text-xl">วงเงินที่ใช้จริง <p>(รวมแบบมี PA และแบบไม่มี PA)</small>
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
                                            <small class="text-xl">วงเงินที่ใช้จริง <p>แบบไม่มี
                                                PA</small>
                                        </div>

                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-auto">
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
                                                แบบไม่มี PA
                                            </small>
                                        </div>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-auto">
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

                    <div class="col-md-auto">
                        <div class="card">
                            <div class="card-body">
                                <button class="col-md-12 btn " data-bs-toggle="collapse"
                                    href="#multiCollapseExample1" role="button" aria-expanded="false"
                                    aria-controls="multiCollapseExample1">
                                    <div class="fs-4 fw-semibold btn btn-success">
                                    {{--    {{ number_format(floatval($is_refund_mm_pr), 2) }} --}}
                                 {{--    @if($project['budget_gov_utility'] > 1)
                                    {{ number_format(floatval(($project['budget_it_investment']-(($project['budget_it_investment']-($ispa + $isa))+$itpsa1 + $itpsa2))+$is_refund_mm_pr), 2) }}
                                    @elseif($project['budget_it_investment'] > 0) --}}
                                  {{--  {{ number_format(floatval( $budget['budget_total_task_budget_end']), 2) }} --}}
                         {{--      @endif --}}
                         {{-- {{ number_format(floatval($is_refund_mm_pr), 2) }} --}}
                     {{--     {{ number_format(floatval($budget['budget_it_investment']), 2) }} --}}

                         {{ number_format(floatval($rootsums_investment['totalLeastBudget_sum_investment']-$rootsums_investment['totalLeasttask_mm_budget_investment']), 2) }}

                                    </div>


                                    <div>
                                        <small class="text-xl">
                                            งบประมาณคงเหลือที่ไช้ได้<p>
                                                &nbsp;
                                        </small>
                                    </div>
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-auto">
                        <div class="card">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       role="switch"
                                       id="flexSwitchCheckDefault"
                                       data-bs-toggle="collapse"
                                       data-bs-target=".multi-collapse"
                                       aria-expanded="true"
                                       aria-controls="multiCollapseExample">
                                <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                            </div>
                        </div>
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




                <div>
                    <div class="row">

                    <div class="col-md-auto">
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


                        <div class="col-md-auto">
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
                                            <small class="text-xl">วงเงินที่ใช้จริง <p>(รวมแบบมี PA และแบบไม่มี PA)</small>
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
                                                <small class="text-xl"> วงเงินที่ใช้จริง <p>แบบไม่มี
                                                    PA</small>
                                            </div>

                                        </button>
                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="col-md-auto">
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
                                                <small class="text-xl">  รอการเบิกจ่าย <p>แบบไม่มี
                                                    PA</small>
                                            </div>

                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>




                        <div class="col-md-auto">
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

                        <div class="col-md-auto">
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn "class="col-md-12 btn " data-bs-toggle="collapse"
                                        href="#multiCollapseExample1" role="button" aria-expanded="false"
                                        aria-controls="multiCollapseExample1">
                                        <div class="fs-4 fw-semibold btn btn-success">
                                            {{-- {{ number_format(floatval($ut_refund_mm_pr), 2) }} --}}

{{--
                                          @if($project['budget_it_investment'] > 1)
                                            {{ number_format(floatval(($project['budget_gov_utility']-(($project['budget_gov_utility']-($utpcs + $utsc))+$utsc_pay_pa + $utsc_pay))+$ut_refund_mm_pr), 2) }}
                                            @elseif($project['budget_gov_utility'] > 0) --}}
                                           {{-- {{ number_format(floatval( $budget['budget_total_task_budget_end']), 2) }} --}}
                                   {{--    @endif --}}
                                   {{ number_format(floatval($ut_refund_mm_pr), 2) }}
                                        </div>
                                        <div>
                                            <small class="text-xl">
                                                งบประมาณคงเหลือที่ไช้ได้<p>
                                                    &nbsp;
                                            </small>
                                        </div>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-auto">
                            <div class="card">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           role="switch"
                                           id="flexSwitchCheckDefault"
                                           data-bs-toggle="collapse"
                                           data-bs-target=".multi-collapse"
                                           aria-expanded="true"
                                           aria-controls="multiCollapseExample">
                                    <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                                </div>
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
