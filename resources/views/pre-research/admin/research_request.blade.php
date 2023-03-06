@extends('layouts.admin.admin')
@section('content')

    <div class="row mb-3 mt-3">
        <div class="col-xl-12">
            <div class="bg-white rounded shadow-xl m-dash p-2">
                <div class="table-responsive">
                    <table class="table fw-bold w-100" id="research_table">
                        <thead class="table-dark table-hover table align-middle">
                            <tr align="center">
                                <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                                <th class="fw-bolder" style="font-size: 15px">ชื่อโครงร่างงานวิจัยภาษาไทย</th>
                                <th class="fw-bolder" style="font-size: 15px">รายละเอียด</th>
                                <th class="fw-bolder" style="font-size: 15px">สถานะ</th>
                                <th class="fw-bolder" style="font-size: 15px">สรุปผล/ข้อเสนอแนะ</th>
                                <th class="fw-bolder" style="font-size: 15px">เพิ่มกรรมการ</th>
                                <th class="fw-bolder" style="font-size: 15px">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data_re as $item)
                                <tr>
                                    <td align="center">{{ $i++ }}</td>
                                    <td>{{ $item->research_th }}</td>
                                    <td align="center">
                                        <button class=" btn btn-info btn-sm">รายละเอียด</button>
                                    </td>
                                    <td align="center">
                                        @if ($item->research_status == 0)
                                            <button class="btn btn-yellow disabled btn-sm">
                                                รอตรวจสอบ
                                            </button>
                                        @else
                                        @endif
                                    </td>
                                    <td align="center">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa-solid fa-plus"></i><span>ข้อเสนอแนะ</span>
                                        </button>
                                    </td>
                                    <td align="center">
                                        <button class="btn btn-default btn-sm">
                                            <i class="fa-solid fa-user-plus"></i>
                                        </button>
                                    </td>
                                    <td align="center">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-xmark"></i><span>ยกเลิก</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#research_table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 3
                    },
                    {
                        responsivePriority: 3,
                        targets: 5
                    },
                ],
                lengthMenu: [10, 20, 50, 100, ],
                language: {
                    lengthMenu: "แสดง _MENU_ รายการ",
                    search: "ค้นหาข้อมูลในตาราง",
                    info: "แสดงข้อมูล _END_ จากทั้งหมด _TOTAL_ รายการ",
                    paginate: {
                        previous: "ก่อนหน้า",
                        next: "ถัดไป",

                    },
                },

            });
        })
    </script>
@endpush
