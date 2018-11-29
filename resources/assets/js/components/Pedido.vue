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
                        <i class="fa fa-align-justify"></i> Pedidos
                        <button type="button" @click="abrirModal('pedido','registrar')" class="btn btn-secondary" >
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <button type="button" @click="cargarPdf()" class="btn btn-info" >
                            <i class="icon-doc"></i>&nbsp;Reporte
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3"  v-model="criterio">
                                      <option value="codigo">Codigo_Pedido</option>
                                      <option value="fecha_hora">Fecha_hora</option>
                                       <option value="numero_mesa">Nº de Mesa </option>
                                       
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPedido(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarPedido(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                     <th>Codigo</th>
                                    <th>Nombre del Pedido</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Nº de Mesa </th>
                                    <th> Fecha_hora </th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="pedido in arrayPedido" :key="pedido.id">
                                    <td>
                                        <button type="button" @click="abrirModal('pedido','actualizar',pedido)" 
                                        class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template     v-if="pedido.condicion">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarPedido(pedido.id)" >
                                                <i class="icon-trash"></i>
                                                </button>
                                        </template>

                                         <template     v-else>
                                                <button type="button" class="btn btn-info btn-sm" @click="activarPedido(pedido.id)" >
                                                        <i class="icon-check"></i>                                            
                                                </button>
                                        </template>
                                    </td>
                                    <td v-text="pedido.codigo"></td>
                                     <td v-text="pedido.nombre_comida"></td>
                                    <td v-text="pedido.cantidad_platos"></td>
                                     <td v-text="pedido.precio_venta"></td>
                                    <td v-text="pedido.numero_mesa"></td>
                                     <td v-text="pedido.fecha_hora"></td>
                                    <td>
                                        <div v-if="pedido.condicion"> 
                                            <span class="badge badge-success">Orden Pedida</span>
                                        </div>
                                        <div v-else> 
                                            <span class="badge badge-danger">Orden No Pedida</span>
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
                                <li class="page-item " v-for="page in pagesNumber " :key="page" :class="[page == isActived ? 'actived' : '']">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Comidas</label>
                                    <div class="col-md-9">
                                      <select class="form-control" v-model="idcomida" >
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="comida  in arrayComida" :key="comida.id" :value="comida.id" v-text="comida.nombre"></option>
                                      </select>
                                       
                                    </div>
                                </div>          
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codigo" class="form-control" placeholder="Código de barras"> 
                                        <barcode :value="codigo" :options="{ format: 'EAN-13' }">
                                            Generando código de barras.    
                                        </barcode>                                       
                                    </div>
                                </div>
                                                            
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Cantidad</label>
                                    <div class="col-md-9">
                                        <input type="number"  v-model="cantidad_platos"  class="form-control" >
                                    </div>
                                </div>
                           
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Numero de Mesa</label>
                                    <div class="col-md-9">
                                        <input type="number"  v-model="numero_mesa"  class="form-control" >
                                    </div>
                                </div>
                               
                                    <div v-show="errorPedido" class="form-group row  div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error  in errorMostrarMsjPedido" :key="error" v-text="error">

                                            </div>

                                        </div>

                                    </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                             <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPedido()">Agregar Pedido</button>
                             <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPedido()">Actualizar</button>
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
  import VueBarcode from 'vue-barcode';
    export default {
        data(){
                 return {
                     pedido_id: 0,
                     idcomida : 0,  
                     nombre_comida : '', 
                     codigo:'',        
                     numero_mesa : '',
                     cantidad_platos :'',
                     precio_venta : '',
                     fecha_hora : '',
                     arrayPedido :[],
                     modal : 0,
                     tituloModal  : '',
                     tipoAccion : 0,
                     errorPedido : 0 ,
                     errorMostrarMsjPedido: [],
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
                     arrayComida:[]

                 }
            },
            components: {
            'barcode': VueBarcode
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
            listarPedido (page,buscar,criterio){
                    let me=this;           
                    var url = '/pedido?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
                     axios.get(url).then(function(response){
                         var respuesta= response.data;
                         me.arrayPedido = respuesta.pedidos.data;
                         me.pagination = respuesta.pagination;
                    })
                    .catch(function(error){
                        console.log(error);
                    });
                     
            },
             cargarPdf(){
                 window.open('http://127.0.0.1:8000/pedido/listarPdf','blank');

             },
              selectComida (){
                  let me=this;           
                    var url = '/comida/selectComida';
                     axios.get(url).then(function(response){
                       // console.log(response);
                         var respuesta= response.data;
                         me.arrayComida = respuesta.comidas;
                         
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
                me.listarPedido(page,buscar,criterio);
            },

             registrarPedido(){
                 if(this.validarPedido()){

                     return;
                 }

                 let me = this;

                 axios.post('/pedido/registrar',{
                            'idcomida': this.idcomida,
                            'codigo' : this.codigo,
                            'cantidad_platos':  this.cantidad_platos,
                             'numero_mesa': this.numero_mesa
                             

                 }).then(function(response){
                        me.cerrarModal();
                        me.listarPedido(1,'','nombre');
                 }).catch(function(error){
                        console.log(error);
                    });
                                
            },
            actualizarPedido(){

                  if(this.validarPedido()){

                     return;
                 }

                 let me = this;

                 axios.put('/pedido/actualizar',{
                           'idcomida': this.idcomida,  
                           'codigo' : this.codigo,                         
                            'cantidad_platos':  this.cantidad_platos,                            
                            'numero_mesa': this.numero_mesa,                              
                               'id': this.pedido_id

                 }).then(function(response){
                        me.cerrarModal();
                        me.listarPedido(1,'','nombre');
                 }).catch(function(error){
                        console.log(error);
                    });
                        

            },
            desactivarPedido(id){
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    })

                    swalWithBootstrapButtons({
                    title: 'Estas seguro de no ordenar  este pedido?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar Simpatico!',
                    cancelButtonText: 'Cancelar Simpatico!',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.put('/pedido/desactivar',{
                            
                            'id': id

                        }).then(function(response){
                               
                                me.listarPedido(1,'','nombre');

                                swalWithBootstrapButtons(
                                'Desactivado Simpatico!',
                                'El pedido no se ha enviado con exito',
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

            activarPedido(id){
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    })

                    swalWithBootstrapButtons({
                    title: 'Estas seguro de ordenar  este pedido?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar Simpatico!',
                    cancelButtonText: 'Cancelar Simpatico!',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.put('/pedido/activar',{
                            
                            'id': id

                        }).then(function(response){
                               
                                me.listarPedido();

                                swalWithBootstrapButtons(
                                'Activado Simpatico!',
                                'El pedido  se ha enviado con exito ',
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

           

            validarPedido(){
                this.errorPedido=0;
                this.errorMostrarMsjPedido = [] ;
                 if(this.idcomida==0) this.errorMostrarMsjPedido.push("Seleccione tu pedido");
                 if(!this.numero_mesa) this.errorMostrarMsjPedido.push("El numero de  mesas no puede estar vacio");
                if(!this.cantidad_platos) this.errorMostrarMsjPedido.push("La cantidad de platos no puede estar vacio");
                if(this.errorMostrarMsjPedido.length) this.errorPedido = 1 ;

                return this.errorPedido;
                       },
            cerrarModal(){
                 this.modal=0;
                 this.tituloModal='';
                 this.idcomida = 0;
                 this.codigo='';
                 this.nombre_comida= '';
                 this.cantidad_platos='';
                 this.precio_venta=0;
                  this.numero_mesa='';
                 this.fecha_hora='';
                 this.errorPedido= 0;

                     },
            abrirModal(modelo, accion , data = []){
                     switch(modelo){
                         case "pedido":
                         {
                             switch(accion){
                                 case 'registrar':
                                 {
                                           this.modal = 1;
                                           this.tituloModal ='Registrar Pedido';
                                            this.idcomida = 0;
                                              this.codigo='';
                                             this.nombre_comida= '';
                                             this.cantidad_platos='';                                          
                                            this.numero_mesa='';         
                                            this.fecha_hora='';                                  
                                           this.tipoAccion= 1;
                                          break;

                                 }
                                 case 'actualizar':
                                 {
                                     this.modal = 1;
                                     this.tituloModal ='Actualizar Pedido';
                                     this.tipoAccion =2;
                                     this.pedido_id=data['id'];
                                      this.idcomida = data['idcomida'];
                                        this.codigo=data['codigo'];
                                       this.cantidad_platos = data['cantidad_platos '];                                     
                                       this.numero_mesa = data ['numero_mesa'];
                                       this.fecha_hora=data['fecha_hora'];
                                                                    
                                     break;


                                 }
                             }
                        }
                     }
                     this.selectComida();
               }
         },
             
            
        mounted() {
            this.listarPedido(1,this.buscar,this.criterio);
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
