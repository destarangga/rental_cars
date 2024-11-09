@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mt-5">Formulir Sewa Mobil</h2>
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <form action="{{ route('rentals.store') }}" method="POST">
        @csrf
        <input type="hidden" name="car_id" value="{{ $car->id }}">
        
        <div class="mb-3">
            <label for="car" class="form-label">Mobil</label>
            <input type="text" class="form-control" id="car" value="{{ $car->brand }} - {{ $car->model }}" disabled>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Tanggal Selesai</label>
            <input type="date" class="form-control" id="end_date" name="end_date" required>
        </div>

        <div class="mb-3">
            <label for="rental_price_per_day" class="form-label">Harga Sewa (Per Hari)</label>
            <input type="text" class="form-control" id="rental_price_per_day" value="Rp {{ number_format($car->rental_price_per_day, 0, ',', '.') }}" disabled>
        </div>

        <div class="mb-3">
            <label for="total_cost" class="form-label">Total Biaya</label>
            <input type="text" class="form-control" id="total_cost" name="total_cost" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Sewa Mobil</button>
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
