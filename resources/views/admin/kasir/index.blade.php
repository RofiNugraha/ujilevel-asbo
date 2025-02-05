<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Kasir</h1>

                    <div class="row">
                        <!-- Produk List -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-shopping-cart me-1"></i>
                                    Daftar Produk
                                </div>
                                <div class="card-body">
                                    <table class="table" id="myTable">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Nama Produk</th>
                                                <th>Harga</th>
                                                <th>Gambar</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Cart -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fas fa-receipt me-1"></i>
                                    Keranjang
                                </div>
                                <div class="card-body">
                                    <ul class="list-group" id="cartItems">
                                        <li class="list-group-item text-muted">Keranjang kosong</li>
                                    </ul>
                                    <hr>
                                    <h5>Total: Rp <span id="totalPrice">0</span></h5>
                                    <button class="btn btn-primary w-100 mt-2" id="checkoutBtn" disabled>
                                        Checkout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <script>
                let cart = [];
                function addToCart(id, name, price) {
                    const existingItem = cart.find(item => item.id === id);
                    if (existingItem) {
                        existingItem.qty += 1;
                    } else {
                        cart.push({ id, name, price, qty: 1 });
                    }
                    updateCart();
                }

                function updateCart() {
                    const cartList = document.getElementById("cartItems");
                    const totalPriceElement = document.getElementById("totalPrice");
                    const checkoutBtn = document.getElementById("checkoutBtn");

                    cartList.innerHTML = "";
                    let total = 0;

                    cart.forEach(item => {
                        total += item.price * item.qty;
                        cartList.innerHTML += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                ${item.name} (x${item.qty})
                                <span>Rp ${new Intl.NumberFormat('id-ID').format(item.price * item.qty)}</span>
                            </li>
                        `;
                    });

                    if (cart.length === 0) {
                        cartList.innerHTML = '<li class="list-group-item text-muted">Keranjang kosong</li>';
                        checkoutBtn.disabled = true;
                    } else {
                        checkoutBtn.disabled = false;
                    }

                    totalPriceElement.textContent = new Intl.NumberFormat('id-ID').format(total);
                }
            </script>
        </div>
    </div>
</x-admin.admin-layout>
