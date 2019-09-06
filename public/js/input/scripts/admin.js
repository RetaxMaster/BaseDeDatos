import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import f from "../functions/functions";
import swal from 'sweetalert';

const { eventAll, eventOne } = events;

document.addEventListener("DOMContentLoaded", () => {

    const importButton = FJ("#Import").get(0);
    eventOne("click", importButton, async function() {
        const excelFile = FJ("#ExcelFile").get(0).files[0];
        const availableMIMETypes = ["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-excel", "text/csv"];
        const table = FJ("#Table").get(0).value;
        const progressBar = document.querySelector("#progress");
        console.log(progressBar);
        
        
        if (availableMIMETypes.indexOf(excelFile.type) != -1) {
            const formData = new FormData();
            formData.append("ExcelFile", excelFile);
            formData.append("Table", table);

            const request = await f.ajax(route("uploadFile").url(), "post", formData, "json", false, false, true);

            request.xhr.upload.addEventListener("progress", (event) => {
                const porcentaje = Math.round((event.loaded / event.total) * 50);
                progressBar.classList.remove("hide");
                progressBar.children[0].setAttribute("aria-valuenow", porcentaje);
                progressBar.children[0].style.width = `${porcentaje}%`;
                progressBar.children[0].textContent = `${porcentaje}%`;
            });

            request.xhr.addEventListener("progress", (event) => {
                const porcentaje = Math.round((event.loaded / event.total) * 50) + 50;
                progressBar.classList.remove("hide");
                progressBar.children[0].setAttribute("aria-valuenow", porcentaje);
                progressBar.children[0].style.width = `${porcentaje}%`;
                progressBar.children[0].textContent = `${porcentaje}%`;
            });

            request.xhr.addEventListener("load", () => {
                progressBar.classList.add("hide");
            });

            const response = await request.success;
            
            if (response.status == "true") {
                swal("Listo", "Tabla importada con éxito", "success");                
            }
            else {
                swal("Error", response.message, "error");
            }
            
        }
        else {
            swal("Error", "Por favor suve archivos .xls, .xlsx o .csv", "error");
        }
        
    }, true);


});