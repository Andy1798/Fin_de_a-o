document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#date_range", {
        mode: "range",
        dateFormat: "d/m/Y",
        locale: "es",
        onChange: function (selectedDates) {
            if (selectedDates.length === 2) {
                const startDate = flatpickr.formatDate(selectedDates[0], "d/m/Y");
                const endDate = flatpickr.formatDate(selectedDates[1], "d/m/Y");
                document.getElementById("date_range").value = `${startDate} a ${endDate}`;
                let startInput = document.createElement("input");
                startInput.type = "hidden";
                startInput.name = "start_date";
                startInput.value = flatpickr.formatDate(selectedDates[0], "Y-m-d");
                let endInput = document.createElement("input");
                endInput.type = "hidden";
                endInput.name = "end_date";
                endInput.value = flatpickr.formatDate(selectedDates[1], "Y-m-d");
                const form = document.getElementById("dateFilterForm");
                const oldInputs = form.querySelectorAll("input[name='start_date'], input[name='end_date']");
                oldInputs.forEach(input => input.remove());
                form.appendChild(startInput);
                form.appendChild(endInput);
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const loadingOverlay = document.getElementById('loading-overlay');
    const sidebarLinks = document.querySelectorAll('.sidebar a[href]');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            if (!loadingOverlay.style.display || loadingOverlay.style.display === 'none') {
                loadingOverlay.style.display = 'flex';
            }
        });
    });
});