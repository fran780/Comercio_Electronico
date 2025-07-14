<h1>Trabajar con Funciones</h1>

<section class="grid">
    <div class="row">
        <form class="col-12 col-m-8" action="index.php" method="get">
            <div class="flex align-center">
                <div class="col-8 row">
                    <input type="hidden" name="page" value="Funciones_Funciones">
                    <label class="col-3" for="partialDescription">Descripción</label>
                    <input class="col-9" type="text" name="partialDescription" id="partialDescription"
                        value="{{partialDescription}}" />

                    <label class="col-3" for="status">Estado</label>
                    <select class="col-9" name="status" id="status">
                        <option value="EMP" {{status_EMP}}>Todos</option>
                        <option value="ACT" {{status_ACT}}>Activo</option>
                        <option value="INA" {{status_INA}}>Inactivo</option>
                    </select>
                </div>
                <div class="col-4 align-end">
                    <button type="submit">Filtrar</button>
                </div>
            </div>
        </form>
    </div>
</section>

<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th><a href="index.php?page=Funciones_Funcion&mode=INS">Nuevo</a></th>
            </tr>
        </thead>
        <tbody>
            {{foreach funciones}}
            <tr>
                <td class="center">{{fncod}}</td>
                <td class="center">{{fndsc}}</td>
                <td class="center">{{fntyp}}</td>
                <td class="center">{{fnestDsc}}</td>
                <td class="center">
                    <a href="index.php?page=Funciones_Funcion&mode=DSP&fncod={{fncod}}">Ver</a>
                    &nbsp;
                    <a href="index.php?page=Funciones_Funcion&mode=UPD&fncod={{fncod}}">Editar</a>
                    &nbsp;
                    <a href="index.php?page=Funciones_Funcion&mode=DEL&fncod={{fncod}}">Eliminar</a>
                </td>
            </tr>
            {{endfor funciones}}
        </tbody>
    </table>
    {{pagination}}
</section>