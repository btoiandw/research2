@extends('layouts.admin.admin')
@section('content')
    <div class=" card">
        <div class="row justify-content-center pt-4 pb-3">
            <div class="row col-5 me-3">
                <strong class="col-auto">แหล่งทุน</strong>
                <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="col-4">
                <strong>วันที่</strong>
                <input class="form-control" id="" name="" placeholder="MM/DD/YYY" type="date" />
            </div>
        </div>
        <div class="row justify-content-center pt-3 pb-3">
            <div class="row col-5 me-3">
                <strong class="col-auto">คณะ/สังกัด</strong>
                <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <div class="col-4">
                <strong>ถึง</strong>
                <input class="form-control" id="" name="" placeholder="MM/DD/YYY" type="date" />
            </div>
        </div>
        <div class="row justify-content-center pt-3 pb-3">
            <strong class="col-auto" align="right">ประเภทงานวิจัย</strong>
            <div class="col-8">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="type[]" id="type" value="ชุมชนท้องถิ่น">
                    <label class="form-check-label" for="type">
                        ชุมชนท้องถิ่น
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="type[]" id="type" value="ศิลปวัฒนธรรม">
                    <label class="form-check-label" for="gridRadios2">
                        ศิลปวัฒนธรรม
                    </label>
                </div>

            </div>
        </div>
        <div class="row justify-content-center">

            <div class="row col-5 me-3">
                <div class="d-grid d-md-flex container-fluid">
                    <button class="btn btn-default" type="button">ออกรายงาน</button>
                </div>
            </div>
            <div class="col-4">
            </div>
        </div>

        <hr style="border: 0.3px solid #B2B2B2;" class="m-4" />
        <div class="table-responsive container-fluid">
            <table class="table fw-bold w-100" id="cbg_table">
                <thead class="table-dark table-hover table align-middle">
                    <tr align="center">
                        <th class="fw-bolder" style="font-size: 15px">ลำดับ</th>
                        <th class="fw-bolder" style="font-size: 15px">แหล่งทุน</th>
                        <th class="fw-bolder" style="font-size: 15px">ประเภทงานวิจัย</th>
                        <th class="fw-bolder" style="font-size: 15px">คณะ/สังกัด</th>
                        <th class="fw-bolder" style="font-size: 15px">วันที่</th>

                    </tr>
                </thead>

                <tbody>

                </tbody>
            </table>
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
            $('#cbg_table').DataTable({
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
