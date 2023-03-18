@extends('layouts.admin.admin')
@section('content')
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-primary me-md-2" type="button" onclick="AddSource()">เพิ่มแหล่งทุน</button>
    </div>
    <div class="row mb-3 mt-3">
        <div class="col-xl-12">
            <div class="bg-white rounded shadow-xl m-dash p-2">
                <div class="table-responsive pt-3">
                    <table class="table fw-bold w-100" id="admin_table">
                        <thead class="table-dark table-hover table align-middle">
                            <tr class=" align-middle">
                                <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                                <th class="fw-bolder" style="font-size: 15px">ชื่อแหล่งทุนงานวิจัย</th>
                                <th class=" fw-bolder" style="font-size: 15px">ประเภทแหล่งทุน</th>
                                <th class=" fw-bolder" style="font-size: 15px">รายละเอียด</th>
                                <th class=" fw-bolder" style="font-size: 15px">ตัวอย่างโครงร่างงานวิจัย</th>
                                <th class=" fw-bolder" style="font-size: 15px">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data_s as $item)
                                <tr>
                                    <td align="center">{{ $i++ }}</td>
                                    <td>{{ $item->research_source_name }}</td>
                                    <td align="center">{{ $item->type_research_source }}</td>
                                    <td align="center">
                                        <button class="btn btn-sm btn-info">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                    <td align="center">{{ $item->ex_research }}</td>
                                    <td align="center">
                                        <div class="d-grid gap-2 d-md-flex">
                                            <button class="btn btn-yellow me-md-2 btn-sm" type="button">แก้ไข</button>
                                            <button class="btn btn-danger btn-sm">ยกเลิก</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Source Modal -->
    <div class="modal fade" id="addSource" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addSourceLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addSourceLabel">เพิ่มแหล่งทุน</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <strong class="col-2">ชื่อแหล่งทุน</strong>
                        <div class="col-9">
                            <input type="text" name="name_so" id="name_so" class=" form-control" />
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">ยืนยัน</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
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

        function AddSource() {
            $('#addSource').modal('toggle');
        }
    </script>
@endpush
