@extends('layouts.UD.ud')
@section('content')
    <div class=" container-fluid mt-3">
        <div class=" d-flex justify-content-end align-content-end">
            <button class=" btn btn-primary ">
                เพิ่มโครงร่าง
            </button>
        </div>
        <div class="row mb-3 mt-3">
            <div class="col-xl-12">
                <div class="bg-white rounded shadow-xl m-dash p-2">
                    <div class="table-responsive">
                        <table class="table fw-bold w-100" id="research_table">
                            <thead class="table-dark table-hover table align-middle">
                                <tr align="center">
                                    <th class="fw-bolder">ลำดับ</th>
                                    <th class="fw-bolder">ชื่อโครงร่างงานวิจัยภาษาไทย</th>
                                    <th class="fw-bolder text-wrap">ชื่อโครงร่างงานวิจัยภาษาอังกฤษ</th>
                                    <th class="fw-bolder">รายละเอียด</th>
                                    <th class="fw-bolder">สถานะ</th>
                                    <th class="fw-bolder">จัดการ</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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

        });
    </script>
@endpush
