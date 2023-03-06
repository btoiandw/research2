@extends('layouts.admin.admin')
@section('content')
    <div class="row mb-3 mt-3">
        <div class="col-xl-12">
            <div class="bg-white rounded shadow-xl m-dash p-2">
                <div class="d-flex justify-content-between">
                    <h3>จัดการแอดมิน</h3>
                    <div class=" d-flex g-2 justify-content-end ">
                        <button class="btn btn-primary btn-sm" type="button">
                            <i class="fa-solid fa-plus"></i> เพิ่มแอดมิน
                        </button>
                    </div>
                </div>

                <div class="table-responsive pt-3">
                    <table class="table fw-bold w-100" id="admin_table">
                        <thead class="table-dark table-hover table align-middle">
                            <tr align="center">
                                <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                                <th class="fw-bolder" style="font-size: 15px">ชื่อ-สกุล</th>
                                <th class="fw-bolder" style="font-size: 15px">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data_u as $item)
                                <tr>
                                    <td align="center">{{ $i++ }}</td>
                                    <td>{{ $item->full_name_th }}</td>
                                    <td align="center">
                                        <button class="btn btn-sm btn-yellow">แก้ไข</button>
                                        <button class="btn btn-sm btn-danger">
                                            ยกเลิก
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
   {{--  <div class="row mb-3 mt-3">
        <div class="col-xl-12">
            <div class="bg-white rounded shadow-xl m-dash p-2">
                <h3>จัดการผู้ทรงคุณวุฒิ</h3>
                <div class="table-responsive">
                    <table class="table fw-bold w-100" id="director_table">
                        <thead class="table-dark table-hover table align-middle">
                            <tr align="center">
                                <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                                <th class="fw-bolder" style="font-size: 15px">ชื่อ-สกุล</th>
                                <th class="fw-bolder" style="font-size: 15px">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data_d as $items)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $items->full_name_th }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-yellow">แก้ไข</button>
                                        <button class="btn btn-sm btn-danger">
                                            ยกเลิก
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
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
            $('#admin_table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,

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

            $('#director_table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,

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
