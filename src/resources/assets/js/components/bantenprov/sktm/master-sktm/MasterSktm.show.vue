<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Master SKTM 

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <button class="btn btn-primary btn-sm" role="button" @click="back">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <vue-form class="form-horizontal form-validation" :state="state" @submit.prevent="onSubmit">

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Nama :</b> {{ model.nama }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Nilai :</b> {{ model.nilai }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Instansi :</b> {{ model.instansi }}
          </div>
        </div>
        
      </vue-form>
    </div>
       <div class="card-footer text-muted">
        <div class="row">
          <div class="col-md">
            <b>Username :</b> {{ model.user.name }}
          </div>
          <div class="col-md">
            <div class="col-md text-right">Dibuat : {{ model.created_at }}</div>
            <div class="col-md text-right">Diperbaiki : {{ model.updated_at }}</div>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
export default {
  mounted() {
    axios.get('api/master-sktm/' + this.$route.params.id)
      .then(response => {
        if (response.data.status == true) {
          this.model.user = response.data.user;
          this.model.nama = response.data.master_sktm.nama;
          this.model.nilai = response.data.master_sktm.nilai;
          this.model.instansi = response.data.master_sktm.instansi;
          this.model.created_at = response.data.master_sktm.created_at;
          this.model.updated_at = response.data.master_sktm.updated_at;
        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/master-sktm/';
      })

  },
  data() {
    return {
      state: {},
      model: {
        user: "",
        nama: "",
        nilai: "",
        instansi: "",
        created_at: "",
        updated_at: ""
      },
      user: []
    }
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.put('api/master-sktm/' + this.$route.params.id, {
            nama: this.model.nama,
            nilai: this.model.nilai,
            instansi: this.model.instansi,
            user_id: this.model.master_sktm.id,
            created_at: this.model.created_at,
            updated_at: this.model.updated_at
          })
          .then(response => {
            if (response.data.status == true) {
              if(response.data.message == 'success'){
                alert(response.data.message);
                app.back();
              }else{
                alert(response.data.message);
              }
            } else {
              alert(response.data.message);
            }
          })
          .catch(function(response) {
            alert('Break ' + response.data.message);
          });
      }
    },
    reset() {
      axios.get('api/master-sktm/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.status == true) {
            this.model.label = response.data.sktm.label;
            this.model.description = response.data.sktm.description;
          } else {
            alert('Failed');
          }
        })
        .catch(function(response) {
          alert('Break ');
        });
    },
    back() {
      window.location = '#/admin/master-sktm/';
    }
  }
}
</script>
