@extends('../template/template')

@section('scripts')
    <script src="{{ asset(env("js")."output/search.bundle.js") }}"></script>    
@endsection

@section('content')
    <div class="modal" id="modal">
        <div class="modal-main">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-1 close-modal"></div>
                <div class="col-lg-6 col-md-6 col-sm-10 col-xs-12 close-modal">
                    <div class="modal-card" id="loading">
                        <div class="preloader"></div>
                        <span class="tag">Cargando...</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-1 close-modal"></div>
            </div>
        </div>
    </div>
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
                    <div class="form-group col-12">
                        <span>Juntar con:</span>
                        <div id="InnerWith">
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="Claro" value="1">
                                <label class="custom-control-label" for="Claro">Claro</label>
                            </div>
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="Galicia" value="2">
                                <label class="custom-control-label" for="Galicia">Galicia</label>
                            </div>
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="Jubilados" value="3">
                                <label class="custom-control-label" for="Jubilados">Jubilados</label>
                            </div>
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="Macro" value="4">
                                <label class="custom-control-label" for="Macro">Macro</label>
                            </div>
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="Movistar" value="5">
                                <label class="custom-control-label" for="Movistar">Movistar</label>
                            </div>
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="ObrasSociales" value="6">
                                <label class="custom-control-label" for="ObrasSociales">ObrasSociales</label>
                            </div>
                            <div class="custom-control custom-switch custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="Personal" value="7">
                                <label class="custom-control-label" for="Personal">Personal</label>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="loading-container loading-hidden" id="Searching">
                    <div class="loading">
                        <div class="preloader"></div>
                        <span class="tag">Buscando...</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 card mt-4">
            <div class="card-body">
                <div class="table-container">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr id="headers">
                                <th scope="col">Aquí</th>
                                <th scope="col">aparecerán</th>
                                <th scope="col">los</th>
                                <th scope="col">resultados</th>
                            </tr>
                        </thead>
                        <tbody id="rows"></tbody>
                    </table>
                </div>
                <div class="row justify-content-center mt-3">
                    
                    <button class="btn btn-primary" type="button" id="Export">Exportar</button>

                    {{-- @if ($errors->has("notQuery"))
                    <span class="invalid-feedback" role="alert">
                        <strong>{!! $errors->first("notQuery", ":message") !!}</strong>
                    </span>
                    @endif --}}
                    @error('notQuery')
                    <div class="alert alert-danger alert-dismissible fade show col-12 mt-3" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
@endsection