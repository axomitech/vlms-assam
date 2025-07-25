@php
    function sanitizeId($value)
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $value));
    }
@endphp

@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f4f7fb;
        }

        .report-heading {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 25px;
            color: #2c3e50;
            text-align: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .card-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            justify-content: flex-start;
        }

        .card-button {
            flex: 0 0 calc(25% - 16px);
            background: #ffffff;
            border-radius: 14px;
            padding: 14px 18px;
            border: 1px solid #dee2e6;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            text-align: left;
            position: relative;
            cursor: pointer;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 110px;
        }

        .card-button:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        }

        .card-button::after {
            content: '';
            position: absolute;
            left: 16px;
            bottom: 12px;
            width: calc(100% - 32px);
            height: 3px;
            background: linear-gradient(to right, #ff416c, #007bff);
            border-radius: 10px;
        }

        .card-button h5 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            word-break: break-word;
        }

        .card-button p {
            font-size: 0.85rem;
            color: #555;
            margin: 0;
        }

        .search-input {
            padding-left: 2.5rem;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border-radius: 12px;
            border: 1px solid #ced4da;
            width: 100%;
        }

        .search-icon {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 14px;
            pointer-events: none;
        }

        .month-card {
            flex: 0 0 calc(25% - 16px);
            background: linear-gradient(135deg, #edf1f7, #ffffff);
            border: 1px solid #dce4ec;
            border-radius: 14px;
            padding: 20px 14px;
            font-weight: 600;
            font-size: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .month-card:hover {
            background: #f0f4fa;
            transform: translateY(-3px);
        }

        .month-card span {
            display: block;
            font-size: 0.9rem;
            margin-top: 6px;
            color: #555;
            font-weight: 500;
        }

        .nested-section,
        .nested-month {
            display: none;
            margin-bottom: 15px;
        }

        .letter-table {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            font-size: 0.95rem;
            margin-top: 12px;
            background: #fff;
        }

        .letter-table th,
        .letter-table td {
            padding: 10px 14px;
            border-bottom: 1px solid #f1f1f1;
        }

        .letter-table th {
            background: #e8f0fe;
            font-weight: 600;
        }

        .letter-table tr:nth-child(even) {
            background-color: #f9fcff;
        }

        .letter-table tr:hover {
            background-color: #f0f7ff;
        }

        @media (max-width: 992px) {

            .card-button,
            .month-card {
                flex: 0 0 calc(50% - 12px);
            }
        }

        @media (max-width: 600px) {

            .card-button,
            .month-card {
                flex: 0 0 100%;
            }
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="col-md-12 mb-3">
        <button class="btn btn-dark btn-sm" id="resetView" style="display: none;">
            <i class="fa fa-arrow-left"></i> Back
        </button>
    </div>

    <h4 class="report-heading"><i class="fa fa-clipboard-list"></i> Issue Letters Summary – Department-wise Overview</h4>

    <div class="mb-4 d-flex flex-wrap justify-content-center align-items-center gap-3">

        <div class="position-relative" style="width: 380px;">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="subcategorySearch" class="form-control search-input"
                placeholder="Search Departments...">
        </div>

        @php
            $totalLetterCount = 0;
            foreach ($groupedLetters as $categoryId => $subCats) {
                foreach ($subCats as $subCategoryId => $years) {
                    $totalLetterCount += collect($years)->flatten(2)->count();
                }
            }
        @endphp

        <div class="d-flex align-items-center fw-semibold" style="font-size: 0.95rem;" id="filteredLetterCount">
            <b>Total Issue Letters:</b> &nbsp;<span id="letterCountStatic">{{ $totalLetterCount }}</span>
        </div>
    </div>

    <div class="container-fluid">

        <div id="subcategoryCardList" class="card-grid">
            @foreach ($groupedLetters as $categoryId => $subCats)
                @foreach ($subCats as $subCategoryId => $years)
                    @php
                        $subCategoryName = $subCategories[$subCategoryId] ?? 'Others/Miscellaneous Departments';
                        $letterCount = collect($years)->flatten(2)->count();
                    @endphp
                    <div class="card-button" onclick="showOnlyThis('subcat-{{ $categoryId }}-{{ $subCategoryId }}')"
                        data-letter-count="{{ $letterCount }}">
                        <h5>{{ $subCategoryName }}</h5>
                        <p>Total letters: {{ $letterCount }}<br>View year & month-wise.</p>
                    </div>
                @endforeach
            @endforeach
        </div>


        @foreach ($groupedLetters as $categoryId => $subCats)
            @foreach ($subCats as $subCategoryId => $years)
                <div id="subcat-{{ $categoryId }}-{{ $subCategoryId }}" class="nested-section">
                    @foreach ($years as $year => $months)
                        <div class="mb-2 mt-3"><strong><i class="fa fa-calendar-alt"></i> Year: {{ $year }}</strong>
                        </div>
                        <div class="card-grid">
                            @foreach ($months as $month => $lettersGroup)
                                @php $monthSafe = sanitizeId($month); @endphp
                                <div class="month-card"
                                    onclick="toggleMonth('month-{{ $subCategoryId }}-{{ $year }}-{{ $monthSafe }}')">
                                    <div style="font-size: 1.4rem; color: #0d6efd;">{{ count($lettersGroup) }}</div>
                                    <span>{{ $month }}<br>Total Letters</span>
                                </div>
                            @endforeach
                        </div>

                        @foreach ($months as $month => $lettersGroup)
                            @php $monthSafe = sanitizeId($month); @endphp
                            <div id="month-{{ $subCategoryId }}-{{ $year }}-{{ $monthSafe }}"
                                class="nested-month">
                                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                    <button class="btn btn-sm btn-outline-secondary" onclick="showMonths(this)">
                                        <i class="fa fa-arrow-left"></i> Back to Months
                                    </button>

                                    <div style="max-width: 300px; width: 100%;">
                                        <input type="text" class="form-control table-search-input"
                                            placeholder="Search letters..."
                                            data-table-id="table-{{ $subCategoryId }}-{{ $year }}-{{ $monthSafe }}">
                                    </div>
                                </div>

                                <div class="mb-2"><strong>{{ $month }} {{ $year }} - Letters</strong>
                                </div>

                                <table class="letter-table"
                                    id="table-{{ $subCategoryId }}-{{ $year }}-{{ $monthSafe }}">
                                    <thead>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Received Date</th>
                                            <th>Letter No</th>
                                            <th>CRN No</th>
                                            <th>ECR No</th>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Download</th>
                                        </tr>
                                    </thead>
                                    <tbody class="paginated-body">
                                        @foreach ($lettersGroup as $index => $letter)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($letter->issue_date)->format('d-m-Y') }}
                                                </td>
                                                <td>{{ $letter->letter_no ?? 'N/A' }}</td>
                                                <td>{{ $letter->crn ?? 'N/A' }}</td>
                                                <td>{{ $letter->ecr_no ?? 'N/A' }}</td>
                                                <td>{{ $categories[$letter->letter_category_id] ?? 'N/A' }}</td>
                                                <td>{{ optional($letter->subCategory)->sub_category_name ?? ($letter->letter_other_sub_categories ?? 'Others/Miscellaneous Department') }}
                                                </td>
                                                <td>
                                                    <a href="{{ asset(str_replace('public/', 'storage/', $letter->letter_path)) }}"
                                                        class="btn btn-sm btn-outline-primary" target="_blank">Download</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div
                                    class="pagination-buttons mt-2 d-flex flex-wrap gap-2 justify-content-center align-items-center">
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @endforeach
        @endforeach
    </div>

    <script>
        const rowsPerPage = 25;

        function applyPagination($rows, $paginationContainer) {
            const totalPages = Math.ceil($rows.length / rowsPerPage);
            let currentPage = 1;

            function showPage(page) {
                currentPage = page;
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                $rows.hide().slice(start, end).show();
                $paginationContainer.empty();

                const $prevBtn = $('<button>', {
                    text: 'Previous',
                    class: 'btn btn-sm btn-outline-secondary',
                    disabled: currentPage === 1
                }).on('click', () => showPage(currentPage - 1));
                $paginationContainer.append($prevBtn);

                for (let i = 1; i <= totalPages; i++) {
                    const $btn = $('<button>', {
                        text: i,
                        class: 'btn btn-sm btn-outline-primary'
                    });
                    if (i === currentPage) $btn.addClass('active');
                    $btn.on('click', () => showPage(i));
                    $paginationContainer.append($btn);
                }

                const $nextBtn = $('<button>', {
                    text: 'Next',
                    class: 'btn btn-sm btn-outline-secondary',
                    disabled: currentPage === totalPages
                }).on('click', () => showPage(currentPage + 1));
                $paginationContainer.append($nextBtn);
            }

            if (totalPages > 0) showPage(1);
        }

        function paginateTables() {
            $('.nested-month').each(function() {
                const $monthSection = $(this);
                const $rows = $monthSection.find('tbody tr');
                const $paginationContainer = $monthSection.find('.pagination-buttons');
                if ($rows.length) applyPagination($rows, $paginationContainer);
            });
        }

        function toggleMonth(id) {
            const $current = $('#' + id);
            $current.show().siblings('.nested-month').hide();
            $current.closest('.nested-section').find('.card-grid').hide();
            setTimeout(() => paginateTables(), 50);
        }

        function showOnlyThis(id) {
            $('.nested-section, .nested-month').hide();
            $('#subcategoryCardList').hide();
            $('#resetView').show();
            $('#' + id).show();
        }

        function showMonths(button) {
            const $section = $(button).closest('.nested-section');
            $section.find('.nested-month').hide();
            $section.find('.card-grid').css('display', 'flex');
        }

        function filterSubcategories(query) {
            query = query.toLowerCase().trim();
            let totalVisible = 0;

            $('#subcategoryCardList').show();
            $('#resetView').hide();
            $('.nested-section, .nested-month').hide();

            $('#subcategoryCardList .card-button').each(function() {
                const $card = $(this);
                const match = $card.text().toLowerCase().includes(query);
                $card.toggle(match);
                if (match) totalVisible += parseInt($card.data('letter-count')) || 0;
            });

            $('#letterCountStatic').text(totalVisible);
        }

        $(document).ready(function() {
            paginateTables();

            $('#resetView').on('click', function() {
                $('.nested-section, .nested-month').hide();
                $('#subcategoryCardList').show();
                $('#resetView').hide();
                $('#subcategorySearch').val('');
                filterSubcategories('');
            });

            $('#subcategorySearch').on('input', function() {
                filterSubcategories($(this).val());
            });

            $(document).on('input', '.table-search-input', function() {
                const searchQuery = $(this).val().toLowerCase();
                const tableId = $(this).data('table-id');
                const $table = $('#' + tableId);
                const $rows = $table.find('tbody tr');
                const $paginationContainer = $table.closest('.nested-month').find('.pagination-buttons');

                $rows.each(function() {
                    const match = $(this).text().toLowerCase().includes(searchQuery);
                    $(this).toggle(match);
                });

                const $filteredRows = $rows.filter(':visible');
                if ($filteredRows.length) {
                    applyPagination($filteredRows, $paginationContainer);
                } else {
                    $paginationContainer.empty();
                }
            });
        });
    </script>
@endsection
