@extends('layouts.app')

@section('content')
    <style>
        .folder,
        .year-folder,
        .month-folder {
            cursor: pointer;
            padding: 10px 16px;
            margin: 6px 0;
            background-color: #f1f1f1;
            border-radius: 6px;
            font-weight: 500;
        }

        .nested-folder {
            margin-left: 20px;
            display: none;
        }

        .pdf-list {
            margin-left: 40px;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .pdf-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #eef;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 6px;
        }

        .letter-row {
            display: none;
            justify-content: space-between;
            align-items: center;
            padding: 6px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 5px;
        }

        .letter-info span {
            margin-right: 10px;
        }

        .pagination-buttons {
            margin-top: 10px;
        }

        .pagination-buttons button {
            margin-right: 5px;
            padding: 4px 10px;
            font-size: 13px;
        }

        #subcategorySearch {
            max-width: 300px;
        }

        @media (max-width: 768px) {
            .letter-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }
        }
    </style>

    <div class="col-md-12 mb-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <button class="btn btn-dark btn-sm" id="resetView">
                <i class="fa fa-arrow-left"></i> Back
            </button>

            <h4 class="m-0 flex-grow-1 text-center">
                <strong>📁 Letter Download (Issue - By Ministry)</strong>
            </h4>

            <input type="text" class="form-control form-control-sm" id="subcategorySearch"
                placeholder="🔍 Search Ministry..." style="max-width: 300px;">
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @php $serial = 1; @endphp

                    @foreach ($groupedLetters as $categoryId => $subCats)
                        @foreach ($subCats as $subCategoryId => $years)
                            @php $subCategoryName = $subCategories[$subCategoryId] ?? 'Unknown Subcategory'; @endphp

                            <div class="folder subcat-folder"
                                onclick="toggleFolder('subcat-{{ $categoryId }}-{{ $subCategoryId }}')">
                                📂 {{ $serial++ }}. {{ $subCategoryName }}
                            </div>

                            <div id="subcat-{{ $categoryId }}-{{ $subCategoryId }}" class="nested-folder">
                                @foreach ($years as $year => $months)
                                    <div class="year-folder"
                                        onclick="toggleFolder('year-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}')">
                                        📁 {{ $year }} — Total Months: {{ count($months) }}
                                    </div>

                                    <div id="year-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}"
                                        class="nested-folder">
                                        <div class="pdf-link">
                                            <span><strong>📅 Year: {{ $year }}</strong></span>
                                            <a href="{{ route('pdf.merge.Issue', [$categoryId, $subCategoryId, $year]) }}"
                                                class="btn btn-sm btn-outline-success" target="_blank">
                                                📎 Download Year-wise PDF
                                            </a>
                                        </div>

                                        @foreach ($months as $month => $lettersGroup)
                                            <div class="month-folder"
                                                onclick="toggleFolder('month-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}-{{ $month }}')">
                                                <div class="pdf-link mb-2">
                                                    🗓️ {{ $month }} —
                                                    Letters:<strong>{{ count($lettersGroup) }}</strong>
                                                    <a href="{{ route('pdf.merge.month.Issue', [$categoryId, $subCategoryId, $year, $month]) }}"
                                                        class="btn btn-sm btn-outline-primary" target="_blank"
                                                        style="margin-left: 10px;">
                                                        📎 Download Month-wise PDF
                                                    </a>
                                                </div>
                                            </div>

                                            <div id="month-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}-{{ $month }}"
                                                class="pdf-list">
                                                @foreach ($lettersGroup as $index => $letter)
                                                    <div class="letter-row" data-index="{{ $index }}"
                                                        data-group="letters-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}-{{ $month }}">
                                                        <div class="letter-info">
                                                            <span class="letter-date">📅
                                                                {{ \Carbon\Carbon::parse($letter->issue_date)->format('d-m-Y') }}</span>
                                                            <span class="letter-no">📨
                                                                {{ $letter->letter_no ?? 'No Letter No' }}</span>
                                                            <span class="letter-crn">🔖
                                                                {{ $letter->crn ?? 'No CRN' }}</span>
                                                        </div>
                                                        <a href="{{ asset(str_replace('public/', 'storage/', $letter->letter_path)) }}"
                                                            class="btn btn-sm btn-outline-primary" target="_blank">
                                                            ⬇️ Download
                                                        </a>
                                                    </div>
                                                @endforeach

                                                <div class="pagination-buttons"
                                                    id="pagination-{{ $categoryId }}-{{ $subCategoryId }}-{{ $year }}-{{ $month }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('resetView').addEventListener('click', function() {
            window.location.href = "{{ route('dashboard') }}";
        });

        function toggleFolder(id) {
            const el = document.getElementById(id);
            if (!el) return;

            const parent = el.parentElement;
            Array.from(parent.children).forEach(child => {
                if ((child.classList.contains('nested-folder') || child.classList.contains('pdf-list')) && child
                    .id !== id) {
                    child.style.display = 'none';
                }
            });

            el.style.display = (el.style.display === "none" || el.style.display === "") ? "block" : "none";

            if (el.classList.contains('pdf-list') && el.style.display === "block") {
                const idParts = id.split("-");
                const groupKey = `letters-${idParts[1]}-${idParts[2]}-${idParts[3]}-${idParts[4]}`;
                paginateLetters(groupKey, 0);
            }
        }

        function paginateLetters(group, page) {
            const rows = document.querySelectorAll(`[data-group="${group}"]`);
            const containerId = "pagination-" + group.split("letters-")[1];
            const perPage = 25;
            const total = rows.length;
            const totalPages = Math.ceil(total / perPage);

            rows.forEach(row => row.style.display = 'none');

            for (let i = page * perPage; i < (page + 1) * perPage && i < total; i++) {
                rows[i].style.display = 'flex';
            }

            const paginationContainer = document.getElementById(containerId);
            paginationContainer.innerHTML = '';

            for (let i = 0; i < totalPages; i++) {
                const btn = document.createElement('button');
                btn.className = 'btn btn-sm btn-outline-dark';
                btn.innerText = `${i * perPage + 1} - ${Math.min((i + 1) * perPage, total)}`;
                btn.onclick = () => paginateLetters(group, i);
                paginationContainer.appendChild(btn);
            }
        }

        document.getElementById("subcategorySearch").addEventListener("input", function() {
            const query = this.value.toLowerCase().trim();
            const folders = document.querySelectorAll(".folder.subcat-folder");

            folders.forEach(folder => {
                const text = folder.textContent.toLowerCase();
                const match = text.includes(query);
                folder.style.display = match ? "block" : "none";

                const nested = folder.nextElementSibling;
                if (nested && nested.classList.contains("nested-folder")) {
                    nested.style.display = "none";
                }
            });
        });
    </script>
@endsection
