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

                        $month = session('month') ?? now()->format('m');
                        $year = session('year') ?? now()->format('Y');

                        $monthName = Carbon::createFromDate($year, $month)->format('F Y');

                        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
                        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

                        $totalIssued = $letters
                            ->filter(
                                fn($letter) => $letter->issue_date >= $startOfMonth &&
                                    $letter->issue_date <= $endOfMonth,
                            )
                            ->count();

                        $totalReceived = $letters
                            ->filter(
                                fn($letter) => $letter->received_date >= $startOfMonth &&
                                    $letter->received_date <= $endOfMonth,
                            )
                            ->count();

                        $totalLetters = $totalIssued + $totalReceived;

                        $overallLetters = \App\Models\Letter::count();

                        $weekStart = Carbon::parse($startOfMonth);
                        $weekEnd = Carbon::parse($endOfMonth);

                        $weeklyIssued = $letters
                            ->filter(
                                fn($letter) => $letter->issue_date >= $weekStart && $letter->issue_date <= $weekEnd,
                            )
                            ->groupBy(fn($letter) => Carbon::parse($letter->issue_date)->weekOfMonth)
                            ->map->count();

                        $weeklyReceived = $letters
                            ->filter(
                                fn($letter) => $letter->received_date >= $weekStart &&
                                    $letter->received_date <= $weekEnd,
                            )
                            ->groupBy(fn($letter) => Carbon::parse($letter->received_date)->weekOfMonth)
                            ->map->count();

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
                    <div class="summary-cards">
                        <div class="summary-card bg-weekly-total">
                            <div class="summary-text">
                                <div class="summary-value">{{ $currentWeeklyTotal }}</div>
                                <div class="summary-label">Weekly Total Letters</div>
                                <div class="summary-month">Week {{ $currentWeek }} - {{ $monthName }}</div>
                            </div>
                            <div><i class="fa fa-chart-bar summary-icon"></i></div>
                        </div>

                        <div class="summary-card bg-weekly-issued">
                            <div class="summary-text">
                                <div class="summary-value">{{ $currentWeeklyIssued }}</div>
                                <div class="summary-label">Weekly Issued</div>
                                <div class="summary-month">Week {{ $currentWeek }} - {{ $monthName }}</div>
                            </div>
                            <div><i class="fa fa-share-square summary-icon"></i></div>
                        </div>

                        <div class="summary-card bg-weekly-received">
                            <div class="summary-text">
                                <div class="summary-value">{{ $currentWeeklyReceived }}</div>
                                <div class="summary-label">Weekly Received</div>
                                <div class="summary-month">Week {{ $currentWeek }} - {{ $monthName }}</div>
                            </div>
                            <div><i class="fa fa-envelope-open-text summary-icon"></i></div>
                        </div>
                        <div class="summary-card">
                        </div>
                    </div>
                    {{-- <div class="search-bar">

                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="filterDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-sliders-h me-1"></i> Filter Options
                            </button>
                            <div class="dropdown-menu shadow-lg" aria-labelledby="filterDropdown">
                                <div class="pb-2 border-bottom mb-2">
                                    <h6 class="fw-bold mb-0"><i class="fas fa-filter me-2 text-primary"></i>Smart
                                        Filters</h6>
                                </div>

                                @foreach ([
        'dateWise' => 'Date Wise',
        'monthWise' => 'Month Wise',
        'category' => 'Category',
        'subCategory' => 'Sub Category',
        'receiptLetter' => 'Receipt Letter',
        'issueLetter' => 'Issue Letter',
        'letterNo' => 'Letter No',
        'crnNo' => 'CRN No',
        'ecrNo' => 'ECR No',
    ] as $id => $label)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $id }}">
                                        <label class="form-check-label fw-medium"
                                            for="{{ $id }}">{{ $label }}</label>
                                    </div>
                                @endforeach

                                <div id="dateWiseOptions" class="mt-3" style="display: none;">
                                    <label class="form-label fw-bold text-primary">Select Date Range:</label>
                                    <input type="date" class="form-control mb-2" id="fromDate">
                                    <input type="date" class="form-control" id="toDate">
                                </div>

                                <div id="monthWiseOptions" style="display: none;" class="mt-2">
                                    <select id="monthWiseYear" class="form-select mb-2">
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025" selected>2025</option>
                                        <option value="2026">2026</option>
                                    </select>
                                    <select id="monthWiseMonth" class="form-select mb-2">
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7" selected>July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>

                                    </select>

                                    <button id="monthWiseView" class="btn btn-success btn-sm">View Month-Wise</button>
                                </div>


                                <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-3">
                                    <small class="text-muted fst-italic">Choose your filter criteria</small>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-primary"><i
                                                class="fas fa-check-circle me-1"></i>Apply</button>
                                        <button class="btn btn-sm btn-danger"><i
                                                class="fas fa-times-circle me-1"></i>Clear</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="text" placeholder="🔍 Search ..." />
                        <button class="btn btn-primary">Search</button>
                        <button class="btn btn-outline-danger" title="Clear"><i class="fas fa-times"></i></button>
                        <button class="btn btn-outline-success" title="Export to Excel"><i
                                class="fas fa-file-excel"></i></button>
                    </div> --}}


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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="{{ asset('js/filtered_list.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
