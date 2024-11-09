
document.addEventListener('DOMContentLoaded', () => {
    let addressInput = document.querySelector('[data-action=address-input]');
    let dropdownContainer = document.querySelector('#dropdownMenu');
    let dropdownResults = document.querySelector('#dropdownResults');
    let addressContainer = document.querySelector('#addressContainer');
    let noResults = document.createElement('li');
    noResults.className = "list-group-item-light";
    noResults.innerText = 'Aucun résultat';

    addressInput.addEventListener('keyup', debounce(function (e) {
        let value = e.target.value;
        console.log(value);
        if (value.length < 3 || value.length > 200) {
            alert('Entre 3 et 200 caractères');
        } else {
            fetch(`https://api-adresse.data.gouv.fr/search/?q=${value}&type=municipality&limit=20`, {
                method: 'GET',
            }).then((response) => {
                let status = response.status;
                if (status !== 200) {
                    alert('Erreur API, essayez à nouveau !');
                }

                return response.json();
            }).then((body) => {
                let features = body.features;

                dropdownContainer.classList.remove('hidden');
                dropdownResults.innerHTML = '';
                if (features != null && features.length > 0) {
                    features.map((feature) => {
                        let li = document.createElement('li');
                        li.className = "list-group-item-light list-group-item-action";
                        li.innerText = feature.properties.name;
                        li.addEventListener('click', () => {
                            addressInput.value = li.innerText;
                            dropdownContainer.classList.add('hidden');
                            dropdownResults.innerHTML = '';
                        });
                        dropdownResults.appendChild(li);
                    })
                } else {
                    dropdownResults.appendChild(noResults);
                }
            })

            document.addEventListener('click', function (event) {
                if(!addressContainer.contains(event.target)) {
                    dropdownContainer.classList.add('hidden')
                    dropdownResults.innerHTML = '';
                }
            })
        }
    }, 600)) 
});

function debounce(callback, delay) {
    let timer;
    return function() {
        let args = arguments;
        let context= this;
        clearTimeout(timer);
        timer = setTimeout(function() {
            callback.apply(context, args);
        }, delay);
    }
}