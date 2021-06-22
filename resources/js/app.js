
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
        })
            .then((response) => {
                if(response.status === 200){
                    response.json().then(data => {
                        
                        
                        let { success , errors, response } = data;
                        
                        if(success === true){

                            /**
                            * Warenkorbzähler
                            */
                            let quantity = url.split("/");
                            quantity = parseInt(quantity.pop());
                            const basket_count = document.querySelector('div.js_basket-count');
                            basket_count.textContent = parseInt(basket_count.textContent) + quantity;
                        }

                    });
                }
            });


    })
})


/**
 * Neu Berechnung von Total im Warenkorb
*/
const calculateTotalAndSetCounter = () => {

    let total = 0.00;
    const BASE_URL = document.querySelector("base").href;

    fetch(BASE_URL + "/api/basket",{
        method: 'POST'
    })
        .then((response) => {
            if(response.status === 200){
                response.json().then((data) => {
                    let count = 0;
                    data.forEach((basket_item) => {
                        total += basket_item.price * basket_item.quantity;
                        count = count + parseInt(basket_item.quantity);
                    });

                    document.querySelector("div.js_total").textContent = new Intl.NumberFormat('de-AT', { style: 'currency', currency: 'EUR' }).format(total);

                    /**
                    * Warenkorbzähler
                    */
                    const basket_count = document.querySelector('div.js_basket-count');
                    basket_count.textContent = count;

                });
            }
        });
}

/**
 * Produkt menge ändern im Warenkorb
*/
document.querySelectorAll("input.basket-change-quatity").forEach((element) => {
    element.addEventListener("change", (e) => {
        const url = e.currentTarget.dataset.href;
        const value = e.currentTarget.value;

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
                            calculateTotalAndSetCounter();

                        } else if(success === true){

                            row.querySelector('div.js_price').textContent = new Intl.NumberFormat('de-AT', { style: 'currency', currency: 'EUR' }).format(response.price);
                            row.querySelector('div.js_price-quantity').textContent = new Intl.NumberFormat('de-AT', { style: 'currency', currency: 'EUR' }).format(response.price * response.quantity);
                            calculateTotalAndSetCounter();
                        }

                    });
                }
            });

    })
});

/**
 * Produkt aus dem Warekorb via button löschen
*/
document.querySelectorAll("button.js_delete-basket-item").forEach((element) => {
    element.addEventListener("click", (e) => {
        const url = e.currentTarget.dataset.href;
            
        fetch(url,{
            method: 'POST'
        })
            .then((response) => {
                if(response.status === 200){
                    response.json().then(data => {
                        console.log(data);
                        
                        let { success , errors, response } = data;
                        const row = e.target.closest('div.row');
                        
                        if(success === true){

                            row.remove();
                            calculateTotalAndSetCounter();

                        }

                    });
                }
            });

    })
});

/**
 * sichtbarkeit von alt_delivery
*/
if(document.querySelector("input.js_alt_delivery")){
    document.querySelector("input.js_alt_delivery").addEventListener("click", (e) => {
            
        const alt_delivery = document.querySelector('div.js_alt_delivery');
        const headline = document.querySelector('h3.js_checkout-headline');
    
            if (e.target.checked){
                alt_delivery.style.display = 'block';
                headline.textContent = 'Rechnungsadresse';
                
            } else {
                alt_delivery.style.display = 'none';
                headline.textContent = 'Rechnungs- und Lieferadresse';
            }
        }
    );
}

/**
 * Photo Gallary
*/
console.log(document.querySelectorAll("div.js_photo-gallary div.js_photo-gallary-menu > img"))
document.querySelectorAll("div.js_photo-gallary div.js_photo-gallary-menu > img").forEach((element) => {

    element.addEventListener("click", (e) => {
        const main_image = e.target.closest("div.js_photo-gallary").querySelector("figure img");
        const main_image_src= main_image.src;
        const targrt_source = e.target.src;

        main_image.src = targrt_source;
        e.target.src = main_image_src;

    });

});