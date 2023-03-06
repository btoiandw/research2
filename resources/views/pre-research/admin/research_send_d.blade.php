@extends('layouts.admin.admin')
@section('content')
    <div class="row mb-3 mt-3">
        <div class="col-xl-12">
            <div class="bg-white rounded shadow-xl m-dash p-2">
                <div class="table-responsive pt-3">
                    <table class="table fw-bold w-100" id="admin_table">
                        <thead class="table-dark table-hover table align-middle">
                            <tr align="center">
                                <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                                <th class="fw-bolder" style="font-size: 15px">ชื่อโครงร่างงานวิจัย</th>
                                <th class=" fw-bolder" style="font-size: 15px">กรรมการคนที่ 1</th>
                                <th class=" fw-bolder" style="font-size: 15px">กรรมการคนที่ 2</th>
                                <th class=" fw-bolder" style="font-size: 15px">กรรมการคนที่ 3</th>
                                <th class=" fw-bolder" style="font-size: 15px">สรุปผล</th>

                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            <tr>
                                <td align="center"></td>
                                <td></td>
                                <td align="center">
                                    <button class="btn btn-sm btn-info">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </td>
                                <td align="center">
                                    <button class="btn btn-sm btn-info">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </td>
                                <td align="center">
                                    <button class="btn btn-sm btn-info">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </td>
                                <td align="center">
                                    <button class="btn btn-sm btn-default">สรุปขอ้เสนอแนะ</button>
                                </td>
                            </tr>
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
        })
    </script>
@endpush
