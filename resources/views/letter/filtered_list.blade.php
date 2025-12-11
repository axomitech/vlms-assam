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

                    <style>
                        .summary-cards {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                            gap: 12px;
                            margin-bottom: 1.2rem;
                        }

                        .summary-card {
                            border-radius: 10px;
                            padding: 10px 12px;
                            color: white;
                            font-weight: 500;
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
                            transition: transform 0.2s ease;
                            min-height: 110px;
                        }

                        .summary-card:hover {
                            transform: translateY(-2px);
                        }

                        .summary-icon {
                            font-size: 1.7rem;
                            opacity: 0.85;
                        }

                        .summary-text {
                            display: flex;
                            flex-direction: column;
                            gap: 2px;
                        }

                        .summary-value {
                            font-size: 1.3rem;
                            font-weight: 700;
                            line-height: 1;
                        }

                        .summary-label {
                            font-size: 0.82rem;
                            font-weight: 600;
                            margin-bottom: -2px;
                        }

                        .summary-month {
                            font-size: 0.72rem;
                            opacity: 0.75;
                        }

                        .bg-monthly {
                            background-color: #198754;
                        }

                        .bg-issued {
                            background-color: #fd7e14;
                        }

                        .bg-received {
                            background-color: #0d6efd;
                        }

                        .bg-total {
                            background-color: #6c757d;
                        }

                        .bg-weekly-received {
                            background-color: #942918;
                        }

                        .bg-weekly-issued {
                            background-color: #A3A32E;
                        }

                        .bg-weekly-total {
                            background-color: #240202;
                        }
                    </style>



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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const letterCards = Array.from(document.querySelectorAll('.letter-card'));
            const paginationContainer = document.getElementById('paginationContainer');
            const pageSizeDropdown = document.getElementById('pageSizeDropdown');
            const searchInput = document.querySelector('.search-bar input[type="text"]');
            let itemsPerPage = parseInt(pageSizeDropdown.value);

            // Pagination Logic
            function showPage(pageNumber) {
                const start = (pageNumber - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                letterCards.forEach((card, index) => {
                    card.style.display = index >= start && index < end ? 'flex' : 'none';
                });
            }

            function createPageItem(page, currentPage, label = null, disabled = false) {
                const li = document.createElement('li');
                li.className = 'page-item' + (page === currentPage ? ' active' : '') + (disabled ? ' disabled' :
                    '');
                const a = document.createElement('a');
                a.className = 'page-link';
                a.href = '#';
                a.innerText = label || page;

                if (!disabled) {
                    a.addEventListener('click', function(e) {
                        e.preventDefault();
                        renderPagination(page);
                    });
                }

                li.appendChild(a);
                return li;
            }

            function renderPagination(currentPage = 1) {
                itemsPerPage = parseInt(pageSizeDropdown.value);
                const totalPages = Math.ceil(letterCards.length / itemsPerPage);
                paginationContainer.innerHTML = '';

                paginationContainer.appendChild(createPageItem(currentPage - 1, currentPage, 'Previous',
                    currentPage === 1));

                if (totalPages <= 7) {
                    for (let i = 1; i <= totalPages; i++) paginationContainer.appendChild(createPageItem(i,
                        currentPage));
                } else {
                    if (currentPage <= 4) {
                        for (let i = 1; i <= 5; i++) paginationContainer.appendChild(createPageItem(i,
                            currentPage));
                        paginationContainer.appendChild(createPageItem(null, currentPage, '...', true));
                        paginationContainer.appendChild(createPageItem(totalPages, currentPage));
                    } else if (currentPage > totalPages - 4) {
                        paginationContainer.appendChild(createPageItem(1, currentPage));
                        paginationContainer.appendChild(createPageItem(null, currentPage, '...', true));
                        for (let i = totalPages - 4; i <= totalPages; i++) paginationContainer.appendChild(
                            createPageItem(i, currentPage));
                    } else {
                        paginationContainer.appendChild(createPageItem(1, currentPage));
                        paginationContainer.appendChild(createPageItem(null, currentPage, '...', true));
                        for (let i = currentPage - 1; i <= currentPage + 1; i++) paginationContainer.appendChild(
                            createPageItem(i, currentPage));
                        paginationContainer.appendChild(createPageItem(null, currentPage, '...', true));
                        paginationContainer.appendChild(createPageItem(totalPages, currentPage));
                    }
                }

                paginationContainer.appendChild(createPageItem(currentPage + 1, currentPage, 'Next', currentPage ===
                    totalPages));
                showPage(currentPage);
            }

            renderPagination();

            pageSizeDropdown.addEventListener('change', () => {
                renderPagination(1);
            });

            function performSearch(query) {
                const q = query.toLowerCase().trim();
                letterCards.forEach(row => {
                    const letterNo = row.querySelector('.letter-col:nth-child(2)').innerText.toLowerCase();
                    const crn = row.querySelector('.letter-col:nth-child(3)').innerText.toLowerCase();
                    const ecr = row.querySelector('.letter-col:nth-child(4)').innerText.toLowerCase();
                    const match = letterNo.includes(q) || crn.includes(q) || ecr.includes(q);
                    row.style.display = match ? 'flex' : 'none';
                });
            }

            searchInput.addEventListener('input', function() {
                performSearch(this.value);
            });

            document.querySelector('.search-bar .btn-primary').addEventListener('click', function() {
                performSearch(searchInput.value);
            });

            document.querySelector('.search-bar .btn-outline-danger').addEventListener('click', function() {
                searchInput.value = '';
                letterCards.forEach(row => row.style.display = 'flex');
            });
            document.querySelector('.search-bar .btn-outline-success').addEventListener('click', function() {
                const wb = XLSX.utils.book_new();
                const ws_data = [
                    ['SL', 'Letter No', 'CRN No', 'ECR No', 'Letter Date', 'Received Date', 'Category',
                        'SubCategory', 'Issue Date'
                    ]
                ];

                letterCards.forEach(row => {
                    if (row.style.display !== 'none') {
                        const cols = Array.from(row.querySelectorAll('.letter-col')).map(col => col
                            .innerText.trim());
                        cols.pop();
                        ws_data.push(cols);
                    }
                });

                const ws = XLSX.utils.aoa_to_sheet(ws_data);
                XLSX.utils.book_append_sheet(wb, ws, 'Letters');
                XLSX.writeFile(wb, 'Letters_Report.xlsx');
            });

            const toggleColumnDisplay = (columnIndex) => {
                document.querySelectorAll('.letter-card, .letter-header').forEach(row => {
                    row.querySelectorAll('.letter-col').forEach((col, i) => {
                        col.style.display = (i === 0 || i === columnIndex) ? 'flex' : 'none';
                    });
                });
            };

            const columnToggles = {
                letterNo: 1,
                crnNo: 2,
                ecrNo: 3,
                receiptLetter: 5,
                issueLetter: 8,
                category: 6,
                subCategory: 7
            };

            for (const [id, index] of Object.entries(columnToggles)) {
                document.getElementById(id)?.addEventListener('change', function() {
                    if (this.checked) toggleColumnDisplay(index);
                });
            }

            const toggleSection = (checkboxId, sectionId) => {
                const checkbox = document.getElementById(checkboxId);
                if (!checkbox) return;
                checkbox.addEventListener('change', function() {
                    document.getElementById(sectionId).style.display = this.checked ? 'block' : 'none';
                });
            };

            toggleSection('allLetters', 'allLettersOptions');
            toggleSection('dateWise', 'dateWiseOptions');
            toggleSection('monthWise', 'monthWiseOptions');
            toggleSection('yearWise', 'yearWiseOptions');

            document.querySelector('.btn-primary')?.addEventListener('click', function() {
                const fromDate = document.getElementById('fromDate')?.value;
                const toDate = document.getElementById('toDate')?.value;

                if (fromDate && toDate) {
                    document.querySelectorAll('.letter-card').forEach(row => {
                        const letterDate = row.querySelector('.letter-col:nth-child(5)').innerText;
                        row.style.display = (letterDate >= fromDate && letterDate <= toDate) ?
                            'flex' : 'none';
                    });
                }
            });

            document.getElementById('monthWiseView')?.addEventListener('click', () => {
                const year = document.getElementById('monthWiseYear')?.value;
                const month = document.getElementById('monthWiseMonth')?.value;
                if (year && month) {
                    const url = `/letters/filter/year/${year}/month/${month}`;
                    if (window.location.href === window.location.origin + url) {
                        window.location.reload();
                    } else {
                        window.location.href = url;
                    }
                }
            });




            // Search
            document.getElementById('searchButton')?.addEventListener('click', function() {
                const val = document.getElementById('letterSearchInput').value.toLowerCase();
                document.querySelectorAll('.letter-card').forEach(row => {
                    const rowText = row.innerText.toLowerCase();
                    row.style.display = rowText.includes(val) ? '' : 'none';
                });
            });

            document.getElementById('clearSearch')?.addEventListener('click', function() {
                document.getElementById('letterSearchInput').value = '';
                document.querySelectorAll('.letter-card').forEach(row => row.style.display = '');
            });

            document.getElementById('exportPdf')?.addEventListener('click', function() {
                alert('Export to PDF demo triggered!');
            });
            document.getElementById('resetView').addEventListener('click', function() {
                window.location.href = "{{ route('dashboard') }}";
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
