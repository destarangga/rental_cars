@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-5">Edit Penyewaan Mobil</h2>

        <form action="{{ route('rentals.update', $rental->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Input tersembunyi untuk car_id -->
            <input type="hidden" name="car_id" value="{{ $rental->car_id }}">

            <div class="form-group mb-3">
                <label for="start_date">Tanggal Mulai:</label>
                <input type="date" class="form-control" name="start_date" value="{{ $rental->start_date }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="end_date">Tanggal Selesai:</label>
                <input type="date" class="form-control" name="end_date" value="{{ $rental->end_date }}" required>
            </div>
            <div class="mb-3">
                <label for="rental_price_per_day" class="form-label">Harga Sewa (Per Hari)</label>
                <input type="text" class="form-control" id="rental_price_per_day" value="Rp {{ number_format($car->rental_price_per_day, 0, ',', '.') }}" disabled>
            </div>
            <button type="submit" class="btn btn-primary">Perbarui Penyewaan</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const totalCostInput = document.getElementById('total_cost');
        const rentalPricePerDay = {{ $car->rental_price_per_day }};

        function calculateTotalCost() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (!isNaN(startDate) && !isNaN(endDate) && endDate >= startDate) {
                const durationInDays = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)); // Termasuk hari pertama
                const totalCost = durationInDays * rentalPricePerDay;

                totalCostInput.value = `Rp ${new Intl.NumberFormat('id-ID').format(totalCost)}`;
            } else {
                totalCostInput.value = '';
            }
        }

        startDateInput.addEventListener('change', calculateTotalCost);
        endDateInput.addEventListener('change', calculateTotalCost);
    });
    </script>
@endsection
