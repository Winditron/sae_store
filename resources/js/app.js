
/**
 * Löschen des DOM PICTURE element, falls die Verbindung zuwischen eines Bildes und eines Produktes gelöscht wurde
 */
document.querySelectorAll(".edit-gallery .actions button.delete").forEach((element) => {
    element.addEventListener("click", (e) => {
        const url = e.currentTarget.dataset.href;

        fetch(url,{
            method: 'POST'
        })
            .then((response) => {
                if(response.status === 200){
                    e.target.closest("div.picture").remove();
                }
            });

    })
})