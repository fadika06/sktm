<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Edit Master SKTM

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
            <validate tag="div">
              <label for="model-nama">Nama</label>
              <input class="form-control" v-model="model.nama" required autofocus name="nama" type="text" placeholder="Nama">

              <field-messages name="nama" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Nama is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="model-nilai">Nilai</label>
              <input class="form-control" v-model="model.nilai" required autofocus name="nilai" type="text" placeholder="Nilai">

              <field-messages name="nilai" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Nilai is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="model-instansi">Instansi</label>
              <input class="form-control" v-model="model.instansi" required autofocus name="instansi" type="text" placeholder="Instansi">

              <field-messages name="instansi" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Instansi is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="user_id">Username</label>
            <v-select name="user_id" v-model="model.user" :options="user" class="mb-4"></v-select>

            <field-messages name="user_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Username is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <button type="submit" class="btn btn-primary">Submit</button>

            <button type="reset" class="btn btn-secondary" @click="reset">Reset</button>
          </div>
        </div>

      </vue-form>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    axios.get('api/master-sktm/' + this.$route.params.id + '/edit')
      .then(response => {
        if (response.data.status == true) {
          this.model.user = response.data.user;
          this.model.nama = response.data.master_sktm.nama;
          this.model.nilai = response.data.master_sktm.nilai;
          this.model.instansi = response.data.master_sktm.instansi;
        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/master-sktm/';
      }),

      axios.get('api/master-sktm/create')
      .then(response => {
          response.data.user.forEach(user_element => {
            this.user.push(user_element);
          });
      })
      .catch(function(response) {
        alert('Break');
      })
  },
  data() {
    return {
      state: {},
      model: {
        user: "",
        nama: "",
        nilai: "",
        instansi: ""
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
            user_id: this.model.user.id,
            nama: this.model.nama,
            nilai: this.model.nilai,
            instansi: this.model.instansi
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
            this.model.nama = response.data.master_sktm.nama;
            this.model.nilai = response.data.master_sktm.nilai;
            this.model.instansi = response.data.master_sktm.instansi;
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
