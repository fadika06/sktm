<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Edit SKTM

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
            <validate tag="div">
              <label for="model-nomor_un">Nomor UN</label>
              <input class="form-control" v-model="model.nomor_un" required autofocus name="nomor_un" type="text" placeholder="Nomor UN">

              <field-messages name="nomor_un" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Nomor UN is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="model-kode_sktm">Kode SKTM</label>
              <input class="form-control" v-model="model.kode_sktm" required autofocus name="kode_sktm" type="text" placeholder="Kode SKTM">

              <field-messages name="kode_sktm" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Kode SKTM is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="model-nama_suket">Nama Suket</label>
              <input class="form-control" v-model="model.nama_suket" required autofocus name="nama_suket" type="text" placeholder="Nama Suket">

              <field-messages name="nama_suket" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Nama Suket is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="model-instansi_suket">Instansi Suket</label>
              <input class="form-control" v-model="model.instansi_suket" required autofocus name="instansi_suket" type="text" placeholder="Instansi Suket">

              <field-messages name="instansi_suket" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Instansi Suket is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="model-no_suket">Nomor Suket</label>
              <input class="form-control" v-model="model.no_suket" required autofocus name="no_suket" type="text" placeholder="Nomor Suket">

              <field-messages name="no_suket" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Nomor Suket is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="model-nilai_sktm">Nilai SKTM</label>
              <input class="form-control" v-model="model.nilai_sktm" required autofocus name="nilai_sktm" type="text" placeholder="Nilai SKTM">

              <field-messages name="nilai_sktm" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Nilai SKTM is a required field</small>
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
    axios.get('api/sktm/' + this.$route.params.id + '/edit')
      .then(response => {
        if (response.data.status == true) {
          this.model.user = response.data.user,
          this.model.nomor_un = response.data.sktm.nomor_un;
          this.model.kode_sktm = response.data.sktm.kode_sktm;
          this.model.nama_suket = response.data.sktm.nama_suket;
          this.model.instansi_suket = response.data.sktm.instansi_suket;
          this.model.no_suket = response.data.sktm.no_suket;
          this.model.nilai_sktm = response.data.sktm.nilai_sktm;
        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/sktm/';
      }),

      axios.get('api/sktm/create')
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
        nomor_un: "",
        kode_sktm: "",
        nama_suket: "",
        instansi_suket: "",
        no_suket: "",
        nilai_sktm: ""
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
        axios.put('api/sktm/' + this.$route.params.id, {
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
      axios.get('api/sktm/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.status == true) {
            this.model.nomor_un = response.data.sktm.nomor_un;
          this.model.kode_sktm = response.data.sktm.kode_sktm;
          this.model.nama_suket = response.data.sktm.nama_suket;
          this.model.instansi_suket = response.data.sktm.instansi_suket;
          this.model.no_suket = response.data.sktm.no_suket;
          this.model.nilai_sktm = response.data.sktm.nilai_sktm;
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
