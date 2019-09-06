@extends('../template/template')

@section('scripts')
    <script src="{{ asset(env("js")."output/search.bundle.js") }}"></script>    
@endsection

@section('content')
    <div class="row my-5">
        <div class="col-12 card">
            <div class="card-body">
                <form action="#" class="row">
                    <div class="form-group col-12 col-md-6">
                        <label for="query">Ingresa tu búsqueda</label>
                        <input type="text" class="form-control" placeholder="Se buscará por cualquier campo" id="query">
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="table">¿En qué tabla quieres buscar?</label>
                        <select class="form-control" id="table">
                            <option value="1" selected>Claro</option>
                            <option value="2">Galicia</option>
                            <option value="3">Jubilados</option>
                            <option value="4">Macro</option>
                            <option value="5">Movistar</option>
                            <option value="6">Obras sociales</option>
                            <option value="7">Personal</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="limit">Cantidad de registros a traer</label>
                        <input type="text" class="form-control" placeholder="Dejar vacío para traer toda la tabla" id="limit">
                    </div>
                    <div class="form-group col-12 col-md-6 d-flex">
                        <div class="align-items-end d-flex">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="inner">
                                <label class="custom-control-label" for="inner">Juntar columnas</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 card mt-4">
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@mdo</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row justify-content-center">
                    <button type="button" class="btn btn-primary">Exportar</button>
                </div>
            </div>
        </div>
    </div>
@endsection