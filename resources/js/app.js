document.querySelectorAll(".edit-gallery .actions button.delete").forEach((element) => {
    element.addEventListener("click", (e) => {
        const url = e.currentTarget.dataset.href;

        fetch(url,{
            method: 'POST'
        });

    })
})