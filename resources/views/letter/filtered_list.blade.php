@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/filtered_list.css') }}">


    <div class="col-md-12 text-center">
        <button class="btn btn-dark btn-sm" id="resetView" style="float: left;">
            <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
        </button>
        <h4><strong>Letters Summary</strong></h4>
    </div>

    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-body">

                    @php
                        use Carbon\Carbon;
                        use Illuminate\Support\Facades\DB;

                        $departmentId = session('role_dept');

                        $month = session('month') ?? now()->format('m');
                        $year = session('year') ?? now()->format('Y');

                        $monthName = Carbon::createFromDate($year, $month)->format('F Y');

                        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
                        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();

                        $totalIssued = DB::table('letters')
                            ->where('department_id', $departmentId)
                            ->where('receipt', false)
                            ->whereBetween('issue_date', [$startOfMonth, $endOfMonth])
                            ->count();

                        $totalReceived = DB::table('letters')
                            ->where('department_id', $departmentId)
                            ->where('receipt', true)
                            ->whereBetween('received_date', [$startOfMonth, $endOfMonth])
                            ->count();

                        $totalLetters = $totalIssued + $totalReceived;

                        $overallLetters = DB::table('letters')->where('department_id', $departmentId)->count();

                        $weeklyIssued = DB::table('letters')
                            ->selectRaw('CEIL(EXTRACT(DAY FROM issue_date)::numeric / 7) AS week, COUNT(*) as total')
                            ->where('department_id', $departmentId)
                            ->where('receipt', false)
                            ->whereBetween('issue_date', [$startOfMonth, $endOfMonth])
                            ->groupBy('week')
                            ->pluck('total', 'week');

                        $weeklyReceived = DB::table('letters')
                            ->selectRaw('CEIL(EXTRACT(DAY FROM received_date)::numeric / 7) AS week, COUNT(*) as total')
                            ->where('department_id', $departmentId)
                            ->where('receipt', true)
                            ->whereBetween('received_date', [$startOfMonth, $endOfMonth])
                            ->groupBy('week')
                            ->pluck('total', 'week');

                        $weeklyTotal = [];

                        foreach ($weeklyIssued as $week => $count) {
                            $weeklyTotal[$week] = ($weeklyTotal[$week] ?? 0) + $count;
                        }

                        foreach ($weeklyReceived as $week => $count) {
                            $weeklyTotal[$week] = ($weeklyTotal[$week] ?? 0) + $count;
                        }

                        $currentWeek = now()->weekOfMonth;

                        $currentWeeklyIssued = $weeklyIssued[$currentWeek] ?? 0;
                        $currentWeeklyReceived = $weeklyReceived[$currentWeek] ?? 0;
                        $currentWeeklyTotal = $weeklyTotal[$currentWeek] ?? 0;

                    @endphp



                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
                    <div class="summary-cards">
                        <div class="summary-card bg-monthly">
                            <div class="summary-text">
                                <div class="summary-value">{{ $totalLetters }}</div>
                                <div class="summary-label">Monthly Total Letters</div>
                                <div class="summary-month">{{ $monthName }}</div>
                            </div>
                            <div><i class="fa fa-envelope summary-icon"></i></div>
                        </div>
                        <div class="summary-card bg-issued">
                            <div class="summary-text">
                                <div class="summary-value">{{ $totalIssued }}</div>
                                <div class="summary-label">Monthly Issued</div>
                                <div class="summary-month">{{ $monthName }}</div>
                            </div>
                            <div><i class="fa fa-paper-plane summary-icon"></i></div>
                        </div>
                        <div class="summary-card bg-received">
                            <div class="summary-text">
                                <div class="summary-value">{{ $totalReceived }}</div>
                                <div class="summary-label">Monthly Received</div>
                                <div class="summary-month">{{ $monthName }}</div>
                            </div>
                            <div><i class="fa fa-inbox summary-icon"></i></div>
                        </div>

                        <div class="summary-card bg-total">
                            <div class="summary-text">
                                <div class="summary-value">{{ $overallLetters }}</div>
                                <div class="summary-label">Overall Total Letters</div>
                                <div class="summary-month">&nbsp;</div>
                            </div>
                            <div><i class="fa fa-database summary-icon"></i></div>
                        </div>
                    </div>

                    <div class="search-bar">

                        <input type="text" class="form-control search-input" placeholder="🔍 Search letters...">

                        <button class="btn btn-primary btn-sm search-btn">
                            <i class="fas fa-search me-1"></i> Search
                        </button>

                        <button class="btn btn-outline-danger btn-sm clear-btn" title="Clear">
                            <i class="fas fa-times"></i>
                        </button>

                        <button class="btn btn-outline-success btn-sm export-btn" title="Export to Excel">
                            <i class="fas fa-file-excel"></i>
                        </button>

                    </div>


                    <div class="scrollable-table">
                        <div class="letter-header">
                            <div class="letter-col sl-no">SL</div>
                            <div class="letter-col">Letter No</div>
                            <div class="letter-col">CRN No</div>
                            <div class="letter-col">ECR No</div>
                            <div class="letter-col">Letter Date</div>
                            <div class="letter-col">Received Date</div>
                            <div class="letter-col">Category</div>
                            <div class="letter-col">SubCategory</div>
                            <div class="letter-col">Issue Date</div>
                            <div class="letter-col text-center">Archive</div>
                        </div>

                        @foreach ($letters as $index => $letter)
                            <div class="letter-card">
                                <div class="letter-col sl-no">{{ $index + 1 }}</div>
                                <div class="letter-col">{{ $letter->letter_no }}</div>
                                <div class="letter-col">{{ $letter->crn }}</div>
                                <div class="letter-col">{{ $letter->ecr_no }}</div>
                                <div class="letter-col">{{ $letter->letter_date }}</div>
                                <div class="letter-col">{{ $letter->received_date }}</div>
                                <div class="letter-col">{{ $letter->category->category_name ?? 'N/A' }}</div>
                                <div class="letter-col">
                                    {{ optional($letter->subCategory)->sub_category_name ?? ($letter->letter_other_sub_categories ?? 'Others/Miscellaneous Department') }}
                                </div>
                                <div class="letter-col">{{ $letter->issue_date }}</div>
                                <div class="letter-col text-center">
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        <i class="fas fa-archive"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="customPagination">
                        <nav>
                            <ul class="pagination" id="paginationContainer"></ul>
                        </nav>
                        <select id="pageSizeDropdown">
                            <option value="5">5 / page</option>
                            <option value="10" selected>10 / page</option>
                            <option value="20">20 / page</option>
                            <option value="50">50 / page</option>
                            <option value="100">100 / page</option>
                            <option value="200">200 / page</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        document.getElementById("resetView").addEventListener("click", function() {
            window.location.href = "{{ route('dashboard') }}";
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="{{ asset('js/filtered_list.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
