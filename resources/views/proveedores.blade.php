<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Proveedores</title>
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
        <h2>Crear Proveedor</h2>
        <!-- Formulario para crear un nuevo proveedor -->
        <form action="{{ route('proveedores.store') }}" method="POST">
            @csrf
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <label for="direccion">Dirección:</label>
            <textarea id="direccion" name="direccion" rows="3" required></textarea>

            <label for="ciudad">Ciudad:</label>
            <input type="text" id="ciudad" name="ciudad" required>

            <label for="pais">País:</label>
            <input type="text" id="pais" name="pais" required>

            <label for="cp">Código Postal:</label>
            <input type="text" id="cp" name="cp" required>

            <input type="submit" value="Crear Proveedor">
        </form>

        <hr>
        <h2>Lista de Proveedores</h2>
        @foreach ($proveedores['data'] as $proveedor)
            <div class="product-details">
                <p>{{ $proveedor['nombre'] }} - {{ $proveedor['telefono'] }} - {{ $proveedor['direccion'] }} -
                    {{ $proveedor['ciudad'] }} - {{ $proveedor['pais'] }} - {{ $proveedor['cp'] }}
                </p>
                <div>
                    <button onclick="showEditForm({{ json_encode($proveedor) }})">Editar</button>
                    <button class="delete-button" onclick="deleteProveedor({{ $proveedor['id'] }})">Eliminar</button>
                </div>
            </div>
        @endforeach

        <div id="edit-form">
            <h2>Editar Proveedor</h2>
            <form id="update-form" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-id" name="id">
                <label for="edit-nombre">Nombre:</label>
                <input type="text" id="edit-nombre" name="nombre" required>

                <label for="edit-telefono">Teléfono:</label>
                <input type="text" id="edit-telefono" name="telefono" required>

                <label for="edit-direccion">Dirección:</label>
                <textarea id="edit-direccion" name="direccion" rows="3" required></textarea>

                <label for="edit-ciudad">Ciudad:</label>
                <input type="text" id="edit-ciudad" name="ciudad" required>

                <label for="edit-pais">País:</label>
                <input type="text" id="edit-pais" name="pais" required>

                <label for="edit-cp">Código Postal:</label>
                <input type="text" id="edit-cp" name="cp" required>

                <input type="submit" value="Actualizar Proveedor">
            </form>
        </div>
    </div>

    <script>
        function showEditForm(proveedor) {
            document.getElementById('edit-form').style.display = 'block';
            document.getElementById('edit-id').value = proveedor.id;
            document.getElementById('edit-nombre').value = proveedor.nombre;
            document.getElementById('edit-telefono').value = proveedor.telefono;
            document.getElementById('edit-direccion').value = proveedor.direccion;
            document.getElementById('edit-ciudad').value = proveedor.ciudad;
            document.getElementById('edit-pais').value = proveedor.pais;
            document.getElementById('edit-cp').value = proveedor.cp;

            document.getElementById('update-form').action = `/proveedores/${proveedor.id}`;
        }

        function deleteProveedor(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este proveedor?')) {
                fetch(`/proveedores/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Authorization': 'Bearer {{ session('token') }}'
                    }
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        throw new Error('Error al eliminar el proveedor');
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