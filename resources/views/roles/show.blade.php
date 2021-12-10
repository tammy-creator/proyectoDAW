@extends('layouts.main',['activePage'=>'roles', 'titlePage'=>'Detalles del rol'])

@section('content')
	<div class="content">
    	<div class="container-fluid">
      		<div class="row">
        		<div class="col-md-12">
        			<div class="card ">
              			<div class="card-header card-header-primary">
              				<div class="card-title">Roles</div>
              				<p class="card-category">Vista detallada del rol {{ $role->name }}</p>
              			</div>
	              		<div class="card-body">	              			
	              			<div class="row">
	        					<div class="col-md-4">
	        						<div class="card card-user">
	        							<div class="card-body">
	        								<p class="card-text">
	        									<div class="author">
	        										<a href="#">
	        											<img src="{{ asset('/material/img/images.png')}}" alt="image" class="avatar">
	        											<h5 class="title mt-3">{{ $role->name }}</h5>
	        										</a>
	        										<p class="description">
	        											 {{ $role->guard_name }}  <br> 							
	        											 {{ $role->created_at }} <br>
	        											 
	        										</p>
	        									</div>
	        								</p>
	        								<div class="card-description">
	        									@forelse ($role->permissions as $permission)
	        										<span class="badge rounded-pill bg-dark text-white">{{ $permission->name}}</span>
	        									@empty
	        										<span class="badge badge-danger bg-danger">No permissions</span>
	        									@endforelse
	        								</div>
	        							</div>
	        							<div class="card-footer">
                    						<div class="button-container">
                      							<button class="btn btn-sm btn-primary">Editar</button>
                   							</div>
                  						</div>
	        						</div>
	        					</div>
	        				</div>
	        			</div>
        			</div>
        		</div>
        	</div>
    	</div>
	</div>

@endsection