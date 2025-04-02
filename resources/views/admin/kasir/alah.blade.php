<div class="row g-3 mt-4">
    <div class="col-12 col-sm-6 col-lg-4">
        <div class="card shadow-sm p-4 d-flex flex-row justify-center align-items-center rounded-4">
            <div class="icon-container me-3">
                <i class="fas fa-shopping-cart fa-2x text-primary"></i>
            </div>
            <div class="text-start">
                <h3 class="fs-2 fw-bold">75</h3>
                <p class="fs-6 text-muted mb-1">Total Orders</p>
                <span class="text-success">
                    <i class="fas fa-arrow-up"></i> 4% (30 days)
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-4">
        <div class="card shadow-sm p-4 d-flex flex-row justify-center align-items-center rounded-4">
            <div class="icon-container me-3">
                <i class="fas fa-box fa-2x text-warning"></i>
            </div>
            <div class="text-start">
                <h3 class="fs-2 fw-bold">357</h3>
                <p class="fs-6 text-muted mb-1">Total Delivered</p>
                <span class="text-success">
                    <i class="fas fa-arrow-up"></i> 4% (30 days)
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card shadow-sm p-4 d-flex flex-row justify-center align-items-center rounded-4">
            <div class="icon-container me-3">
                <i class="fas fa-shopping-bag fa-2x text-secondary"></i>
            </div>
            <div class="text-start">
                <h3 class="fs-2 fw-bold">$128</h3>
                <p class="fs-6 text-muted mb-1">Total Revenue</p>
                <span class="text-danger">
                    <i class="fas fa-arrow-down"></i> 12% (30 days)
                </span>
            </div>
        </div>
    </div>
</div>

.icon-container {
width: 60px;
height: 60px;
background-color: gold;
/* Warna background icon */
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

$(document).ready(function() {
$('#riwayat-table').DataTable();
});