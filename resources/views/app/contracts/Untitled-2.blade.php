<!-- Button trigger modal -->
<button type="button" class="btn btn-success text-white"
    data-coreui-toggle="modal"

    data-coreui-target="#exampleModal{{ $contract->hashid }}">
   สญ.ที่ {{ $contract->contract_number }}

</button>

<!-- Modal -->
<div class="modal fade"
    id="exampleModal{{ $contract->hashid }}"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="exampleModalLabel">
                    สัญญา
                    {{ $contract->contract_number }}
                </h5>
                <button type="button"
                    class="btn-close"
                    data-coreui-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">


                {{--  --}}
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <div
                                class="row">
                                <div
                                    class="col-3">
                                    {{ __('สถานะสัญญา') }}
                                </div>
                                <div
                                    class="col-9">
                                    <?php
                                    echo isset($contract) && $contract->contract_status == 2 ? '<span style="color:red;">ดำเนินการแล้วเสร็จ</span>' : '<span style="color:green;">อยู่ในระหว่างดำเนินการ</span>';
                                    ?>
                                </div>
                            </div>
                            <div
                                class="row">
                                <div
                                    class="col-3">
                                    {{ __('เลขที่ สัญญา') }}
                                </div>
                                <div
                                    class="col-9">
                                    {{ $contract->contract_number }}
                                </div>
                            </div>
                            <div
                                class="row">
                                <div
                                    class="col-3">
                                    {{ __('เลขที่ คู่ค้า') }}
                                </div>
                                <div
                                    class="col-9">
                                    {{ $contract->contract_juristic_id }}
                                </div>
                            </div>
                            <div
                                class="row">
                                <div
                                    class="col-3">
                                    {{ __('เลขที่สั่งซื้อ') }}
                                </div>
                                <div
                                    class="col-9">
                                    {{ $contract->contract_order_no }}
                                </div>
                            </div>
                            <div
                                class="row">
                                <div
                                    class="col-3">
                                    {{ __('ประเภท') }}
                                </div>
                                <div
                                    class="col-9">
                                    {{ \Helper::contractType($contract->contract_type) }}
                                </div>
                            </div>
                            {{-- <div class="row">
<div class="col-3">{{ __('วิธีการได้มา') }}</div>
<div class="col-9">
{{ \Helper::contractAcquisition($contract->contract_acquisition) }}
</div>
</div> --}}
                            <div
                                class="row">
                                <div
                                    class="col-3">
                                    {{ __('วันที่เริ่มสัญญา') }}
                                </div>
                                <div
                                    class="col-9">
                                    {{ Helper::Date4(date('Y-m-d H:i:s', $contract->contract_start_date)) }}
                                </div>
                            </div>

                            <div
                                class="row">
                                <div
                                    class="col-3">
                                    {{ __('วันที่สิ้นสุดสัญญา') }}
                                </div>
                                <div
                                    class="col-9">
                                    {{ Helper::Date4(date('Y-m-d H:i:s', $contract->contract_end_date)) }}
                                </div>
                            </div>
                            <div
                                class="row">
                                <div
                                    class="col-3">
                                    {{ __('จำนวนเดือน') }}
                                </div>
                                <div
                                    class="col-3">
                                    {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse($contract->contract_end_date)) }}
                                    เดือน</div>
                                <div
                                    class="col-3">
                                    {{ __('จำนวนวัน') }}
                                </div>
                                <div
                                    class="col-3">
                                    {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse($contract->contract_end_date)) }}
                                    วัน</div>
                            </div>
                            <div
                                class="row">
                                <div
                                    class="col-3">
                                    {{ __('ดำเนินการมาแล้ว') }}
                                </div>
                                <div
                                    class="col-3">
                                    {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInMonths(\Carbon\Carbon::parse()) }}
                                    เดือน</div>
                                <div
                                    class="col-3">
                                    {{ __('ดำเนินการมาแล้ว') }}
                                </div>
                                <div
                                    class="col-3">
                                    {{ \Carbon\Carbon::parse($contract->contract_start_date)->diffInDays(\Carbon\Carbon::parse()) }}
                                    วัน</div>
                            </div>

                            {{--   <div class="row">
<div class="col-3">{{ __('เตือน เหลือเวลา') }}</div>
<div class="col-9">
<?php
echo isset($duration_p) && $duration_p < 3 ? '<span style="color:red;">' . $duration_p . '</span>' : '<span style="color:rgb(5, 255, 5);">' . $duration_p . '</span>';
?> เดือน


</div>
</div> --}}


                        </div>
                        <div class="col-sm">
                            <div
                                class="row">
                                <div
                                    class="col-6">
                                    {{ __('หมายเหตุ') }}
                                </div>
                                <div
                                    class="col-6">
                                    {{ $contract->contract_projectplan }}
                                </div>
                            </div>
                            <div
                                class="row">
                                <div
                                    class="col-6">
                                    {{ __('เลขที่ MM') }}
                                </div>
                                <div
                                    class="col-6">
                                    {{ $contract->contract_mm }}
                                </div>
                            </div>
                            <div
                                class="row">
                                <div
                                    class="col-6">
                                    {{ __('จำนวนเงิน MM') }}
                                </div>
                                <div
                                    class="col-6">
                                    {{ $contract->contract_mm_bodget }}
                                </div>
                            </div>

                            <div
                                class="row">
                                <div
                                    class="col-6">
                                    {{ __('เลขที่ PR') }}
                                </div>
                                <div
                                    class="col-6">
                                    {{ $contract->contract_pr }}
                                </div>
                            </div>
                            <div
                                class="row">
                                <div
                                    class="col-6">
                                    {{ __('จำนวนเงิน PR') }}
                                </div>
                                <div
                                    class="col-6">
                                    {{ number_format($contract->contract_pr_budget) }}
                                </div>
                            </div>
                            <div
                                class="row">
                                <div
                                    class="col-6">
                                    {{ __('เลขที่ PA') }}
                                </div>
                                <div
                                    class="col-6">
                                    {{ $contract->contract_pa }}
                                </div>
                            </div>
                            <div
                                class="row">
                                <div
                                    class="col-6">
                                    {{ __('จำนวนเงิน PA') }}
                                </div>
                                <div
                                    class="col-6">
                                    {{ number_format($contract->contract_pa_budget) }}
                                </div>
                            </div>
                            <div
                                class="row">
                                <div
                                    class="col-6">
                                    {{ __('จำนวนคงเหลือหลังเงิน PA') }}
                                </div>
                                <div
                                    class="col-6">
                                    {{ number_format($contract->contract_pr_budget - $contract->contract_pa_budget) }}
                                </div>
                            </div>

                            <div
                                class="row">
                                <div
                                    class="col-6">
                                    {{ __('จำนวนเงิน ที่ใช้จ่ายต่อปี') }}
                                </div>
                                <div
                                    class="col-6">
                                    {{ number_format($contract->contract_peryear_pa_budget) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--  --}}
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-secondary"
                    data-coreui-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
@endforeach
@endif
