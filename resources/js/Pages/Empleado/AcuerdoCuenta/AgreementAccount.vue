<template>
  <app-layout>
    <div>
      <div class="py-12">
        <!-- Widget: user widget style 1 -->
        <div class="card card-widget widget-user">
          <div class="card-header">
            <h3 class="card-title">Cuenta, Llamadas, Acuerdos y Movimientos</h3>

            <div class="card-tools">
              <button
                type="button"
                class="btn btn-tool"
                data-card-widget="collapse"
                style="border: 1px gray solid; height: 100%; margin: 0px"
              >
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>

          <div class="card-body" style="padding: 0px">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header" style="background-color: #e9ecef">
              <div
                class="widget-user-image"
                style="position: absolute; left: 70px"
              >
                <img class="img-circle elevation-2" v-bind:src="img" />
              </div>
              <!-- /.widget-user-image -->
              <h2 class="widget-user-username">Nombre:{{ cliente.name }}</h2>
              <h4 class="widget-user-desc">
                Conjunto : {{ conjunto.name_building }}
              </h4>
              <h6 class="widget-user-desc">
                Apartamento: {{ cliente.client_code }}
              </h6>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">
                    {{ acuerdo[0].description }}
                  </h5>
                  <span class="description-text">Acuerdo</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->

              <div class="col-sm-4 border-right">
                <inertia-link
                  :href="route('state.account', cliente.user_id)"
                  v-if="cuenta != 0"
                >
                  <div class="description-block">
                    <h5 class="description-header">{{ saldo }}</h5>
                    <span class="description-text">Estado cuenta</span>
                  </div>
                </inertia-link>

                <div class="description-block" v-else>
                  <button
                    type="button"
                    style="margin-top: -4px"
                    class="btn btn-success"
                    @click="abrir()"
                  >
                    Crear Cuenta
                  </button>
                </div>

                <!-- /.description-block -->
              </div>

              <!-- /.col -->
              <div class="col-sm-4">
                <inertia-link
                  class=""
                  :href="route('llamadas.create', cliente.user_id)"
                >
                  <div class="description-block">
                    <h5 class="description-header">
                      <i
                        class="nav-icon fas fa-phone text-success"
                        style="padding: 6px"
                      ></i>
                    </h5>
                    <span class="description-text">Llamar</span>
                  </div>
                </inertia-link>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
        <!-- /.widget-user -->
      </div>

      <div class="col-12">
        <div class="card card-primary collapsed-card">
          <div class="card-header">
            <h3 class="card-title">Historial de llamadas</h3>

            <div class="card-tools" v-if="acuerdos != 0">
              <button
                type="button"
                class="btn btn-tool"
                data-card-widget="collapse"
                style="border: 1px gray solid; height: 100%; margin: 0px"
              >
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 300px">
            <table class="table table-head-fixed text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Persona llamada</th>
                  <th>Telefono</th>
                  <th>Fecha / Hora</th>
                  <th>Nombre Empleado</th>
                  <th>Descripcion</th>
                  <th>Ver</th>
                </tr>
              </thead>

              <tbody>
                <tr v-if="!llamadas"></tr>

                <tr v-else v-for="(row, index) in llamadas">
                  <td>{{ row.id_call }}</td>
                  <td style="width: 120px">
                    <div style="width: 150px; overflow: hidden">
                      {{ row.name_call }}
                    </div>
                  </td>
                  <td>{{ row.phone_call }}</td>
                  <td>{{ row.created_at }}</td>
                  <td>{{ row.employee_id }}</td>
                  <td style="width: 240px">
                    <div style="width: 250px; overflow: hidden">
                      {{ row.description }}
                    </div>
                  </td>
                  <td>
                    <button
                      type="button"
                      style="margin-top: -4px"
                      class="btn btn-success"
                      @click="verLlamada(index)"
                    >
                      <i class="nav-icon fas fa-eye text-info"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lista de acuerdos</h3>

            <div class="card-tools" v-if="acuerdos != 0">
              <inertia-link :href="route('llamadas.create', cliente.user_id)">
                <button class="btn btn-dark float">
                  <i class="fas fa-plus"></i> Crear nuevo acuerdo
                </button>
              </inertia-link>

              <button
                type="button"
                class="btn btn-tool"
                data-card-widget="collapse"
                style="border: 1px gray solid; height: 100%; margin: 0px"
              >
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 400px">
            <table class="table table-head-fixed text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tipo de acuerdo</th>
                  <th>Fecha</th>
                  <th>Empleado</th>
                  <th>Acciones</th>
                </tr>
              </thead>

              <tbody>
                <tr v-if="!acuerdos"></tr>

                <tr v-for="(row, index) in acuerdos" v-else>
                  <td>
                    {{ row.id_agreement }}
                  </td>
                  <td>
                    {{ row.description }}
                  </td>
                  <td>
                    {{ row.created_at }}
                  </td>
                  <td>
                    {{ row.name_employee }}
                  </td>

                  <td>
                    <button
                      type="button"
                      style="margin-top: -4px"
                      class="btn btn-success"
                      @click="ver(index)"
                    >
                      <i class="nav-icon fas fa-eye text-info"></i>
                    </button>

                    <!--  <inertia-link class="" :href="route('llamadas.create',row.id)">
                            <i class="nav-icon fas fa-hands-helping text-success" style="padding:6px;"></i>  
                        </inertia-link> -->
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer"></div>
        </div>
        <!-- /.card -->
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lista de Movimientos</h3>

            <div class="card-tools" v-if="cuenta != 0">
              <button
                class="btn btn-dark float"
                @click="abrirCrearMovimiento()"
              >
                <i class="fas fa-plus"></i> Agregar Movimiento
              </button>
              <button
                type="button"
                class="btn btn-tool"
                data-card-widget="collapse"
                style="border: 1px gray solid; height: 100%; margin: 0px"
              >
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 400px">
            <table class="table table-head-fixed text-nowrap">
              <thead>
                <tr>
                  <th>ID movimiento</th>
                  <th>Descripcion movimiento</th>
                  <th>Valor</th>
                  <th>Fecha</th>
                  <th>Acciones</th>
                </tr>
              </thead>

              <tbody>
                <tr v-if="movimientos === 0"></tr>
                <tr v-for="(row, index) in movimientos" v-else>
                  <td>
                    {{ row.id_movement }}
                  </td>
                  <td>
                    {{ row.description_movement }}
                  </td>
                  <td style="text-align: right">
                    {{ row.valor_movement }}
                  </td>
                  <td>
                    {{ row.date }}
                  </td>

                  <td>
                    <button
                      type="button"
                      style="margin-top: -4px"
                      class="btn btn-success"
                      @click="verMovimiento(index)"
                    >
                      <i class="nav-icon fas fa-eye text-info"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer"></div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lista de Archivos</h3>

            <div class="card-tools" >
              <button
                type="button"
                class="btn btn-outline-dark float-right"
                data-toggle="modal"
                data-target="#UploadModal"
              >
                Subir Archivo
              </button> 
              <button
                type="button"
                class="btn btn-tool"
                data-card-widget="collapse"
                style="border: 1px gray solid; height: 100%; margin: 0px"
              >
                <i class="fas fa-minus"></i>
              </button>
              
            </div>
          </div>
            <upload-file v-bind:cliente_id="cliente.user_id" />

          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 400px">
            <table class="table table-head-fixed text-nowrap">
              <thead>
                <tr>
                  <th>Descripcion</th>
                  <th>Fecha</th>
                  <th>Vista Previa</th>
                </tr>
              </thead>

              <tbody>
                <tr v-if="files === 0"></tr>

                <tr v-for="row in files" v-else>
                  <td>
                    {{ row.description }}
                  </td>
                  <td>
                    {{ toLocaleDateString(row.created_at) }}
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-primary"
                      data-toggle="modal"
                      data-target=".bd-example-modal-lg"
                      @click="getImage(row.id)"
                    >
                      <i class="fas fa-eye"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer"></div>
        </div>
        <!-- /.card -->
      </div>

      <!-- Modal imagen -->
      <div
        class="modal fade bd-example-modal-lg"
        tabindex="-1"
        style="margin-top: 1px"
        role="dialog"
        aria-labelledby="myLargeModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-lg">
          <div
            class="modal-content"
            style="border: none; box-shadow: none; background: transparent"
          >
            <div class="modal-header" style="border-bottom: none">
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span style="color: white" aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
          <img
            style="left: 50%; transform: translateX(-50%)"
            class="modal-body"
            :src="image"
          />
        </div>
      </div>
      <!--  -->

      <create-account v-bind:cliente_id="cliente.user_id" />
      <movements v-bind:cliente_id="cliente.user_id" />
      <agreement-modal
        v-bind:acuerdo="acuerdos"
        v-bind:id="inde"
        v-bind:totalCuenta="cuenta"
      />
      <show-movement-modal
        v-bind:movimiento="movimientos"
        v-bind:id="id_movement"
        v-bind:boleno="bol_dos"
      />
      <call-modal
        v-bind:llamadas="llamadas"
        v-bind:ides="inde2"
        v-bind:id="state"
        v-bind:kk="llam"
        v-bind:name="cliente.name"
      />
    </div>
  </app-layout>
</template>
<script>
import CallModal from "@/Kobranzas/CallModal";
import AppLayout from "@/Layouts/AppLayout";
import AgreementModal from "@/Kobranzas/AgreementModal";
import CreateAccount from "@/Kobranzas/CreateAccount";
import Movements from "@/Kobranzas/MovementsModal";
import ShowMovementModal from "@/Kobranzas/ShowMovementModal";
import UploadFile from "@/Kobranzas/UploadFile";

export default {
  props: [
    "conjunto",
    "cliente",
    "cuenta",
    "acuerdo",
    "photo",
    "acuerdos",
    "movimientos",
    "llamadas",
  ],
  components: {
    AppLayout,
    CallModal,
    CreateAccount,
    AgreementModal,
    ShowMovementModal,
    Movements,
    UploadFile,
  },
  created() {
    this.buscarResultados();
    this.saldoDecimal();
    this.getFiles();
  },
  data() {
    return {
      usuariosc: [],
      buscar: "",
      saldo: this.cuenta,
      archivo: [],
      setTimeoutBuscador: "",
      img: this.photo,
      inde: 0,
      id_movement: 0,
      bol: -1,
      bol_dos: -1,

      inde2: 0,
      llam: -1,
      index: "",
      state: 0,
      files: [],
      image: "",
    };
  },
  methods: {
    toLocaleDateString(date) {
      var options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
        hour12: "true",
      };
      var dateConverted = new Date(date).toLocaleString("es-US", options);
      return dateConverted;
    },
    getImage(id) {
      var path = this.files;
      var item = path.find((item) => item.id === id);
      this.image = "/storage/" + item.path;
    },
    getFiles() {
      axios
        .post("/files", {
          id: this.cliente.user_id,
        })
        .then((response) => {
          this.files = response.data;
        });
    },
    buscarResultados() {
      axios
        .get("/buscar", {
          params: {
            buscar: this.buscar,
          },
        })
        .then((res) => {
          console.log("exito al cargar resultados");
        })
        .catch((error) => {
          console.log(error.response);
        });
    },
    buscarKUP() {
      clearTimeout(this.setTimeoutBuscador);
      this.setTimeoutBuscador = setTimeout(this.buscarResultados, 360);
    },

    saldoDecimal() {
      var num = String(this.cuenta);
      var nn = this.formatear(num);
      this.saldo = nn;
    },
    formatear(input_val) {
      // check for decimal
      if (input_val.indexOf(".") >= 0) {
        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = this.formatNumber(left_side);

        // validate right side
        right_side = this.formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
          right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = left_side + "." + right_side;
        return input_val;
      } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = this.formatNumber(input_val);
        return input_val;
      }
    },
    formatNumber(n) {
      // format number 1000000 to 1,234,567
      return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    sinFormatNumber(n) {
      return n.replace(/,/g, "");
    },
    ver(id) {
      this.inde = id;
      this.bol = 0;

      $("#myModal").modal();
    },
    verMovimiento(id) {
      this.id_movement = id;
      this.bol_dos = 0;

      $("#showMovementModal").modal();
    },
    verLlamada(id) {
      this.inde = id;
      this.llam = 0;

      this.state = this.llamadas[id].state_id;

      $("#myModalCall").modal();
    },

    abrir() {
      $("#CreateAccountModal").modal();
    },
    abrirCrearMovimiento() {
      $("#movementModal").modal();
    },
  },
};
</script>