<template>
  <app-layout>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Cambios Realizados por:</h3>
      </div>
      <div class="card card-widget widget-user-2">
        <div class="widget-user-header bg-warning">
          <div class="widget-user-image">
            <img
              class="img-circle elevation-2"
              :src="userinfo.profile_photo_url"
              alt="User Avatar"
            />
          </div>
          <h3 class="widget-user-username">{{ userinfo.name }}</h3>
          <h5 class="widget-user-desc">{{ userinfo.roles[0].name }}</h5>
        </div>
        <div class="card-footer p-0">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link">
                Correo <span class="float-right">{{ userinfo.email }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link">
                Telefono
                <span class="float-right">{{ userinfo.phone_one }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link">
                Tipo de Documento
                <span class="float-right">{{
                  transformString(userinfo.doc_type)
                }}</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link">
                Documento
                <span class="float-right">{{ userinfo.document }}</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="card collapsed-card bg-gradient-info my-2 mx-4">
        <div class="card-header">
          <h3 class="card-title">Mas información</h3>
          <div class="card-tools">
            <button
              type="button"
              data-card-widget="collapse"
              class="btn btn-tool"
            >
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">Acción: {{ toSpanish(auditinfo.event) }}</div>
        <div class="card-body">
          Tipo: {{ modelSpanish(auditinfo.auditable_type) }}
        </div>  
        <div class="card-body">
          {{ convert(auditinfo.event) }} el:
          {{ toLocaleDateString(auditinfo.created_at) }}
        </div>

        <div
          v-if="
            !auditinfo.user_id &&
            auditinfo.auditable_type == `App\\Models\\User` &&
            auditinfo.event == 'updated'
          "
        >
          <div class="card-body">
            <ul>
              Cambió su contraseña
            </ul>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from "@/Layouts/AppLayout";
import JetNavLink from "@/Jetstream/NavLink";

export default {
  props: ["userinfo", "auditinfo"],
  components: {
    AppLayout,
    JetNavLink,
  },
  data() {
    return {
      disabled: true,
      selected: this.userinfo.doc_type,
      name: this.userinfo.name,
      email: this.userinfo.email,
      document: this.userinfo.document,
      phone_one: this.userinfo.phone_one,
      phone_two: this.userinfo.phone_two,
      errors: [],
    };
  },
  methods: {
    transformString(string) {
      switch (string) {
        case "cedula_ciudadania":
          return "Cédula de ciudadanía";
          break;

        default:
          return "Cédula de Extrangería";
          break;
      }
    },

    toggle() {
      this.disabled = !this.disabled;
    },

    convert(action) {
      switch (action) {
        case "created":
          return "Creado";
        case "updated":
          return "Actualizado";
        case "deleted":
          return "Eliminado";
        case "restored":
          return "Restaurado";
        default:
          return "Realizado";
      }
    },

    toSpanish(action) {
      switch (action) {
        case "created":
          return "Creó";
        case "updated":
          return "Actualizó";
        case "deleted":
          return "Eliminó";
        case "restored":
          return "Restauró";
        default:
          return "Otra";
      }
    },

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
    modelSpanish(model) {
      switch (model) {
        case `App\\Models\\User`:
          return "Usuario";
        case `App\\Models\\Buildings`:
          return "Conjunto";
        case `App\\Models\\Calls`:
          return "LLamada";
        case `App\\Models\\Llamadas`:
          return "Llamadas";
        case `App\\Models\\State`:
          return "Estado";
        case `App\\Models\\Movements`:
          return "Movimiento";
        case `App\\Models\\Agreement`:
          return "Acuerdo";
        /*

         //agregar mas modelos

        */
        default:
          return "Otro";
      }
    },
  },
};
</script>