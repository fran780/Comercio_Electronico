<h1>Trabajar con Roles</h1>
<section class="grid">
    <div class="row">
        <form class="col-12 col-m-8" action="index.php" method="get">
            <div class="flex align-center">
                <div class="col-8 row">
                    <input type="hidden" name="page" value="Roles_Roles">
                    <label class="col-3" for="partialDescription">Descripción</label>
                    <input class="col-9" type="text" name="partialDescription" id="partialDescription" value="{{partialDescription}}" />

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
                <th>Id</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th><a href="index.php?page=Roles_Rol&mode=INS">Nuevo</a></th>
            </tr>
        </thead>
        <tbody>
            {{foreach roles}}
            <tr>
                <td class="center">{{rolescod}}</td>
                <td class="center">{{rolesdsc}}</td>
                <td class="center">{{rolesestDsc}}</td>
                <td class="center">
                    <a href="index.php?page=Roles_Rol&mode=DSP&rolescod={{rolescod}}">Ver</a>
                    &nbsp;
                    <a href="index.php?page=Roles_Rol&mode=UPD&rolescod={{rolescod}}">Editar</a>
                    &nbsp;
                    <a href="index.php?page=Roles_Rol&mode=DEL&rolescod={{rolescod}}">Eliminar</a>
                </td>
            </tr>
            {{endfor roles}}
        </tbody>
    </table>
    {{pagination}}
</section>
