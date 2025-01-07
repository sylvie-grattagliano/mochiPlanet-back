
// Charger le panier depuis le localStorage
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Fonction pour ajouter un produit au panier
function addToCart(productId) {
    const productCard = document.querySelector(`.product-card[data-id="${productId}"]`);
    const productName = productCard.dataset.name;
    const productPrice = parseFloat(productCard.dataset.price);
    const productImage = productCard.querySelector('img').src;

    // Vérifier si le produit existe déjà dans le panier
    const existingProduct = cart.find(item => item.id === productId);

    if (existingProduct) {
        existingProduct.quantity += 1; // Augmenter la quantité
    } else {
        // Ajouter un nouveau produit
        cart.push({
            id: productId,
            name: productName,
            price: productPrice,
            quantity: 1,
            image: productImage
        });
    }

    // Sauvegarder le panier dans localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
    alert(`${productName} a été ajouté au panier.`);
    updateCart();
}

// Fonction pour mettre à jour l'affichage du panier
function updateCart() {
    const cartItems = document.querySelector('.cart-items');
    const cartTotal = document.getElementById('cart-total');
    let total = 0;

    if (!cartItems || !cartTotal) {
        return; // Ne pas mettre à jour si ces éléments ne sont pas présents
    }

    cartItems.innerHTML = ''; // Réinitialiser l'affichage

    cart.forEach(product => {
        const li = document.createElement('li');
        li.innerHTML = `
            <img src="${product.image}" alt="${product.name}">
            <div class="cart-item-details">
                <h3>${product.name}</h3>
                <p>Prix : ${product.price.toFixed(2)} €</p>
                <p>Quantité : ${product.quantity}</p>
            </div>
            <div class="cart-item-actions">
                <button onclick="increaseQuantity(${product.id})">+</button>
                <button onclick="decreaseQuantity(${product.id})">-</button>
                <button onclick="removeProduct(${product.id})">🗑</button>
            </div>
        `;
        cartItems.appendChild(li);

        total += product.price * product.quantity;
    });

    cartTotal.textContent = `${total.toFixed(2)} €`;
}

// Fonction pour augmenter la quantité
function increaseQuantity(productId) {
    const product = cart.find(item => item.id === productId);
    if (product) {
        product.quantity += 1;
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCart();
    }
}

// Fonction pour réduire la quantité
function decreaseQuantity(productId) {
    const product = cart.find(item => item.id === productId);
    if (product && product.quantity > 1) {
        product.quantity -= 1;
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCart();
    }
}

// Fonction pour supprimer un produit du panier
function removeProduct(productId) {
    const productIndex = cart.findIndex(item => item.id === productId);
    if (productIndex !== -1) {
        cart.splice(productIndex, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCart();
    }
}

// Attacher les événements "Ajouter au panier" aux boutons
document.querySelectorAll('.btn-add-to-cart').forEach(button => {
    button.addEventListener('click', () => {
        const productId = parseInt(button.closest('.product-card').dataset.id);
        addToCart(productId);
    });
});

// Charger le panier au démarrage
updateCart();
