@extends('../template/template')

@section('scripts')
    <script src="{{ asset(env("js")."output/admin.bundle.js") }}"></script>
@endsection

@section('content')

<div class="row mb-5">
    <div class="col-12 my-4">
        <h1 class="title">Registra un nuevo usuario</h1>
    </div>
    <div class="row justify-content-center col-12">
        <div class="col-lg-6 col-md-10">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
        
                        <div class="form-group">
                            <label for="username">Nombre de usuario:</label>
                            <input id="username" type="text" class="form-control @error('user') is-invalid @enderror" name="username" value="{{ old('user') }}" required autofocus placeholder="Nombre de usuario">
        
                            @error('user')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Correo:</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="Correo">
        
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
        
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
        
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mt-4">
        <h1 class="title">Importar datos</h1>
    </div>

    <div class="col-12 mt-2">
        <p>Importa datos desde un archivo de Excel o CSV a la tabla que necesites, recuerda que los campos deben coincidir</p>

        <form action="#" class="row">
            <div class="form-group col-5">
                <label for="Table">¿En qué tabla quieres importar?</label>
                <select class="form-control" id="Table">
                    <option value="1">Claro</option>
                    <option value="2">Galicia</option>
                    <option value="3">Jubilados</option>
                    <option value="4">Macro</option>
                    <option value="5">Movistar</option>
                    <option value="6">Obras sociales</option>
                    <option value="7">Personal</option>
                </select>
            </div>
            <div class="col-7"></div>
            <div class="form-group col-5">
                <label for="file">Selecciona el archivo:</label>
                <input type="file" class="form-control-file" name="ExcelFile" id="ExcelFile">
            </div>
        </form>

        <button type="button" class="btn btn-primary" id="Import">Importar</button>

        <div class="progress-bar-container hide" id="progress">
            <div class="progress mt-4">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div><br>
            </div>
            <small><b>Nota:</b> El porcentaje de subida no representa el proceso de procesado y creación de tablas.</small>
        </div>
        <div class="loading-container loading-hidden mt-3" id="Processing">
            <div class="loading">
                <div class="preloader"></div>
                <span class="tag">Procesando datos y armando las tablas, estoy puede demorar minutos y hasta horas...</span>
            </div>
        </div>
    </div>
    
</div>

 @endsection