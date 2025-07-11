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

    <div class="col-md-12 mb-3">
        <button class="btn btn-dark btn-sm" id="resetView" style="display: none;">
            <i class="fa fa-arrow-left"></i> Back
        </button>
    </div>

    <h4 class="report-heading"><i class="fa fa-clipboard-list"></i> Receipt Letters Summary – Department-wise Overview</h4>

    <div class="mb-4 d-flex flex-wrap justify-content-center align-items-center gap-3">
        <div class="position-relative" style="width: 380px;">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="subcategorySearch" class="form-control search-input"
                placeholder="Search Departments...">
        </div>
        <div class="d-flex align-items-center fw-semibold" style="font-size: 0.95rem;" id="filteredLetterCount">
            <b> Total Issued Letters:</b> &nbsp;<span id="letterCountStatic">0</span>
        </div>
    </div>

    <div class="container-fluid">
        @php $totalLetterCount = 0; @endphp
        <div id="subcategoryCardList" class="card-grid">
            @foreach ($groupedLetters as $categoryId => $subCats)
                @foreach ($subCats as $subCategoryId => $years)
                    @php
                        $subCategoryName = $subCategories[$subCategoryId] ?? 'Unknown Subcategory';
                        $letterCount = collect($years)->flatten(2)->count();
                        $totalLetterCount += $letterCount;
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
                                <div class="month-card"
                                    onclick="toggleMonth('month-{{ $subCategoryId }}-{{ $year }}-{{ $month }}', this)">
                                    <div style="font-size: 1.4rem; color: #0d6efd;">{{ count($lettersGroup) }}</div>
                                    <span>{{ $month }}<br>Total Letters</span>
                                </div>
                            @endforeach
                        </div>

                        @foreach ($months as $month => $lettersGroup)
                            <div id="month-{{ $subCategoryId }}-{{ $year }}-{{ $month }}"
                                class="nested-month">
                                <div class="mb-2 mt-3"><strong>{{ $month }} {{ $year }} - Letters</strong>
                                </div>
                                <table class="letter-table">
                                    <thead>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Issue Date</th>
                                            <th>Letter No</th>
                                            <th>CRN No</th>
                                            <th>ECR No</th>
                                            <th>Action</th>
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
                                                <td>
                                                    <a href="{{ asset(str_replace('public/', 'storage/', $letter->letter_path)) }}"
                                                        class="btn btn-sm btn-outline-primary" target="_blank">
                                                        Download
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-buttons mt-2 d-flex flex-wrap gap-2"
                                    id="pagination-buttons-{{ $subCategoryId }}-{{ $year }}-{{ $month }}">
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @endforeach
        @endforeach
    </div>

    <script>
        const rowsPerPage = 5;

        function paginateTables() {
            document.querySelectorAll('.nested-month').forEach(monthSection => {
                const tableBody = monthSection.querySelector('.paginated-body');
                const rows = Array.from(tableBody.querySelectorAll('tr'));
                const paginationContainer = monthSection.querySelector('.pagination-buttons');

                if (!rows.length) return;

                const totalPages = Math.ceil(rows.length / rowsPerPage);
                let currentPage = 1;

                function showPage(page) {
                    currentPage = page;
                    const start = (page - 1) * rowsPerPage;
                    const end = start + rowsPerPage;

                    rows.forEach((row, i) => {
                        row.style.display = (i >= start && i < end) ? 'table-row' : 'none';
                    });

                    paginationContainer.innerHTML = '';
                    for (let i = 1; i <= totalPages; i++) {
                        const btn = document.createElement('button');
                        btn.innerText = i;
                        btn.className = 'btn btn-sm btn-outline-primary';
                        if (i === currentPage) btn.classList.add('active');
                        btn.addEventListener('click', () => showPage(i));
                        paginationContainer.appendChild(btn);
                    }
                }

                showPage(1);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            paginateTables();

            let total = 0;
            document.querySelectorAll('#subcategoryCardList .card-button').forEach(card => {
                total += parseInt(card.dataset.letterCount) || 0;
            });
            document.getElementById('letterCountStatic').innerText = total;
        });

        function showOnlyThis(id) {
            document.querySelectorAll('.nested-section').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.nested-month').forEach(el => el.style.display = 'none');
            document.getElementById('subcategoryCardList').style.display = 'none';
            document.getElementById('resetView').style.display = 'inline-block';
            document.getElementById(id).style.display = 'block';
        }

        function toggleMonth(id) {
            const current = document.getElementById(id);
            if (!current) return;
            const parent = current.closest('.nested-section');
            parent.querySelectorAll('.nested-month').forEach(el => el.style.display = 'none');
            current.style.display = 'block';
            paginateTables(); // Refresh pagination for this month
        }

        document.getElementById('resetView').addEventListener('click', function() {
            document.querySelectorAll('.nested-section').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.nested-month').forEach(el => el.style.display = 'none');
            document.getElementById('subcategoryCardList').style.display = 'flex';
            document.getElementById('resetView').style.display = 'none';
            document.getElementById('subcategorySearch').value = '';
            filterSubcategories('');
        });

        document.getElementById('subcategorySearch').addEventListener('input', function() {
            filterSubcategories(this.value);
        });

        function filterSubcategories(query) {
            query = query.toLowerCase().trim();
            const cards = document.querySelectorAll('#subcategoryCardList .card-button');
            let totalVisible = 0;
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                const match = text.includes(query);
                card.style.display = match ? 'flex' : 'none';
                if (match) {
                    totalVisible += parseInt(card.dataset.letterCount) || 0;
                }
            });
            document.getElementById('letterCountStatic').innerText = totalVisible;
        }
    </script>
@endsection
