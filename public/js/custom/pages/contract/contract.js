document.addEventListener("DOMContentLoaded", () => {
    function getElement(elt) {
        return document.querySelector(elt);
    };
    const valueContractElt = getElement("#value-contract");
    // const saveBtn = getElement("#kt_toolbar_primary_button");
    const numberContract = getElement("#number-contract");
    const projectName = getElement("#project-name");
    const startDate = getElement("#start-date");
    const dueDate = getElement("#due-date");
    const numberSPK = getElement("#number-spk");
    const csrf_token = getElement("#csrf-token");
    const statusMsg = getElement("#status-msg");
    // saveBtn.addEventListener("click", saveDataDraft);
    valueContractElt.addEventListener("keyup", reformatNumber);

    // startDate.disabled = true;
    // dueDate.disabled = true;

    function reformatNumber() {
        const valueFormatted = Intl.NumberFormat("en-US", {
            maximumFractionDigits: 0,
        }).format(valueContractElt.value.toString().replace(/[^0-9]/gi, ""));
        valueContractElt.value = valueFormatted;
    }
    async function saveDataDraft() {
        const valueContract = valueContractElt.value;

        if (numberContract.value == "" || projectName.value == "" || startDate.value == "" || dueDate.value == "" || numberSPK.value == "" || csrf_token.value == "" || valueContract.value == "") {
            statusMsg.style.color = "#d43328";
            statusMsg.style.display = "block";
            statusMsg.innerHTML = `&#10060;	Please fill the empty input form`
            return;
        }
        statusMsg.style.display = "none";
        const data = {
            "_token": csrf_token.value,
            "number_contract": numberContract.value,
            "project_name": projectName.value,
            "start_date": startDate.value,
            "due_date": dueDate.value,
            "number_spk": numberSPK.value,
            "value_contract": valueContract.toString().replaceAll(/[^0-9]/gi, "")
        };
        const result = await fetch(`/contract-management/save/${data.number_contract}`, {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "content-type": "application/json"
            }
        }).then(res => res.json());
        if (result.status == "Success") {
            statusMsg.style.color = "#33d428";
            statusMsg.style.display = "block";
            statusMsg.innerHTML = `&#10003; ${result.message}`;
        } else {
            statusMsg.style.color = "#d43328";
            statusMsg.style.display = "block";
            statusMsg.innerHTML = `&#10060;	${result.message}`;
        }
    };

    // Draft Contract
    const saveDraftElt = getElement("#save-draft");
    const attachFileElt = getElement("#attach-file-draft");
    const documentNameElt = getElement("#document-name-draft");
    const noteElt = getElement("#note-draft");
    const textError = getElement("#file-error-msg");
    let file = "";
    attachFileElt.addEventListener("change", e => {
        file = e.target.files[0];
        if (file.type != "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
            textError.style.display = "block";
            textError.innerText = "Make sure you attach .docx format only";
            return;
        }
        textError.style.display = "none";
        documentNameElt.value = file.name;
    });

    saveDraftElt.addEventListener("click", async () => {
        const csrfTokenFileDraft = getElement("#csrf_token_file_draft");
        const file = attachFileElt.files[0];
        const formData = new FormData();
        var fileName = documentNameElt.value;
        if (!fileName.includes(".docx")) {
            fileName = `${fileName}.docx`;
        }
        formData.append("_token", csrfTokenFileDraft.value);
        formData.append("file", file);
        formData.append("id-contract", numberContract.value);
        formData.append("file-name", fileName);
        formData.append("draft-note", noteElt.value);
        formData.append("tender-menang", false);
        const uploadFile = await fetch("/draft-contract/upload", {
            method: "POST",
            body: formData,
        }).then(res => res.json());
        // console.log(uploadFile);
        if (uploadFile.status == "Login Required") {
            window.location.href = `${uploadFile.link}&id-contract=${numberContract.value}`;
        }
    });

    // Open Docs File
    const linkBtn = document.querySelectorAll(".link-docs");
    linkBtn.forEach(elt => {
        elt.addEventListener("click", async e => {
            e.stopPropagation();
            const idDocument = e.target.getAttribute("data-id-document");
            const csrf_token = e.target.getAttribute("data-token");
            const data = {
                _token: csrf_token,
                id_document: idDocument
            }
            const result = await fetch("/document/view", {
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "content-type": "application/json"
                }
            }).then(res => res.json());
            if (result.link) {
                window.location.href = result.link + `&id_document=${idDocument}`;
            }
            // console.log(idDocument);
            if (result.link_document) {
                // console.log(result.link_document);
                window.location.href = result.link_document;
            }
            // console.log(result);
        })
    })

    let month = 1;
    let year = 2020;
    let date = -1;
    let monthFix = 1;
    let yearFix = 2020;
    let dateFix = -1;
    let monthEndFix = 1;
    let yearEndFix = 2020;
    let dateEndFix = -1;

    // Begin Function Calendar Start
    const months = document.querySelector(`#start-date #calendar__month`);
    const years = document.querySelector(`#start-date #calendar__year`);
    months.addEventListener("change", elt => {
        month = elt.target.value;
        if (month == 2) {
            let html = ``;
            for (let i = 0; i < 29; i += 1) {
                if (i + 1 <= dateFix && yearFix == year && month == monthFix) {
                    html += `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && yearFix == year && month == monthFix) {
                    html += `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }
            const updateDates = document.querySelector(`#start-date .calendar__body .calendar__dates`);
            updateDates.innerHTML = html;
        } else {
            let html = ``;
            for (let i = 0; i < 31; i += 1) {
                if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                    html += `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;

                } else if (i + 1 == dateEndFix && yearFix == year && month == monthFix) {
                    html += `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }
            const updateDates = document.querySelector(`#start-date .calendar__body .calendar__dates`);
            updateDates.innerHTML = html;

        }
        setDateClickable("#start-date");
    });
    years.addEventListener("change", elt => {
        year = elt.target.value;
        if (yearEnd == year) {
            let html = ``;
            for (let i = 0; i < 31; i += 1) {
                if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                    html += `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }
            const updateDates = document.querySelector(`#start-date .calendar__body .calendar__dates`);
            updateDates.innerHTML = html;

        } else {
            let html = ``;
            for (let i = 0; i < 31; i += 1) {
                if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                    html += `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }
            const updateDates = document.querySelector(`#start-date .calendar__body .calendar__dates`);
            updateDates.innerHTML = html;


        }
        setDateClickable("#start-date");
    });

    setDateClickable("#start-date");

    function setDateClickable(rootElt) {
        const dates = document.querySelectorAll(`${rootElt} .calendar__body .calendar__dates .calendar__date`);
        dates.forEach(elt => {
            elt.addEventListener("click", e => {
                dates.forEach(d => {
                    if (d.classList.contains("calendar__date--selected")) {
                        d.classList.remove("calendar__date--selected");
                        d.classList.remove("calendar__date--range-end");
                        d.classList.remove("calendar__date--first-date");
                    }
                });

                if (elt.classList.contains("calendar__date--selected")) {
                    elt.classList.remove("calendar__date--selected");
                    elt.classList.remove("calendar__date--range-end");
                    elt.classList.remove("calendar__date--first-date");
                } else {
                    if (rootElt.toString().match("end")) {
                        dateEnd = Number(elt.firstElementChild.innerText);
                        const dateStart = document.querySelectorAll(`#start-date .calendar__body .calendar__dates .calendar__date`);
                        dateStart.forEach((d, i) => {
                            if (i + 1 == dateEndFix) {
                                d.classList.add("calendar__date--range-start");
                            } else {
                                d.classList.remove("calendar__date--range-start");
                            }
                        });
                    } else {
                        date = Number(elt.firstElementChild.innerText);
                        const dateEnd = document.querySelectorAll(`#end-date .calendar__body .calendar__dates .calendar__date`);
                        dateEnd.forEach((d, i) => {
                            if (i + 1 <= date && monthEndFix < month) {
                                // d.classList.add("calendar__date--range-start");
                                d.classList.add("calendar__date--grey");
                            } else {
                                d.classList.remove("calendar__date--range-start");
                            }
                        });
                    }
                    elt.classList.add("calendar__date--selected");
                    elt.classList.add("calendar__date--range-end");
                    elt.classList.add("calendar__date--first-date");
                }
            });
        });
    }

    const setCalendarStartBtn = getElement("#set-calendar-start");
    setCalendarStartBtn.addEventListener("click", e => {
        startDate.setAttribute("value", `${year}-${month.toString().length < 2 ? month.toString().padStart(2, "0") : month}-${date.toString().length < 2 ? date.toString().padStart(2, "0") : date}`);
        dateFix = date;
        monthFix = month;
        yearFix = year;
        let html = ``;
        if (monthEnd == 2) {
            let html = ``;
            for (let i = 0; i < 29; i += 1) {
                if (i + 1 <= dateFix && yearEndFix == yearEnd && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }
            const updateDates = document.querySelector(`#end-date .calendar__body .calendar__dates`);
            updateDates.innerHTML = html;
        } else {
            for (let i = 0; i < 31; i += 1) {
                if (i + 1 <= dateFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }
        }
        const updateDates = document.querySelector(`#end-date .calendar__body .calendar__dates`);
        updateDates.innerHTML = html;
        setDateClickable("#end-date");
    })
    // End Function Calendar Start

    // Begin Function Calendar End
    const monthsEnd = document.querySelector(`#end-date #calendar__month`);
    const yearsEnd = document.querySelector(`#end-date #calendar__year`);
    let dateEnd = -1;
    let monthEnd = 1;
    let yearEnd = 2020;
    monthsEnd.addEventListener("change", elt => {
        monthEnd = elt.target.value;
        if (monthEnd == 2) {
            let html = ``;
            for (let i = 0; i < 29; i += 1) {
                if (i + 1 <= dateFix && yearEndFix == yearEnd && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--first-date calendar__date--range-end"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }
            const updateDates = document.querySelector(`#end-date .calendar__body .calendar__dates`);
            updateDates.innerHTML = html;
        } else {
            // calendar__date--grey
            let html = ``;
            for (let i = 0; i < 31; i += 1) {
                if (i + 1 <= dateFix && yearEndFix == yearEnd && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--first-date calendar__date--range-end"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }
            const updateDates = document.querySelector(`#end-date .calendar__body .calendar__dates`);
            updateDates.innerHTML = html;


        }
        setDateClickable("#end-date");
    });
    yearsEnd.addEventListener("change", elt => {
        yearEnd = elt.target.value;
        let html = ``;
        if (yearEnd == year) {
            for (let i = 0; i < 31; i += 1) {
                if (i + 1 <= dateFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }
        } else {
            for (let i = 0; i < 31; i += 1) {
                if (i + 1 <= dateFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }

        }
        const updateDates = document.querySelector(`#end-date .calendar__body .calendar__dates`);
        updateDates.innerHTML = html;

        setDateClickable("#end-date");
    });

    setDateClickable("#end-date");

    // Begin Set Input Date Value
    const setCalendarEndBtn = getElement("#set-calendar-end");
    setCalendarEndBtn.addEventListener("click", e => {
        dueDate.setAttribute("value", `${yearEnd}-${monthEnd.toString().length < 2 ? monthEnd.toString().padStart(2, "0") : monthEnd}-${dateEnd.toString().length < 2 ? dateEnd.toString().padStart(2, "0") : dateEnd}`);
        dateEndFix = dateEnd;
        monthEndFix = monthEnd;
        yearEndFix = yearEnd;
        let html = ``;
        if (monthEndFix == 2) {
            for (let i = 0; i < 29; i += 1) {
                if (i + 1 == dateFix && year == yearEndFix && monthEndFix == monthEnd) {
                    // html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                    html += `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;

                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }
        } else {
            for (let i = 0; i < 31; i += 1) {
                if (i + 1 == dateFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                    // html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }
        }
        const updateDates = document.querySelector(`#start-date .calendar__body .calendar__dates`);
        updateDates.innerHTML = html;
        setDateClickable("#start-date");

    })
    // END Set Input Date Value
    // End Function Calendar End

    // Begin Cancel Dates Value
    const cancelDateStartBtn = getElement("#cancel-date-btn-start");
    cancelDateStartBtn.addEventListener("click", e => {
        date = dateFix;
        month = monthFix;
        year = yearFix;
        let html = ``;
        if (monthEndFix == 2) {
            for (let i = 0; i < 29; i += 1) {
                if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                    html += `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }

        } else {
            for (let i = 0; i < 31; i += 1) {
                if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                    html += `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }

        }
        const updateDates = document.querySelector(`#start-date .calendar__body .calendar__dates`);
        updateDates.innerHTML = html;
        setDateClickable("#start-date");
        // dateEnd = dateEndFix;
        // monthEnd = monthEndFix;
        // yearEnd = yearEndFix;
    });
    const cancelDateEndBtn = getElement("#cancel-date-btn-end");
    cancelDateEndBtn.addEventListener("click", e => {
        // date = dateFix;
        // month = monthFix;
        // year = yearFix;
        dateEnd = dateEndFix;
        monthEnd = monthEndFix;
        yearEnd = yearEndFix;
        let html = ``;
        if (monthEndFix == 2) {
            for (let i = 0; i < 29; i += 1) {
                if (i + 1 <= dateFix && yearFix == year && month == monthFix) {
                    html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--first-date calendar__date--range-end"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }
        } else {
            for (let i = 0; i < 31; i += 1) {
                if (i + 1 <= dateFix && yearFix == year && month == monthFix) {
                    html += `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
                } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                    html += `<div class="calendar__date calendar__date--first-date calendar__date--range-end"><span>${i + 1}</span></div>`;
                } else {
                    html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
                }
            }
        }
        const updateDates = document.querySelector(`#end-date .calendar__body .calendar__dates`);
        updateDates.innerHTML = html;
        setDateClickable("#end-date");
    });
    // End Cancel Dates Value

})
// Convert DOCX format to HTML tag
async function readFile(file, elt) {
    const docx2html = require("docx2html");
    const html = await docx2html(file);
    document.querySelector(` ${elt} > .fr-wrapper > .fr-view`).innerHTML = html;
    document.querySelector(`body > #A`).remove();
    return html;
};

// Save Data Review
async function saveReview() {
    const csrfTokenFileDraft = getElement("#csrf_token_file_review");
    const fileName = getElement("#document-name-review").value;
    const note = getElement("#note-review").value;
    const file = getElement("#attach-file-review").files[0];
    const formData = new FormData();
    if (!fileName.includes(".docx")) {
        fileName = `${fileName}.docx`;
    }
    formData.append("_token", csrfTokenFileDraft.value);
    formData.append("file", file);
    formData.append("id-contract", numberContract.value);
    formData.append("file-name", fileName);
    formData.append("draft-note", note);
    formData.append("tender-menang", false);
    const uploadFile = await fetch("/review-contract/upload", {
        method: "POST",
        body: formData,
    }).then(res => res.json());
    // console.log(uploadFile);
    if (uploadFile.status == "Login Required") {
        window.location.href = `${uploadFile.link}&id-contract=${numberContract.value}`;
    }
}


function setCalendar() {

}