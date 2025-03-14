<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles de la Compra') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2>Compra #{{ $purchase->id }}</h2>
                    <p>Total: {{ $purchase->total }}</p>
                    <p>Fecha de Compra: {{ $purchase->created_at }}</p>

                    <h3 class="mt-4">Detalles de la Compra</h3>

                    <table class="table-auto w-full mt-4">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">ID del Producto</th>
                                <th class="px-4 py-2">Cantidad</th>
                                <th class="px-4 py-2">Precio Unitario</th>
                                <th class="px-4 py-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $detail)
                                <tr>
                                    <td class="border px-4 py-2">{{ $detail->product->name }}</td>
                                    <td class="border px-4 py-2">{{ $detail->quantity }}</td>
                                    <td class="border px-4 py-2">{{ $detail->product->price }}</td>
                                    <td class="border px-4 py-2">{{ $detail->quantity * $detail->product->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
