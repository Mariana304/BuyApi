<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="justify-self-end">
                        <!-- Botón para abrir el modal -->
                        <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal"
                            data-bs-target="#addProductModal">
                            Agregar Producto
                        </button>

                        <!-- Modal para agregar producto -->
                        <div class="modal fade" id="addProductModal" tabindex="-1"
                            aria-labelledby="addProductModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addProductModalLabel">Agregar Producto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('products.store') }}">
                                        @csrf
                                        <div class="modal-body">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    @foreach ($errors->all() as $error)
                                                        {{ $error }}
                                                    @endforeach
                                                </div>
                                            @endif
                                            <!-- Campo nombre -->
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nombre:</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                    required />
                                            </div>

                                            <!-- Campo precio -->
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Precio:</label>
                                                <input type="number" id="price" name="price" step=".01"
                                                    class="form-control" required />
                                            </div>

                                        </div>

                                        <!-- Footer modal -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Botón para realizar compra -->
                        <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal"
                            data-bs-target="#purchaseModal">
                            Comprar
                        </button>

                        <!-- Modal para realizar compra -->
                        <div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="purchaseModalLabel">Realizar Compra</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="{{ route('purchases.store') }}">
                                        @csrf
                                        <div class="modal-body">
                                            <!-- productos disponibles -->
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Precio</th>
                                                        <th>Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($products as $product)
                                                        <tr>
                                                            <td>{{ $product->name }}</td>
                                                            <td>{{ $product->price }}</td>
                                                            <td>
                                                                <input type="number"
                                                                    name="products[{{ $product->id }}][amount]"
                                                                    class="form-control" value="0" min="0">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <!-- Método de pago -->
                                            <div class="mb-3">
                                                <label for="payment" class="form-label">Método de Pago:</label>
                                                <select name="payment" class="form-select" required>
                                                    <option value="">Seleccione un método de pago</option>
                                                    <option value="tarjeta">Tarjeta</option>
                                                    <option value="contraentrega">Contra Entrega</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Comprar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <h2>Compras del Usuario</h2>
                    @if ($purchases->count() > 0)
                        <table class="table table-striped mt-4">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th>ID</th>
                                    <th>Total</th>
                                    <th>Fecha de Compra</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $purchase)
                                    <tr>
                                        <td>{{ $purchase->id }}</td>
                                        <td>{{ $purchase->total }}</td>
                                        <td>{{ $purchase->created_at }}</td>
                                        <td>
                                            <a href="{{ route('purchase.details', $purchase->id) }}"
                                                class="btn btn-link">Ver Detalles</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay compras registradas.</p>
                    @endif



                </div>
            </div>
        </div>
    </div>
</x-app-layout>
