document.addEventListener("DOMContentLoaded", function () {
    let rowCount = 1;

    document.getElementById("add-row").addEventListener("click", function () {
        rowCount++;

        const newRow = document.createElement("div");
        newRow.classList.add("row", "mb-4", "align-items-center");
        newRow.id = "row-" + rowCount;

        // إنشاء خيارات القائمة select ديناميكيًا من window.grades
        let optionHTML = `<option value="" disabled selected class="text-muted">${window.keywords.gradeselect_option}</option>`;
        if (Array.isArray(window.grades)) {
            window.grades.forEach((grade) => {
                optionHTML += `<option value="${grade.id}">${grade.name}</option>`;
            });
        }

        newRow.innerHTML = `
            <div class="col-md-4">
                <input type="text" name="inputs[${rowCount - 1}][text]" class="form-control" placeholder="${window.keywords.classroom_name}">
            </div>
            <div class="col-md-4">
                <select name="inputs[${rowCount - 1}][select]" class="form-control">
                    ${optionHTML}
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2 justify-content-center">
                <button type="button" class="btn btn-danger remove-row">${window.keywords.remove_row}</button>
            </div>
        `;

        document.getElementById("repeater").appendChild(newRow);
    });

    document.addEventListener("click", function (e) {
        if (e.target && e.target.classList.contains("remove-row")) {
            e.target.closest(".row").remove();
        }
    });
});
