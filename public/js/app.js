
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

/**
    Produkt in den Warenkorblegen
 */
document.querySelectorAll("button.add-to-basket").forEach((element) => {
    element.addEventListener("click", (e) => {
        const url = e.currentTarget.dataset.href;

        fetch(url,{
            method: 'POST'
        });

    })
})

/**
 * Produkt menge ändern im Warenkorb
*/
document.querySelectorAll("input.basket-change-quatity").forEach((element) => {
    element.addEventListener("change", (e) => {
        const url = e.currentTarget.dataset.href;
        const value = e.currentTarget.value;

        
        console.log(url + value);

        fetch(url + value,{
            method: 'POST'
        })
            .then((response) => {
                if(response.status === 200){
                    response.json().then(data => {
                        
                        
                        let { success , errors, response } = data;
                        const row = e.target.closest('div.row');
                        
                        if( value <= 0 && success === true){
                            row.remove();
                        } else if(success === true){
                            
                            row.querySelector('div.js_price').textContent = new Intl.NumberFormat('de-AT', { style: 'currency', currency: 'EUR' }).format(response.price);
                            row.querySelector('div.js_price-quantity').textContent = new Intl.NumberFormat('de-AT', { style: 'currency', currency: 'EUR' }).format(response.price * response.quantity);
                        }

                    });
                }
            });

    })
})