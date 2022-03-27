const doc = document
const btn = doc.querySelector('#btn')
const url = doc.querySelector('#url')
const dirname = doc.querySelector('#dirname')
const download = doc.querySelector('#download')
const loader = doc.querySelector('#loader')


btn.addEventListener('click', ev => {

    download.classList.remove('active')
    btn.classList.add('disable')
    loader.classList.add('active')

    fetch('assets/function/function.php', {
        method: 'POST',
        body: new FormData( document.getElementById('form')),
    })
        .then(response => response.json())
        .then(result => {
            download.setAttribute('href', 'storage/' + result.dirname)
            download.classList.add('active')
            loader.classList.remove('active')
            btn.classList.remove('disable')
        });
})

download.addEventListener('click', () => {

    fetch('assets/function/function.php', {
        method: 'POST',
        body: ['remove'],
    }).then();
    //download.classList.remove('active')
})
