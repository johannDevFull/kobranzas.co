<template>
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <form @submit.prevent="submit">
                       
            <div class="modal fade" id="modalSubscriptionForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header text-center">
                      <h4 class="modal-title w-100 font-weight-bold">Crear permiso</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body mx-3">
                      <div class="md-form mb-5">
                        <i class="fas fa-user prefix grey-text"></i>
                        <label for="first_name">Nombre permiso:</label>
                        <input id="first_name" v-model="form.name" />
                      </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button class="btn btn-primary" type="submit">Crear permiso</button> 
                    </div>
                  </div>
                </div>
            </div>
                
            

        </form>

    </div>
</template>

<script> 

    export default {
        components: { 
        },
        
        data() {
            return {
              form: {
                name: null, 
              },
            }
        },

        methods: {
            submit(form){
              
              this.$inertia.post('permiso', this.form,{
                onSuccess:()=>{
                  alert("Exíto a crear permiso");
                },
              })
                   
            },
        },
    }
</script>
