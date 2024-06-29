document.addEventListener("DOMContentLoaded", function() {
    fetch('services.php')
        .then(response => response.json())
        .then(data => {
            let servicesList = document.getElementById('servicesList');
            servicesList.innerHTML = '';

            data.forEach(service => {
                let card = document.createElement('div');
                card.className = 'w3-col';

                card.innerHTML = `
                    <div class="w3-card-4">
                        <img src="images/services_${service.service_id}.png" alt="${service.service_name}">
                        <div class="card-content">
                            <h3>${service.service_name}</h3>
                            <div class="service-info">
                                <p>${service.service_description}</p>
                                <p><strong>Price: RM${service.service_price}</strong></p>
                            </div>
                            <button class="w3-button w3-teal" onclick="showServiceDetails('${service.service_name}', '${service.service_description}', ${service.service_price})">View Details</button>
                        </div>
                    </div>
                `;

                servicesList.appendChild(card);
            });
        });
});

function showServiceDetails(name, description, price) {
    document.getElementById('modalTitle').innerText = name;
    document.getElementById('modalDescription').innerText = description;
    document.getElementById('modalPrice').innerText = `${price}`;
    document.getElementById('serviceModal').style.display = 'block';
}
