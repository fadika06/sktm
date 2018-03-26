<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> SKTM 

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
            <b>Nomor Un :</b> {{ model.nomor_un }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Kode SKTM  :</b> {{ model.kode_sktm }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Nama Suket :</b> {{ model.nama_suket }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Instansi Suket :</b> {{ model.instansi_suket }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Nomor Suket :</b> {{ model.no_suket }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Nilai SKTM :</b> {{ model.nilai_sktm }}
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
    axios.get('api/sktm/' + this.$route.params.id)
      .then(response => {
        if (response.data.status == true) {
          this.model.user = response.data.user;
          this.model.nomor_un = response.data.sktm.nomor_un;
          this.model.kode_sktm = response.data.sktm.kode_sktm;
          this.model.nama_suket = response.data.sktm.nama_suket;
          this.model.instansi_suket = response.data.sktm.instansi_suket;
          this.model.nomor_suket = response.data.sktm.nomor_suket;
          this.model.nilai_sktm = response.data.sktm.nilai_sktm;
        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/sktm';
      })

  },
  data() {
    return {
      state: {},
      model: {
        user: "",
        nomor_un: "",
        kode_sktm: "",
        nama_suket: "",
        instansi_suket: "",
        no_suket: "",
        nilai_sktm: "",
        created_at:       "",
        updated_at:       "",
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
        axios.put('api/siswa/' + this.$route.params.id, {
            user_id: this.model.user.id,
            nomor_un: this.model.nomor_un,
            kode_sktm: this.model.kode_sktm,
            nama_suket: this.model.nama_suket,
            instansi_suket: this.model.instansi_suket,
            no_suket: this.model.no_suket,
            nilai_sktm: this.model.nilai_sktm
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
      axios.get('api/siswa/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.status == true) {
            this.model.label = response.data.siswa.label;
            this.model.description = response.data.siswa.description;
          } else {
            alert('Failed');
          }
        })
        .catch(function(response) {
          alert('Break ');
        });
    },
    back() {
      window.location = '#/admin/sktm';
    }
  }
}
</script>
