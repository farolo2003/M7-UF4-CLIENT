<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        textarea {
            margin-bottom: 15px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .product-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .product-details p {
            margin: 0;
        }

        .product-details button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
            margin-right: 5px;
        }

        .product-details button:hover {
            background-color: #0056b3;
        }

        .delete-button {
            background-color: #dc3545 !important;
            color: #fff !important;
            border: none !important;
            padding: 5px 10px !important;
            cursor: pointer !important;
            border-radius: 3px !important;
        }

        .delete-button:hover {
            background-color: #c82333 !important;
        }

        #edit-form {
            display: none;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Crear Productos</h2>
        <!-- Formulario para crear un nuevo producto -->
        <form action="{{ route('productos.store') }}" method="POST">
            @csrf
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="3" required></textarea>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" min="0" step="0.01" required>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" min="0" required>

            <input type="submit" value="Crear Producto">
        </form>

        <hr>
        <h2>Detalles de los productos</h2>
        @foreach ($productos['data'] as $producto)
            <div class="product-details">
                <p>{{ $producto['nombre'] }} - {{ $producto['descripcion'] }} - {{ $producto['precio'] }} -
                    {{ $producto['stock'] }}
                </p>
                <div>
                    <button onclick="showEditForm({{ json_encode($producto) }})">Editar</button>
                    <button class="delete-button" onclick="deleteProduct({{ $producto['id'] }})">Eliminar</button>
                </div>
            </div>
        @endforeach

        <div id="edit-form">
            <h2>Editar Producto</h2>
            <form id="update-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-id" name="id">
                <label for="edit-nombre">Nombre:</label>
                <input type="text" id="edit-nombre" name="nombre" required>

                <label for="edit-descripcion">Descripción:</label>
                <textarea id="edit-descripcion" name="descripcion" rows="3" required></textarea>

                <label for="edit-precio">Precio:</label>
                <input type="number" id="edit-precio" name="precio" min="0" step="0.01" required>

                <label for="edit-stock">Stock:</label>
                <input type="number" id="edit-stock" name="stock" min="0" required>

                <input type="submit" value="Actualizar Producto">
            </form>
        </div>
    </div>

    <script>
        function showEditForm(producto) {
            document.getElementById('edit-form').style.display = 'block';
            document.getElementById('edit-id').value = producto.id;
            document.getElementById('edit-nombre').value = producto.nombre;
            document.getElementById('edit-descripcion').value = producto.descripcion;
            document.getElementById('edit-precio').value = producto.precio;
            document.getElementById('edit-stock').value = producto.stock;

            document.getElementById('update-form').action = `/productos/${producto.id}`;
        }

        function deleteProduct(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
            fetch(`/productos/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Authorization': 'Bearer {{ session('token') }}'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    throw new Error('Error al eliminar el producto');
                }
            }).catch(error => {
                console.error('Error:', error);
                alert('Actualiza la pagina para ver el dato eliminado!');
            });
        }
    }

    </script>
</body>

</html>