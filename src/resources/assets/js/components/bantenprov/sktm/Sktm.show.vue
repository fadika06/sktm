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

        <div class="form-row">
          <div class="col-md">
            <b>Nama Siswa :</b> {{ model.siswa.nama_siswa }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Master SKTM  :</b> {{ model.master_sktm.instansi }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Nomor SKTM :</b> {{ model.no_sktm }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Nilai :</b> {{ model.nilai_sktm }}
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
          this.model.siswa = response.data.siswa;
          this.model.master_sktm = response.data.sktm.master_sktm;
          this.model.no_sktm = response.data.sktm.no_sktm;
          this.model.nilai_sktm = response.data.sktm.nilai;
          this.model.created_at = response.data.sktm.created_at;
          this.model.updated_at = response.data.sktm.updated_at;
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
        siswa: "",
        master_sktm: "",
        no_sktm: "",
        nilai_sktm: "",
        created_at:       "",
        updated_at:       ""
      },
      user: [],
      master_sktm: [],
      siswa: []
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
            siswa_id: this.model.siswa.id,
            master_sktm_id: this.model.master_sktm.id,
            no_sktm: this.model.no_sktm,
            nilai_sktm: this.model.nilai_sktm,
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
      axios.get('api/sktm/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.status == true) {
            
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
