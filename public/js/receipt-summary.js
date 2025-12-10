(function () {

  const ROWS_PER_PAGE = 25;
  function paginate(rows, container) {
    if (!rows.length) return;

    const pages = Math.ceil(rows.length / ROWS_PER_PAGE);
    let page = 1;

    function showPage(p) {
      page = Math.min(Math.max(p, 1), pages);

      const start = (page - 1) * ROWS_PER_PAGE;
      const end = start + ROWS_PER_PAGE;

      rows.forEach((row, i) => {
        row.style.display = i >= start && i < end ? "" : "none";
      });

      container.innerHTML = "";
      if (pages <= 1) return;

      for (let i = 1; i <= pages; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        btn.className = "btn btn-sm btn-outline-primary" + (i === page ? " active" : "");
        btn.onclick = () => showPage(i);
        container.appendChild(btn);
      }
    }

    showPage(1);
  }

  function initPagination() {
    document.querySelectorAll(".nested-month").forEach(section => {
      const rows = [...section.querySelectorAll("tbody tr")];
      const box = section.querySelector(".pagination-buttons");
      if (box) paginate(rows, box);
    });
  }
  window.toggleMonth = id => {
    document.querySelectorAll(".nested-month").forEach(m => {
      m.style.display = "none";
    });

    const show = document.getElementById(id);
    if (show) show.style.display = "";

    setTimeout(initPagination, 20);
  };

  window.showOnlyThis = id => {
    document.querySelectorAll(".nested-section, .nested-month").forEach(e => (e.style.display = "none"));

    document.getElementById("subcategoryCardList").style.display = "none";
    document.getElementById("resetView").style.display = "";

    const el = document.getElementById(id);
    if (el) el.style.display = "";

    setTimeout(() => el?.querySelector("button, a")?.focus(), 50);
  };

  window.showMonths = btn => {
    const box = btn.closest(".nested-section");
    box?.querySelectorAll(".nested-month").forEach(m => (m.style.display = "none"));
    box?.querySelectorAll(".card-grid").forEach(g => (g.style.display = "flex"));
  };

  function searchTables() {
    document.addEventListener("input", e => {
      const el = e.target;

      if (el.classList.contains("table-search-input")) {
        const query = el.value.toLowerCase();
        const table = document.getElementById(el.dataset.tableId);
        const rows = [...table.querySelectorAll("tbody tr")];
        const box = table.closest(".nested-month").querySelector(".pagination-buttons");

        const visible = rows.filter(r => {
          const ok = r.textContent.toLowerCase().includes(query);
          r.style.display = ok ? "" : "none";
          return ok;
        });

        box.innerHTML = "";
        if (visible.length) paginate(visible, box);
      }

      if (el.id === "subcategorySearch") {
        const q = el.value.toLowerCase();
        document.getElementById("subcategoryCardList").style.display = "";
        document.getElementById("resetView").style.display = "none";

        document.querySelectorAll(".card-button").forEach(card => {
          card.style.display = card.textContent.toLowerCase().includes(q) ? "" : "none";
        });
      }
    });
  }

  function initReset() {
    const btn = document.getElementById("resetView");
    if (!btn) return;

    btn.addEventListener("click", () => {
      document.querySelectorAll(".nested-section, .nested-month").forEach(e => (e.style.display = "none"));
      document.getElementById("subcategoryCardList").style.display = "";
      btn.style.display = "none";

      const s = document.getElementById("subcategorySearch");
      if (s) s.value = "";
    });
  }

  function start() {
    initPagination();
    searchTables();
    initReset();
  }

  document.readyState !== "loading"
    ? start()
    : document.addEventListener("DOMContentLoaded", start);

})();
