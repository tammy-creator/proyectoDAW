@extends('layouts.main',['activePage'=>'roles', 'titlePage'=>'Editar rol'])
@section('content')
	<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('roles.update', $role->id) }}" class="form-horizontal">
            @csrf            
            @method('PUT')
            <div class="card ">

              @if($errors->any())
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li> {{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Roles') }}</h4>
                <p class="card-category">{{ __('Editar rol') }}</p>
              </div>
              <div class="card-body ">
                
                <div class="row">
                  <label for="name" class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
                  <div class="col-sm-7">                   
                    <input class="form-control" name="name" type="text" autofocus value="{{old('name', $role->name)}}">
                   
                  </div>
                </div>
                <div class="row">
                  <label for="name" class="col-sm-2 col-form-label">Permisos</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <div class="tab-content">
                        <div class="tab-pane active">
                          <table class="table">
                            <tbody>
                              @foreach ($permissions as $id=> $permission)                              
                              <tr>
                                <td>
                                  <div class="form-check">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $id}}" {{ $role->permissions->contains($id) ? 'checked' : ''}}>
                                      <span class="form-check-sign">
                                        <span class="check"></span>
                                      </span>
                                    </label>
                                  </div>
                                </td>
                                <td>
                                  {{$permission}}
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>                    
                  </div>
                </div>
               
                
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Actualizar') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
      
@endsection