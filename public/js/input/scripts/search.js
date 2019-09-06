import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import f from "../functions/functions";
import swal from 'sweetalert';

const { eventAll, eventOne } = events;

document.addEventListener("DOMContentLoaded", () => {

    const searchBox = FJ("#query").get(0);
    let makeAnotherRequest = true; // Variable que controla en CD de búsqueda para no hacer consultas cada que escribe
    eventOne("keyup", searchBox, function() {

        if (makeAnotherRequest) {
            makeAnotherRequest = false;
            
            FJ("#Searching").get(0).classList.remove("loading-hidden");

            setTimeout(async () => {
                const query = this.value;
                const table = FJ("#table").get(0).value;
                const limit = FJ("#limit").get(0).value;
                const inner = FJ("#inner").get(0).checked;
        
                const data = { query, table, limit, inner };
                
                const response = await f.ajax(route("getData").url(), "post", data, "json");
                console.log(response);
        
                if (response.status == "true") {
                    //Limpiamos la tabla
                    f.remove("#headers th");
                    f.remove("#rows tr");
                    
                    //Primero armo las cabeceras
                    Array.from(response.headers).forEach(column => {
        
                        //Creo el elemento th
                        const th = document.createElement("th");
                        th.setAttribute("scope", "col");
                        th.textContent = column;
        
                        FJ("#headers").get(0).append(th);
                    });
        
                    //Ahora inserto las filas
                    Array.from(response.rows).forEach(row => {
        
                        //Primero creo el tr
                        const tr = document.createElement("tr");
        
                        for (const key in row) {
                            //Ahora creo los td y los inserto dentro del tr
                            const text = (row[key] == "" || row[key] == null) ? "Sin datos" : row[key];
                            const td = document.createElement("td");
                            td.textContent = text;
                            tr.append(td);
                        }
        
                        //Inserto cada td dentro de la tabla
                        FJ("#rows").get(0).append(tr);
        
                    });
                    
                }
                else {
                    swal("Error", response.message, "error");
                }
                FJ("#Searching").get(0).classList.add("loading-hidden");
                makeAnotherRequest = true;
            }, 1000);
        }

        

    }, true);

});