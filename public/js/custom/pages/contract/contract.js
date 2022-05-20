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

})
// Convert DOCX format to HTML tag
function readFile(file, elt) {
    const docx2html = require("docx2html");
    docx2html(file).then(html => {
        document.querySelector(` ${elt} .fr-wrapper .fr-view`).innerHTML = html;
    });
};

// Save Data Review
async function saveReview() {
    console.log("test");
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