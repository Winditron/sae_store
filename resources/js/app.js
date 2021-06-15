document.querySelectorAll(".edit-gallery .actions button.delete").forEach((element) => {
    element.addEventListener("click", (e) => {
        const url = e.currentTarget.dataset.href;
        const target = e.target;

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