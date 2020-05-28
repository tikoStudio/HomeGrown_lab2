updateBtn = document.querySelector('.btn--hidden')
document.querySelector('#avatar').addEventListener('change', () => {
    const file = document.querySelector('#avatar').files[0]
    if(file) {
        const reader = new FileReader()

        reader.addEventListener('load', () => {
            if(reader.result.includes('image/gif') || reader.result.includes('image/jpeg') || reader.result.includes('image/png')) {
                document.querySelector('.form__avatar').setAttribute('src', reader.result)
                if(updateBtn) {
                    updateBtn.style.display = "block"
                }
            }
        })

        reader.readAsDataURL(file)
    }
})