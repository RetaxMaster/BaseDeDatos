import events from "../functions/events";
import FJ from "../functions/FamilyJewels";
import f from "../functions/functions";
import swal from 'sweetalert';

const { eventAll, eventOne } = events;

document.addEventListener("DOMContentLoaded", () => {

    const searchBox = FJ("#query").get(0);
    eventOne("keyup", searchBox, async function() {

        const query = this.value;
        const table = FJ("#table").get(0).value;
        const limit = FJ("#limit").get(0).value;
        const inner = FJ("#inner").get(0).checked;

        const data = { query, table, limit, inner };
        
        const response = await f.ajax(route("getData").url(), "post", data, "json");
        console.log(response);
        

    }, true);

});