<template>
  <div  >
    
      <!-- Modal -->
        <div class="modal fade " id="myModalCall" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles llamada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            
              <div class="modal-body" v-if="kk===-1">

              </div>

              <div class="modal-body" v-else>
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Nombre cliente: {{name}} </h3> 
                    <div class="card-tools">
                      
                    </div>
                  </div> 
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="inputName">Nombre persona llamada</label>
                          <input type="text" id="inputName" class="form-control" v-bind:value="llamadas[ides].name_call" disabled>
                        </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="inputPhone">Telefono llamada</label>
                          <input type="text" id="inputPhone" class="form-control" v-bind:value="llamadas[ides].phone_call" disabled>
                        </div>
                      </div>
                                            
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="inputDescription">Descripcion llamada</label>
                          <textarea id="inputDescription" v-bind:value="llamadas[ides].description" class="form-control" rows="3" disabled>
                          </textarea> 
                        </div>
                      </div>

                      <div class="col-md-3"> 
                        <label>Estado</label>
                        <span class="required">*</span>
                        <select class="form-control" v-bind:value="id" disabled>
                          <option value="" >Seleccione Estado</option>
                          <option v-for="option in estados" v-bind:value="option.id_state">
                            {{ option.description }}
                          </option>
                        </select>
                      </div>
     
                      
                      <div class="col-md-5">
                        <div class="form-group">
                          <label for="inputClientCompany">Empleado</label>
                          <input type="text" v-bind:value="llamadas[ides].employee_id" class="form-control" value="Deveint Inc" disabled>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="inputProjectLeader">Fecha / Hora</label>
                          <input type="text" v-bind:value="llamadas[ides].created_at" class="form-control" value="Tony Chicken" disabled>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="modal-footer" >
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!-- <button type="button" class="btn btn-primary">Actualizar</button> -->
              </div>

            </div>
          </div>

        </div>

    
    
  </div>
</template>

<script>  
  
  export default { 
      props: ['llamadas','ides','id','name','kk'],
      
      components:{

      },
      created(){ 
        this.buscarEstados() 
      },
      
      data() {
          return {  
            estados:[],  
            sel:this.id,  
          }
      },
      methods: {
        
        buscarEstados(){
          axios.get('/buscar/estados',{
                
          })
          .then( resp => { 
              this.estados=resp.data  
          })
          .catch( error => {
              console.log( error.response )
          });
        },
          

      },
  }
</script>
