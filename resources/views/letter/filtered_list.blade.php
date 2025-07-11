@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
        }

        .summary-box {
            background: #eaf4ff;
            border-left: 4px solid #0d6efd;
            border-radius: 12px;
            padding: 14px 24px;
            margin-bottom: 1.5rem;
            font-size: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .letter-header,
        .letter-card {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 12px;
            padding: 0.4rem 0.75rem;
            margin-bottom: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            transition: background 0.2s ease;
        }

        .letter-card:hover {
            background: #f9fbff;
        }

        .letter-header {
            background: #f1f5f9;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.78rem;
        }

        .letter-col {
            flex: 1 0 120px;
            min-width: 120px;
            padding: 0 4px;
            font-size: 0.78rem;
            word-wrap: break-word;
            white-space: normal;
        }

        .letter-col:not(:last-child) {
            border-right: 1px solid #dee2e6;
        }

        .letter-col.sl-no {
            max-width: 60px;
            flex: 0 0 60px;
            text-align: center;
            font-weight: bold;
            padding: 0 4px;
        }

        .letter-col.text-end {
            text-align: left !important;
            word-wrap: break-word;
            white-space: normal;
        }

        .letter-col.text-center {
            text-align: center;
        }

        .badge-status {
            background-color: #d1f4e2;
            color: #0f5132;
            border-radius: 10px;
            padding: 3px 8px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .category-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .category-list ul {
            margin-top: 4px;
            padding-left: 0.8rem;
            font-weight: normal;
            font-size: 0.75rem;
        }

        .search-bar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 10px;
        }

        .search-bar input[type="text"] {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            min-width: 240px;
        }

        .search-bar .btn {
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
            padding: 10px 14px !important;
            font-size: 0.85rem;
            width: 250px;
        }

        .dropdown-menu h6 {
            font-size: 0.95rem;
            margin-bottom: 8px;
        }

        .dropdown-menu .form-check {
            margin-bottom: 6px;
        }

        .dropdown-menu .form-label,
        .dropdown-menu .form-check-label {
            font-size: 0.85rem;
        }

        .dropdown-menu .form-select,
        .dropdown-menu input[type="date"] {
            font-size: 0.85rem;
            padding: 6px 8px;
            border-radius: 6px;
        }

        .dropdown-menu .btn-sm {
            font-size: 0.75rem;
            padding: 4px 8px;
        }

        .dropdown-menu .d-flex.gap-2 {
            gap: 6px !important;
        }

        .dropdown-menu small {
            font-size: 0.75rem;
        }

        .scrollable-table {
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 1rem;
        }

        #customPagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            padding: 1rem 0;
            border-top: 1px solid #e3e3e3;
            margin-top: 20px;
            gap: 10px;
        }

        #paginationContainer {
            display: flex;
            gap: 4px;
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        #paginationContainer .page-item .page-link {
            padding: 6px 12px;
            border: 1px solid #d4d4d4;
            border-radius: 6px;
            font-size: 0.85rem;
            background-color: #fff;
            color: #333;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }

        #paginationContainer .page-item .page-link:hover {
            background-color: #f1f3ff;
            color: #0d6efd;
            border-color: #0d6efd;
        }

        #paginationContainer .page-item.active .page-link {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
            font-weight: 600;
        }

        #paginationContainer .page-item.disabled .page-link {
            color: #999;
            background-color: #f8f9fa;
            pointer-events: none;
        }

        #pageSizeDropdown {
            border: 1px solid #d4d4d4;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 0.85rem;
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23000" height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position-x: 95%;
            background-position-y: 50%;
        }

        @media (max-width: 768px) {

            .letter-header,
            .letter-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .letter-col,
            .letter-col.sl-no {
                width: 100% !important;
                padding: 4px 0;
                text-align: left;
                border-right: none !important;
            }

            .summary-box {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .dropdown-menu {
                width: 100% !important;
            }
        }
    </style>




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

                        $monthlyLetters = $letters->filter(function ($letter) use ($startOfMonth, $endOfMonth) {
                            return ($letter->issued_date >= $startOfMonth && $letter->issued_date <= $endOfMonth) ||
                                ($letter->received_date >= $startOfMonth && $letter->received_date <= $endOfMonth);
                        });

                        $totalLetters = $letters->count();

                        $totalIssued = $letters
                            ->filter(function ($letter) use ($startOfMonth, $endOfMonth) {
                                return $letter->issue_date >= $startOfMonth && $letter->issue_date <= $endOfMonth;
                            })
                            ->count();

                        $totalReceived = $letters
                            ->filter(function ($letter) use ($startOfMonth, $endOfMonth) {
                                return $letter->received_date >= $startOfMonth && $letter->received_date <= $endOfMonth;
                            })
                            ->count();

                        $overallLetters = \App\Models\Letter::count();
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
                            min-height: 80px;
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
                    </style>



                    <div class="summary-cards">
                        <!-- Monthly Total Letters -->
                        <div class="summary-card bg-monthly">
                            <div class="summary-text">
                                <div class="summary-value">{{ $totalLetters }}</div>
                                <div class="summary-label">Monthly Total Letters</div>
                                <div class="summary-month">{{ $monthName }}</div>
                            </div>
                            <div><i class="fa fa-envelope summary-icon"></i></div>
                        </div>

                        <!-- Monthly Issued -->
                        <div class="summary-card bg-issued">
                            <div class="summary-text">
                                <div class="summary-value">{{ $totalIssued }}</div>
                                <div class="summary-label">Monthly Issued</div>
                                <div class="summary-month">{{ $monthName }}</div>
                            </div>
                            <div><i class="fa fa-paper-plane summary-icon"></i></div>
                        </div>

                        <!-- Monthly Received -->
                        <div class="summary-card bg-received">
                            <div class="summary-text">
                                <div class="summary-value">{{ $totalReceived }}</div>
                                <div class="summary-label">Monthly Received</div>
                                <div class="summary-month">{{ $monthName }}</div>
                            </div>
                            <div><i class="fa fa-inbox summary-icon"></i></div>
                        </div>

                        <!-- Overall Total Letters -->
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
            'allLetters' => 'All Letters',
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

                                <div id="allLettersOptions" class="mt-3" style="display: none;">
                                    <label class="form-label fw-bold text-primary">Letter Type:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="letterType" id="diarizeLetter"
                                            value="diarize">
                                        <label class="form-check-label" for="diarizeLetter">Diarize Letter</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="letterType" id="legacyLetter"
                                            value="legacy">
                                        <label class="form-check-label" for="legacyLetter">Legacy Letter</label>
                                    </div>
                                </div>

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
                                <div class="letter-col">{{ $letter->subCategory->sub_category_name ?? 'N/A' }}</div>
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

            // Search Logic
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

            // 📤 Export to Excel
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
                        cols.pop(); // remove Archive column
                        ws_data.push(cols);
                    }
                });

                const ws = XLSX.utils.aoa_to_sheet(ws_data);
                XLSX.utils.book_append_sheet(wb, ws, 'Letters');
                XLSX.writeFile(wb, 'Letters_Report.xlsx');
            });

            // Column Filters
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

            // Toggle Filter Sections
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

            // Date Filter
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

            // Month-wise View

            document.getElementById('monthWiseView')?.addEventListener('click', () => {
                const year = document.getElementById('monthWiseYear')?.value;
                const month = document.getElementById('monthWiseMonth')?.value;
                if (year && month) {
                    const url = `/letters/filter/year/${year}/month/${month}`;
                    if (window.location.href === window.location.origin + url) {
                        // Same URL, force reload
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

            //Export Buttons
            document.getElementById('exportPdf')?.addEventListener('click', function() {
                alert('Export to PDF demo triggered!');
            });

            // Reset button
            document.getElementById('resetView').addEventListener('click', function() {
                window.location.href = "{{ route('dashboard') }}";
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
