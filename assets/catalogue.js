// Initialiser le panier depuis le localStorage
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Fonction pour ajouter un produit au panier
function addToCart(product) {
    const existingProduct = cart.find((item) => item.id === product.id);

    if (existingProduct) {
        existingProduct.quantity += 1; // Augmente la quantité si le produit existe
    } else {
        cart.push({ ...product, quantity: 1 }); // Ajoute un nouveau produit
    }

    // Sauvegarder le panier dans localStorage
    localStorage.setItem("cart", JSON.stringify(cart));
    alert(`${product.name} a été ajouté au panier.`);
}

// Fonction pour attacher des événements aux boutons
function setupAddToCartButtons() {
    document.querySelectorAll(".btn-add-to-cart").forEach((button) => {
        button.addEventListener("click", () => {
            const productCard = button.closest(".product-card");
            const product = {
                id: parseInt(productCard.dataset.id),
                name: productCard.dataset.name,
                price: parseFloat(productCard.dataset.price),
                image: productCard.querySelector("img").src, // Récupération de l'image
            };

            addToCart(product);
        });
    });
}

// Fonction pour afficher le panier (si nécessaire)
function displayCart() {
    const cartItemsContainer = document.querySelector(".cart-items");
    const cartTotalElement = document.getElementById("cart-total");

    if (!cartItemsContainer || !cartTotalElement) {
        console.error("Les éléments HTML pour le panier ne sont pas présents.");
        return;
    }

    cartItemsContainer.innerHTML = ""; // Réinitialiser l'affichage
    let total = 0;

    cart.forEach((product) => {
        const cartItem = document.createElement("li");
        cartItem.classList.add("cart-item");

        cartItem.innerHTML = `
            <img src="${product.image}" alt="${product.name}" style="width: 50px; height: auto;">
            <div>
                <h3>${product.name}</h3>
                <p>Prix : ${product.price.toFixed(2)} €</p>
                <p>Quantité : ${product.quantity}</p>
            </div>
        `;

        cartItemsContainer.appendChild(cartItem);
        total += product.price * product.quantity;
    });

    cartTotalElement.textContent = `Total : ${total.toFixed(2)} €`;
}

// Charger les événements au démarrage
document.addEventListener("DOMContentLoaded", () => {
    setupAddToCartButtons();
    displayCart(); // Affiche le panier au chargement (si nécessaire)
});
