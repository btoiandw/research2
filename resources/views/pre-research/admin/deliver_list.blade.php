@extends('layouts.admin.admin')
@section('content')
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button class="btn btn-primary me-md-2" type="button" onclick="addModal()">เพิ่มรายการส่งมอบ</button>
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
                                <th class=" fw-bolder" style="font-size: 15px">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data_de as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button class="btn btn-yellow btn-sm me-2">แก้ไข</button>
                                        <button class="btn btn-danger btn-sm">ยกเลิก</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--Add Modal -->
    <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">เพิ่มรายการส่งมอบ</h1>
                    <button type="button" class="btn-close" {{-- data-bs-dismiss="modal"  --}}aria-label="Close"
                        onclick="location.reload()"></button>
                </div>
                <form action="{{ route('admin.deliver-store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <strong class=" col-sm-3">แหล่งทุน</strong>
                            <div class="col-sm-9">
                                <select class="form-select" id="source_id" name="source_id">
                                    <option value="" >-- เลือกแหล่งทุน --</option>
                                    @foreach ($data_so as $row)
                                        <option value="{{ $row->research_sources_id }}">
                                            {{ $row->research_source_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3">ประเภทงานวิจัย</strong>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="type[]" id="type"
                                        value="ชุมชนท้องถิ่น">
                                    <label class="form-check-label" for="type">
                                        ชุมชนท้องถิ่น
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="type[]" id="type"
                                        value="ศิลปวัฒนธรรม">
                                    <label class="form-check-label" for="gridRadios2">
                                        ศิลปวัฒนธรรม
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3">วันที่เริ่มต้นสัญญา</strong>
                            <div class="col-sm-9">
                                <input type="date" name="contact_start" id="contact_start" class=" form-control"
                                    data-date-format="DD MM YYYY" min="" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-3">วันที่สิ้นสุดสัญญา</strong>
                            <div class="col-sm-9">
                                <input type="date" name="contact_end" id="contact_end" class=" form-control"
                                    data-date-format="DD MM YYYY" min="" />
                            </div>
                        </div>

                        <div class="row g-3 align-items-center justify-content-center mb-3">
                            <div class="col-auto">
                                <strong for="inputPassword6" class="col-form-label">จำนวนงวด</strong>
                            </div>
                            <div class="col-auto">
                                <input type="text" name="number" min="1" max="10" id="number"
                                    class=" form-control disabled" readonly value="" />
                            </div>
                            <div class="col-auto">
                                <span id="passwordHelpInline" class="form-text">
                                    <button class="btn btn-default btn-sm me-2" type="button" id="addNumbere">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>

                                </span>
                            </div>
                        </div>
                        <div id="boxLesson">
                            <div class="row mb-3 row-lesson mx-2" id="row[]">
                                <strong class="col-sm-2  " id="le">งวดที่ <span id="nu">1</span></strong>
                                <textarea name="lesson[]" id="lesson" rows="5" class=" form-control col-8 me-2 "></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">ยืนยัน</button>
                        <button type="button" class="btn btn-danger" {{-- data-bs-dismiss="modal" --}}
                            onclick="location.reload()">ยกเลิก</button>
                    </div>
                </form>

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
            var len = 1;
            var old = $('#number').val();
            $('#addNumbere').click(function() {
                len++;
                // $('#nu').html(i);
                if (len > 10) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'จำนวนงวดต้องไม่เกิน 10 งวด',
                    })
                } else {

                    $('#number').val(len);
                    console.log(len);
                    tr = '<div class="row mb-3 mx-2"  id="row' + len + '">' +
                        '<strong class="col-sm-2 " id="le">งวดที่ <span id="nu">' + len +
                        '</span></strong>' +
                        // '<div class="col-sm-10">' +
                        '<textarea name="lesson[]" id="lesson" rows="5" class=" form-control col-8 me-2 "></textarea>' +
                        '<button class="btn btn-danger btn-sm col-auto" type="button" id="btnDel">' +
                        '<i class="fa-solid fa-minus"></i>' +
                        '</button>' +
                        // '</div>' +
                        '</div>';

                    $('#boxLesson').append(tr);
                }
            })
        })
        $(document).on('click', '#btnDel', function() {
            var len = $('#number').val();
            console.log('len:' + len);
            $(this).closest('div').remove();
            //$('#le').hide();
            // $(this).closest('strong').remove();
            var rd = len - 1;
            $('#number').val(rd);
        });
    </script>

    <script>
        function addModal() {
            moment.locale('th');
            document.getElementById('contact_start').min = new Date(new Date().getTime() - new Date().getTimezoneOffset() *
                    60000)
                .toISOString().split("T")[0];
            document.getElementById('contact_end').min = new Date(new Date().getTime() - new Date().getTimezoneOffset() *
                    60000)
                .toISOString().split("T")[0];
            $('#number').val(1);
            $('#addModal').modal('toggle');
            var divRow = document.getElementById('#boxLesson');
        }
    </script>
@endpush
