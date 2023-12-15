<section>
    <h2>Listado de Mascotas</h2>
</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Status</th>
                <th>Edad</th>
                <th>Raza</th>
                <th><a href="index.php?page=Mascotas-MascotasForm&mode=INS">Nuevo</a></th>
            </tr>
        </thead>
        <tbody>
            {{foreach mascotas}}
            <tr>
                <td>{{id}}</td>
                <td><a href="index.php?page=Mascotas-MascotasForm&mode=DSP&id={{id}}">{{name}}</a></td>
                <td>{{status}}</td>
                <td>{{edad}}</td>
                <td>{{raza}}</td>
                <td>
                    <a href="index.php?page=Mascotas-MascotasForm&mode=UPD&id={{id}}">Editar</a> 
                    | 
                    <a href="index.php?page=Mascotas-MascotasForm&mode=DEL&id={{id}}">Eliminar</a>
                </td>
            </tr>
            {{endfor mascotas}}
        </tbody>
    </table>
</section>