<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <h1 class="text-2xl font-bold mb-5">Welcome to Admin Dashboard</h1>

                <!-- Overview Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Clients Overview -->
                    <div class="bg-blue-500 text-white p-5 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold">Total Clients</h2>
                        <p class="text-3xl font-bold">{{ $clients }}</p>
                    </div>

                    <!-- Freelancers Overview -->
                    <div class="bg-green-500 text-white p-5 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold">Total Freelancers</h2>
                        <p class="text-3xl font-bold">{{ $freelancers }}</p>
                    </div>

                    <!-- Payments Overview -->
                    <div class="bg-yellow-500 text-white p-5 rounded-lg shadow-md">
                        <h2 class="text-lg font-semibold">Total Payments</h2>
                        <p class="text-3xl font-bold">${{ number_format($payments, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
