document.getElementById('resetView').onclick = () =>
    window.location.href = resetRoute;

function showCategory(id) {
    document.querySelectorAll('.category-folder').forEach(e => e.style.display = 'none');
    document.querySelectorAll('.category-content').forEach(e => e.style.display = 'none');

    document.getElementById('cat-' + id).style.display = 'block';
    document.getElementById('backToCategories').style.display = 'inline-block';
}

function backToCategories() {
    document.querySelectorAll('.category-folder').forEach(e => e.style.display = 'block');
    document.querySelectorAll('.category-content').forEach(e => e.style.display = 'none');
    document.getElementById('backToCategories').style.display = 'none';
}

function toggleFolder(id) {
    const el = document.getElementById(id);
    if (!el) return;

    el.classList.toggle('active');

    if (id.startsWith('month-') && el.classList.contains('active')) {
        const parts = id.split("-");
        const groupKey = `letters-${parts[1]}-${parts[2]}-${parts[3]}`;
        paginateLetters(groupKey, 0);
    }
}

function paginateLetters(group, page) {
    const rows = document.querySelectorAll(`[data-group="${group}"]`);
    const containerId = "pagination-" + group.replace("letters-", "");
    const perPage = 25;
    const total = rows.length;
    const totalPages = Math.ceil(total / perPage);

    rows.forEach(r => r.style.display = 'none');

    const start = page * perPage;
    const end = Math.min(start + perPage, total);

    for (let i = start; i < end; i++) {
        rows[i].style.display = 'flex';
    }

    const pagination = document.getElementById(containerId);
    pagination.innerHTML = '';

    for (let i = 0; i < totalPages; i++) {
        const btn = document.createElement('button');
        btn.className = 'btn btn-sm btn-outline-dark';
        btn.innerText = `${i * perPage + 1} - ${Math.min((i + 1) * perPage, total)}`;
        btn.onclick = () => paginateLetters(group, i);
        pagination.appendChild(btn);
    }
}

function filterLetters(input, containerId) {
    const search = input.value.toLowerCase();
    const container = document.getElementById(containerId);
    const rows = container.querySelectorAll('.letter-row');

    rows.forEach(row =>
        row.style.display = row.innerText.toLowerCase().includes(search) ? 'flex' : 'none'
    );

    const paginationId = 'pagination-' + containerId.replace("letter-container-", "");
    const pagination = document.getElementById(paginationId);

    if (search.trim()) {
        pagination.style.display = 'none';
    } else {
        pagination.style.display = 'block';
        const groupKey = 'letters-' + containerId.replace("letter-container-", "");
        paginateLetters(groupKey, 0);
    }
}
