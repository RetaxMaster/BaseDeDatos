 @extends('../template/template')

 @section('content')
    
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center title">Inicia sesión</h1>
                    <form method="POST" action="{{ route('login') }}" class="mt-4">
                        @csrf
                        <div class="form-group">
                            <label for="username">Nombre de usuario:</label>
                            <input id="username" type="text" class="form-control @error('user') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus placeholder="Nombre de usuario">

                            @error('username')
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

                        {{-- <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remember">Recordarme</label>
                            </div>
                        </div> --}}
                        
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                        </div>
                    </form>
                    @error('login_failed')
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
</div>

 @endsection