<section class="depth-2 py-4 px-4">
<h1>{{modedsc}}</h1>
</section>
{{with mascota}}
<form class="my-4 depth-2 py-4 px-4 row" action="index.php?page=Mascotas-MascotasForm&mode={{~mode}}&id={{id}}" method="POST">
    <input type="hidden" name="xss-token" value="{{~xss_token}}"/>
    <section class="col-6 offset-3">
    <section class="row my-2 align-center">
    <label class="col-4" for="id">Código</label>
    <input class="col-8" type="text" name="id" id="id" value="{{id}}" readonly />
    </section>
    <section class="row my-2 align-center">
    <label class="col-4" for="name">Nombre</label>
    <input class="col-8" type="text" id="name" name="name" placeholder="Nombre de la Mascota"
        value="{{name}}" {{~readonly}}/>
        
    {{if name_error}}<div class="error">{{name_error}}</div>{{endif name_error}}
    </section>

    <section class="row my-2 align-center">
    <label class="col-4" for="name">Edad</label>
    <input class="col-8" type="text" id="name" name="name" placeholder="Edad de la Mascota"
        value="{{edad}}" {{~readonly}}/>
        
    {{if edad_error}}<div class="error">{{edad_error}}</div>{{endif edad_error}}
    </section>

    <section class="row my-2 align-center">
    <label class="col-4" for="name">Raza</label>
    <input class="col-8" type="text" id="name" name="name" placeholder="raza de la Mascota"
        value="{{raza}}" {{~readonly}}/>
        
    {{if raza_error}}<div class="error">{{raza_error}}</div>{{endif raza_error}}
    </section>
    <section class="row my-2 align-center">
    <label class="col-4" for="status">Estado</label>
    <select class="col-8" id="status" name="status"
        {{if ~readonly}}disabled readonly{{endif ~readonly}}
    >
        <option value="ACT" {{ACT_selected}}>Activo</option>
        <option value="INA" {{INA_selected}}>Inactivo</option>
        <option value="CON" {{CON_selected}}>Consulta</option>
    </select>
    </section>
    <br/>
    <section class="col-12 right">
    {{if ~showConfirm}}
        <button type="submit" name="btnConfirm">Confirmar</button>&nbsp;
    {{endif ~showConfirm}}
    <button id="btnCancel">Cancelar</button>
    </section>
    </section>
</form>
{{endwith mascota}}
<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        document.getElementById("btnCancel").addEventListener("click", (e)=>{
            e.preventDefault();
            e.stopPropagation();
            document.location.assign("index.php?page=Mascotas-MascotasList");
        });
    });
</script>