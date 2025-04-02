<x-admin.admin-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Riwayat Booking</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-history me-1"></i>
                            Riwayat Booking Anda
                        </div>

                        <!-- @TODO: You can add the desired ID as a reference for the embedId parameter. -->
                        <div id="snap-container"></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="riwayat-table">
                                    <thead class="bg-warning">
                                        <tr class="text-dark">
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Layanan</th>
                                            <th>Booking</th>
                                            <th>Kursi</th>
                                            <th>Status</th>
                                            <th>Status Pembayaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($bookings as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>
                                                @php
                                                $layananItems = json_decode($item->layanan_id, true) ?? [];
                                                @endphp
                                                @foreach($layananItems as $layananItem)
                                                <span class="badge bg-primary">
                                                    @php
                                                    $layanan = App\Models\Layanan::find($layananItem['id']);
                                                    @endphp
                                                    @if($layanan)
                                                    <span class="badge bg-primary">
                                                        {{ $layanan->nama_layanan }} (x{{ $layananItem['quantity'] }})
                                                    </span>
                                                    @endif
                                                </span><br>
                                                @endforeach
                                            </td>
                                            <td>{{ $item->jam_booking }}</td>
                                            <td>{{ $item->kursi }}</td>
                                            <td>
                                                @php
                                                $badgeColor = match($item->status) {
                                                'pending' => 'bg-warning',
                                                'konfirmasi' => 'bg-success',
                                                'batal' => 'bg-danger',
                                                'selesai' => 'bg-primary',
                                                default => 'bg-secondary'
                                                };
                                                @endphp

                                                <span class="badge {{ $badgeColor }}">{{ $item->status }}</span>
                                            </td>
                                            <td><span class="badge bg-danger">Unpaid</span></td>
                                            <td>
                                                <button id="pay-button">Pay!</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td>2</td>
                                            <td>popay</td>
                                            <td><span class="badge bg-primary">Layanan B (x1)</span></td>
                                            <td>2:00 PM</td>
                                            <td>2</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                            <td><span class="badge bg-success">Paid</span></td>
                                            <td>
                                                <button id="pay-button">Bayar Sekarang</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                $(document).ready(function() {
                    $('#riwayat-table').DataTable();
                });
                </script>
            </main>
        </div>
    </div>


    <script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function() {
        window.snap.embed('data.snap_token', {
            embedId: 'snap-container'
        });
    });
    </script>
</x-admin.admin-layout>