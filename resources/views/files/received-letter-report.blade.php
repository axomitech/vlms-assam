@extends('layouts.app')

@section('content')
    <link rel="preload" href="{{ asset('css/receipt-summary.css') }}" as="style" onload="this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('css/receipt-summary.css') }}">
    </noscript>


    <script src="{{ asset('js/receipt-summary.js') }}" defer></script>

    <div class="col-md-12 mb-3">
        <button class="btn btn-dark btn-sm" id="resetView" style="display:none;" aria-label="Back to departments">

            <svg width="14" height="14" viewBox="0 0 24 24" aria-hidden="true" focusable="false" role="img">
                <path fill="currentColor" d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
            </svg>
            <span>Back</span>
        </button>
    </div>


    <h1 class="visually-hidden">Receipt Letters Dashboard</h1>


    <h2 class="report-heading" role="heading" aria-level="2">

        <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true" focusable="false" role="img">
            <path fill="currentColor"
                d="M19 3h-4.18A3 3 0 0 0 11 1H9a3 3 0 0 0-3 3H3v18h18V3zM9 3h2v2H9V3zm6 0h2v2h-2V3z" />
        </svg>
        Receipt Letters Summary – Department-wise Overview
    </h2>

    <div class="mb-4 d-flex flex-wrap justify-content-center align-items-center gap-3">
        <div class="position-relative" style="width:380px;">
            <label for="subcategorySearch" class="visually-hidden">Search Departments</label>

            <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                role="img">
                <path fill="currentColor"
                    d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16a6.471 6.471 0 0 0 4.23-1.57l.27.28v.79L20 21.49 21.49 20 15.5 14zM9.5 14C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
            </svg>

            <input type="search" id="subcategorySearch" class="form-control search-input"
                placeholder="Search Departments..." aria-label="Search Departments">
        </div>

        @php
            $totalLetterCount = 0;
            foreach ($groupedLetters as $cat => $sub) {
                foreach ($sub as $subCat => $yrs) {
                    $totalLetterCount += collect($yrs)->flatten(2)->count();
                }
            }
        @endphp

        <div class="fw-semibold" id="filteredLetterCount" style="font-size:0.95rem;">
            <strong>Total Receipt Letters:</strong>&nbsp;<span id="letterCountStatic"
                data-orig="{{ $totalLetterCount }}">{{ $totalLetterCount }}</span>
        </div>
    </div>


    <div class="container-fluid">

        <div id="subcategoryCardList" class="card-grid" role="list">
            @foreach ($groupedLetters as $categoryId => $subCats)
                @foreach ($subCats as $subCategoryId => $years)
                    @php
                        $name = $subCategories[$subCategoryId] ?? 'Others/Miscellaneous Departments';
                        $count = collect($years)->flatten(2)->count();
                    @endphp

                    <div class="card-button" role="button" tabindex="0"
                        aria-label="Open {{ $name }} ({{ $count }} letters)"
                        onclick="showOnlyThis('subcat-{{ $categoryId }}-{{ $subCategoryId }}')"
                        data-letter-count="{{ $count }}">
                        <h3 class="card-title">{{ $name }}</h3>
                        <p class="card-desc">Total letters: {{ $count }}<br>View year &amp; month-wise.</p>
                    </div>
                @endforeach
            @endforeach
        </div>


        @foreach ($groupedLetters as $categoryId => $subCats)
            @foreach ($subCats as $subCategoryId => $years)
                <section id="subcat-{{ $categoryId }}-{{ $subCategoryId }}" class="nested-section" style="display:none;"
                    aria-hidden="true">
                    @foreach ($years as $year => $months)
                        <div class="mb-2 mt-3">
                            <strong aria-hidden="true">

                                <svg width="14" height="14" viewBox="0 0 24 24" aria-hidden="true" focusable="false"
                                    role="img">
                                    <path fill="currentColor" d="M7 10h5v5H7zM5 3h2v2h10V3h2v20H5V3z" />
                                </svg>
                                Year: {{ $year }}
                            </strong>
                        </div>

                        <div class="card-grid">
                            @foreach ($months as $month => $lettersGroup)
                                @php $m = strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $month)); @endphp

                                <div class="month-card" role="button" tabindex="0"
                                    aria-label="Open {{ $month }} {{ $year }} ({{ count($lettersGroup) }} letters)"
                                    onclick="toggleMonth('month-{{ $subCategoryId }}-{{ $year }}-{{ $m }}')">
                                    <div class="month-count">{{ count($lettersGroup) }}</div>
                                    <span>{{ $month }}<br>Total Letters</span>
                                </div>
                            @endforeach
                        </div>

                        @foreach ($months as $month => $lettersGroup)
                            @php $m = strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $month)); @endphp

                            <div id="month-{{ $subCategoryId }}-{{ $year }}-{{ $m }}"
                                class="nested-month" style="display:none;" aria-hidden="true">
                                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                    <button class="btn btn-sm btn-outline-secondary" onclick="showMonths(this)"
                                        aria-label="Back to months">

                                        <svg width="12" height="12" viewBox="0 0 24 24" aria-hidden="true"
                                            focusable="false" role="img">
                                            <path fill="currentColor" d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                                        </svg>
                                        Back to Months
                                    </button>

                                    <label class="visually-hidden"
                                        for="table-search-{{ $subCategoryId }}-{{ $year }}-{{ $m }}">Search
                                        letters</label>
                                    <input
                                        id="table-search-{{ $subCategoryId }}-{{ $year }}-{{ $m }}"
                                        type="search" class="form-control table-search-input" style="max-width:300px;"
                                        placeholder="Search letters..."
                                        data-table-id="table-{{ $subCategoryId }}-{{ $year }}-{{ $m }}"
                                        aria-label="Search letters">
                                </div>

                                <div class="mb-2"><strong>{{ $month }} {{ $year }} - Letters</strong>
                                </div>

                                <table class="letter-table"
                                    id="table-{{ $subCategoryId }}-{{ $year }}-{{ $m }}"
                                    role="table" aria-label="{{ $month }} {{ $year }} letters table">
                                    <thead>
                                        <tr>
                                            <th scope="col">SL No</th>
                                            <th scope="col">Received Date</th>
                                            <th scope="col">Letter No</th>
                                            <th scope="col">CRN No</th>
                                            <th scope="col">ECR No</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Sub Category</th>
                                            <th scope="col">Download</th>
                                        </tr>
                                    </thead>
                                    <tbody class="paginated-body">
                                        @foreach ($lettersGroup as $index => $letter)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($letter->received_date)->format('d-m-Y') }}
                                                </td>
                                                <td>{{ $letter->letter_no ?? 'N/A' }}</td>
                                                <td>{{ $letter->crn ?? 'N/A' }}</td>
                                                <td>{{ $letter->ecr_no ?? 'N/A' }}</td>
                                                <td>{{ $categories[$letter->letter_category_id] ?? 'N/A' }}</td>
                                                <td>{{ optional($letter->subCategory)->sub_category_name ?? ($letter->letter_other_sub_categories ?? 'Others/Miscellaneous Department') }}
                                                </td>
                                                <td>
                                                    <a href="{{ asset(str_replace('public/', 'storage/', $letter->letter_path)) }}"
                                                        class="btn btn-sm btn-outline-primary" target="_blank"
                                                        rel="noopener noreferrer" aria-label="Download letter">
                                                        Download
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="pagination-buttons mt-2 d-flex flex-wrap gap-2 justify-content-center align-items-center"
                                    aria-hidden="false"></div>
                            </div>
                        @endforeach
                    @endforeach
                </section>
            @endforeach
        @endforeach
    </div>
@endsection
