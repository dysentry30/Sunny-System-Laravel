let month = 1;
let year = 2020;
let date = -1;
let monthFix = 1;
let yearFix = 2020;
let dateFix = -1;
let monthEndFix = 1;
let yearEndFix = 2020;
let dateEndFix = -1;
const startDate = document.querySelector("#draft-contract-start-date");

// Begin Function Calendar Start
const months = document.querySelector(`#calendar__month`);

const years = document.querySelector(`#calendar__year`);
months.addEventListener("change", elt => {
    month = elt.target.value;
    if (month == 2) {
        let html = ``;
        for (let i = 0; i < 29; i += 1) {
            if (i + 1 <= dateFix && yearFix == year && month == monthFix) {
                html +=
                    `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
            } else if (i + 1 == dateEndFix && yearFix == year && month == monthFix) {
                html +=
                    `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
            } else {
                html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
            }
        }
        const updateDates = document.querySelector(
            `#start-date .calendar__body .calendar__dates`);
        updateDates.innerHTML = html;
    } else {
        let html = ``;
        for (let i = 0; i < 31; i += 1) {
            if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                html +=
                    `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;

            } else if (i + 1 == dateEndFix && yearFix == year && month == monthFix) {
                html +=
                    `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
            } else {
                html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
            }
        }
        const updateDates = document.querySelector(
            `#start-date .calendar__body .calendar__dates`);
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
                html +=
                    `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
            } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                html +=
                    `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
            } else {
                html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
            }
        }
        const updateDates = document.querySelector(
            `#start-date .calendar__body .calendar__dates`);
        updateDates.innerHTML = html;

    } else {
        let html = ``;
        for (let i = 0; i < 31; i += 1) {
            if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                html +=
                    `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
            } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                html +=
                    `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
            } else {
                html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
            }
        }
        const updateDates = document.querySelector(
            `#start-date .calendar__body .calendar__dates`);
        updateDates.innerHTML = html;


    }
    setDateClickable("#start-date");
});

setDateClickable("#start-date");

function setDateClickable(rootElt) {
    const dates = document.querySelectorAll(
        `${rootElt} .calendar__body .calendar__dates .calendar__date`);
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
                    const dateStart = document.querySelectorAll(
                        `#start-date .calendar__body .calendar__dates .calendar__date`
                    );
                    dateStart.forEach((d, i) => {
                        if (i + 1 == dateEndFix) {
                            d.classList.add("calendar__date--range-start");
                        } else {
                            d.classList.remove("calendar__date--range-start");
                        }
                    });
                } else {
                    date = Number(elt.firstElementChild.innerText);
                    const dateEnd = document.querySelectorAll(
                        `#end-date .calendar__body .calendar__dates .calendar__date`
                    );
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

const setCalendarStartBtn = document.querySelector("#set-calendar-start");
setCalendarStartBtn.addEventListener("click", e => {
    startDate.setAttribute("value",
        `${year}-${month.toString().length < 2 ? month.toString().padStart(2, "0") : month}-${date.toString().length < 2 ? date.toString().padStart(2, "0") : date}`
    );
    dateFix = date;
    monthFix = month;
    yearFix = year;
    let html = ``;
    if (monthEnd == 2) {
        let html = ``;
        for (let i = 0; i < 29; i += 1) {
            if (i + 1 <= dateFix && yearEndFix == yearEnd && monthEndFix == monthEnd) {
                html +=
                    `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
            } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                html +=
                    `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
            } else {
                html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
            }
        }
        const updateDates = document.querySelector(
            `#end-date .calendar__body .calendar__dates`);
        updateDates.innerHTML = html;
    } else {
        for (let i = 0; i < 31; i += 1) {
            if (i + 1 <= dateFix && year == yearEndFix && monthEndFix == monthEnd) {
                html +=
                    `<div class="calendar__date calendar__date--grey"><span>${i + 1}</span></div>`;
            } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                html +=
                    `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
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


// Begin Cancel Dates Value
const cancelDateStartBtn = document.querySelector("#cancel-date-btn-start");
cancelDateStartBtn.addEventListener("click", e => {
    date = dateFix;
    month = monthFix;
    year = yearFix;
    let html = ``;
    if (monthEndFix == 2) {
        for (let i = 0; i < 29; i += 1) {
            if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                html +=
                    `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
            } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                html +=
                    `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
            } else {
                html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
            }
        }

    } else {
        for (let i = 0; i < 31; i += 1) {
            if (i + 1 == dateFix && yearFix == year && month == monthFix) {
                html +=
                    `<div class="calendar__date calendar__date--selected calendar__date--range-end calendar__date--first-date"><span>${i + 1}</span></div>`;
            } else if (i + 1 == dateEndFix && year == yearEndFix && monthEndFix == monthEnd) {
                html +=
                    `<div class="calendar__date calendar__date--range-start"><span>${i + 1}</span></div>`;
            } else {
                html += `<div class="calendar__date"><span>${i + 1}</span></div>`;
            }
        }

    }
    const updateDates = document.querySelector(`#start-date .calendar__body .calendar__dates`);
    updateDates.innerHTML = html;
    setDateClickable("#start-date");
    date = dateFix;
    month = monthFix;
    year = yearFix;
    // dateEnd = dateEndFix;
    // monthEnd = monthEndFix;
    // yearEnd = yearEndFix;
});

// begin::Notification Toaster
// const toaster = document.querySelector(".toast");
// const toastBoots = new bootstrap.Toast(toaster, {
//     animation: true,
//     delay: 2000,
// });
// end::Notification Toaster

// begin::Froala Editor
var editor = new FroalaEditor('#froala-editor-draft', {
    documentReady: true,
});
// end::Froala Editor

let contentHtmlAttachment = "";
document.getElementById("attach-file-draft").addEventListener("change", async function () {
    contentHtmlAttachment = await readFile(this.files[0], "#froala-editor-draft");
    // document.querySelector(`#content-word-draft`).innerText = contentHtmlAttachment;

});

// Convert DOCX format to HTML tag
async function readFile(content, show = true) {
    const file = new FileReader();
    let data = "";
    file.onloadend = () => {
        const docx2html = require("docx2html");
        docx2html(file.result).then(html => {
            // if (show) {
            // }
            document.querySelector(".fr-view").innerHTML = html;
            document.querySelector(` #A > section`).style.backgroundColor = "transparent";
            data = html;
            document.querySelectorAll("#A")[document.querySelectorAll("#A").length - 1].remove();
        });
    }
    file.readAsBinaryString(content);
    // return data;
    // End::Read DOCX Content
}




