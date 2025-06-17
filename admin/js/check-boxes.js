document.addEventListener("DOMContentLoaded", function () {

    // Bind checkbox events on page load
    function bindCheckboxEvents() {
        document.querySelectorAll('#myTable input[type="checkbox"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', handleCheckboxChange);
        });
    }

    // Handles enabling/disabling action buttons based on checkbox state
    function handleCheckboxChange() {
        const path = window.location.pathname;
        const page = path.split("/").pop();
        const checkedCount = document.querySelectorAll('#myTable input[type="checkbox"]:checked').length;

        // Enable/disable delete button
        toggleButton('deleteSelected', checkedCount > 0);

        // Enable/disable block/unblock button based on current page
        if (page === "blocked.php") {
            toggleButton('unblockSelected', checkedCount > 0);
        } else {
            toggleButton('blockSelected', checkedCount > 0);
        }
    }

    // Utility function to enable/disable a button
    function toggleButton(id, enable) {
        const btn = document.getElementById(id);
        if (enable) {
            btn.classList.remove('disabled');
        } else {
            btn.classList.add('disabled');
        }
    }

    // Handle "Check All" checkbox click event
    function bindCheckAllEvent() {
        const checkAll = document.querySelector('#myTable #checkAll');
        checkAll.addEventListener('click', function () {
            const isChecked = this.checked;
            // Apply check/uncheck to all body checkboxes
            document.querySelectorAll('#myTable tbody input[type="checkbox"]').forEach(function (cb) {
                cb.checked = isChecked;
                cb.dispatchEvent(new Event('change'));  // trigger individual checkbox event
            });
        });
    }

    // Sync the "Check All" checkbox status based on individual checkboxes
    function bindIndividualCheckboxesSync() {
        const checkboxes = document.querySelectorAll('#myTable tbody input[type="checkbox"]');
        const checkAll = document.querySelector('#myTable #checkAll');

        checkboxes.forEach(function (cb) {
            cb.addEventListener('click', function () {
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                checkAll.checked = allChecked;
            });
        });
    }

    // Initial bindings when page is first loaded
    bindCheckboxEvents();
    bindCheckAllEvent();
    bindIndividualCheckboxesSync();

    // Handle DataTables redraw: rebind checkboxes after table pagination/filter redraw
    const dataTable = new DataTable(document.querySelector('#myTable'));
    dataTable.on('draw', function () {
        bindCheckboxEvents();
        bindCheckAllEvent();
        bindIndividualCheckboxesSync();
    });

});
