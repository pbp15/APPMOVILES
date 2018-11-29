<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
           
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
               
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Comidas
                        <button type="button" @click="abrirModal('comida','registrar')" class="btn btn-secondary" >
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3"  v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarComida(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarComida(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>   
                                     <th>Categoria</th>                                                                                                      
                                    <th>Precio_venta</th>
                                    <th>Imagen</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="comida in arrayComida" :key="comida.id">
                                    <td>
                                        <button type="button" @click="abrirModal('comida','actualizar',comida)" 
                                        class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template     v-if="comida.condicion">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarComida(comida.id)" >
                                                <i class="icon-trash"></i>
                                                </button>
                                        </template>

                                         <template     v-else>
                                                <button type="button" class="btn btn-info btn-sm" @click="activarComida(comida.id)" >
                                                        <i class="icon-check"></i>                                            
                                                </button>
                                        </template>
                                    </td>
                                  
                                   <td v-text="comida.nombre"></td>    
                                   <td v-text="comida.nombre_categoria"></td>                               
                                   <td v-text="comida.precio_venta"></td>
                                    <td v-text="comida.imagen"></td>
                                   <td v-text="comida.descripcion"></td>
                                   <td>
                                        <div v-if="comida.condicion"> 
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else> 
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page >1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item " v-for="page in pagesNumber " :key="page" :class="[page ==isActived ? 'actived' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page">1</a>
                                </li>
                              
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                             
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categoria</label>
                                    <div class="col-md-9">
                                       <select class="form-control" v-model="idcategoria">
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"> </option>
                                      </select>
                                          </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre de comida </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Comida">
                                      </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio Venta</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="precio_venta" class="form-control" placeholder="">
                                       
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Imagen</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="imagen" class="form-control" placeholder="Subir la imagen">
                                       
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text"  v-model="descripcion"  class="form-control" placeholder="Ingrese descripcion">
                                    </div>
                                </div>
                                    <div v-show="errorComida" class="form-group row  div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error  in errorMostrarMsjComida" :key="error" v-text="error">

                                            </div>

                                        </div>

                                    </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                             <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarComida()">Guardar</button>
                             <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarComida()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <!-- Inicio del modal Eliminar -->
           
            <!-- Fin del modal Eliminar -->
        </main>
</template>

<script>
    export default {
        data(){
                 return {
                     comida_id: 0,
                     idcategoria : 0 ,
                     nombre_categoria : '',
                     nombre : '',
                     precio_venta : 0,
                     imagen : '',
                     descripcion : '',
                     arrayComida :  [],
                     modal : 0,
                     tituloModal  : '',
                     tipoAccion : 0,
                     errorComida : 0 ,
                     errorMostrarMsjComida: [],
                     pagination:{
                              'total':0  ,
                              'current_page':0  ,
                              'per_page':0  ,
                             'last_page':0  ,
                              'from':0  ,
                            'to':0  ,

                     },
                     offset : 3,
                     criterio:'nombre',
                     buscar:'',
                     arrayCategoria :[]

                 }
            },
            computed :{
                isActived: function (){
                    return this.pagination.current_page;

                },
                
                //calcula los elementos de paginacion

                pagesNumber: function(){
                    if(!this.pagination.to){
                        return[];
                    }
                
                var from =this.pagination.current_page - this.offset;
                if(from < 1){
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray =  [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
                }
           },

            methods : {
            listarComida (page,buscar,criterio){
                    let me=this;           
                    var url = '/comida?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
                     axios.get(url).then(function(response){
                         var respuesta= response.data;
                         me.arrayComida = respuesta.comidas.data;
                         me.pagination = respuesta.pagination;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                     
            },
           

            selectCategoria (){
                  let me=this;           
                    var url = '/categoria/selectCategoria';
                     axios.get(url).then(function(response){
                       // console.log(response);
                         var respuesta= response.data;
                         me.arrayCategoria = respuesta.categorias;
                         
                    })
                    .catch(function(error){
                        console.log(error);
                    });        


            },

            cambiarPagina (page,buscar,criterio){
                let me = this;               
                //actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar la data de esa pagina
                me.listarComida(page,buscar,criterio);
            },

             registrarComida(){
                 if(this.validarComida()){

                     return;
                 }

                 let me = this;

                 axios.post('/comida/registrar',{
                     'idcategoria': this.idcategoria,
                       'nombre': this.nombre,
                     'precio_venta': this.precio_venta,
                     'imagen': this.imagen,
                     'descripcion': this.descripcion

                 }).then(function(response){
                        me.cerrarModal();
                        me.listarComida(1,'','nombre');
                 }).catch(function(error){
                        console.log(error);
                    });
                                
            },
            actualizarComida(){

                  if(this.validarComida()){

                     return;
                 }

                 let me = this;

                 axios.put('/comida/actualizar',{
                      'idcategoria': this.idcategoria,
                       'nombre': this.nombre,
                     'precio_venta': this.precio_venta,
                     'imagen': this.imagen,
                     'descripcion': this.descripcion,
                     'id': this.comida_id

                 }).then(function(response){
                        me.cerrarModal();
                        me.listarComida(1,'','nombre');
                 }).catch(function(error){
                        console.log(error);
                    });
                        

            },
            desactivarComida(id){
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    })

                    swalWithBootstrapButtons({
                    title: 'Estas seguro de desactivar esta comida?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar Simpatico!',
                    cancelButtonText: 'Cancelar Simpatico!',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.put('/comida/desactivar',{
                            
                            'id': id

                        }).then(function(response){
                               
                                me.listarComida(1,'','nombre');

                                swalWithBootstrapButtons(
                                'Desactivado Simpatico!',
                                'El registro ha sido desactivado con exito',
                                'success'
                                )
                        }).catch(function(error){
                                console.log(error);
                            });

                        
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {
                      
                    }
                })

            },

            activarComida(id){
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    })

                    swalWithBootstrapButtons({
                    title: 'Estas seguro de activar esta comida?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar Simpatico!',
                    cancelButtonText: 'Cancelar Simpatico!',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.put('/comida/activar',{
                            
                            'id': id

                        }).then(function(response){
                               
                                me.listarCategoria();

                                swalWithBootstrapButtons(
                                'Activado Simpatico!',
                                'El registro ha sido activado con exito',
                                'success'
                                )
                        }).catch(function(error){
                                console.log(error);
                            });

                        
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {
                      
                    }
                })

            },

           

            validarComida(){
                this.errorComida=0;
                this.errorMostrarMsjComida = [] ;


                if(this.idcategoria==0) this.errorMostrarMsjComida.push("El nombre de la categoria no puede estar vacio");
                 if(!this.nombre) this.errorMostrarMsjComida.push("El nombre de la comida no puede estar vacio");
               if(!this.precio_venta) this.errorMostrarMsjComida.push("El precio de venta de la comida debe ser un numero");
        



                if(this.errorMostrarMsjComida.length) this.errorComida = 1 ;

                return this.errorComida;
                       },
            cerrarModal(){
                 this.modal=0;
                 this.tituloModal='';
                 this.idcategoria=0;
                 this.nombre_categoria='';
                 this.nombre='';
                 this.precio_venta = 0;
                 this.imagen='';
                 this.descripcion='';
                 this.errorComida=0;

            },
            abrirModal(modelo, accion , data = []){
                     switch(modelo){
                         case "comida":
                         {
                             switch(accion){
                                 case 'registrar':
                                 {
                                          this.modal = 1;
                                          this.tituloModal ='Registrar Comida';
                                          this.idcategoria=0;
                                          this.nombre_categoria='';
                                          this.nombre='';
                                          this.precio_venta = 0;
                                          this.imagen='';
                                          this.descripcion='';
                                           this.tipoAccion= 1;
                                          break;

                                 }
                                 case 'actualizar':
                                 {
                                     this.modal = 1;
                                     this.tituloModal ='Actualizar Comida';
                                     this.tipoAccion =2;
                                     this.comida_id=data['id'];
                                     this.idcategoria=data['idcategoria'];
                                     this.nombre=data['nombre'];
                                    this.precio_venta = data['precio_venta'];
                                    this.imagen=data['imagen'];
                                    this.descripcion=data['descripcion'];
                                     break;


                                 }
                             }
                        }
                     }
                     this.selectCategoria();
               }
         },
             
            
        mounted() {
            this.listarComida(1,this.buscar,this.criterio);
        }
    }
</script>

<style>
   .modal-content {
       width: 100% !important;
       position: absolute !important;

   }
   .mostrar {
       display: list-item  !important;
       opacity: 1 !important;
       position: absolute !important;
       background-color:  #3c29297a !important; 
   }
   .div-error{
       display: flex;
       justify-content: center;

   }
   .text-error{
       color:red  !important;
       font-weight: bold;/*en negrita el bold es*/
   }

</style>
