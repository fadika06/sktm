<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Add SKTM

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
              <small class="form-text text-danger" slot="required">username is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

    <validate tag="div">
          <div class="form-group">
            <label for="model-nomor_un">Nomor UN</label>
            <input type="text" class="form-control" id="model-nomor_un" v-model="model.nomor_un" name="nomor_un" placeholder="Nomor UN" required autofocus>
            <field-messages name="nomor_un" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Nomor UN is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="model-kode_sktm">Kode SKTM</label>
            <input type="text" class="form-control" id="model-kode_sktm" v-model="model.kode_sktm" name="kode_sktm" placeholder="Kode SKTM" required autofocus>
            <field-messages name="kode_sktm" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Kode SKTM is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="model-nama_suket">Nama Suket</label>
            <input type="text" class="form-control" id="model-nama_suket" v-model="model.nama_suket" name="nama_suket" placeholder="Nama Suket" required autofocus>
            <field-messages name="nama_suket" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Nama Suket is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="model-instansi_suket">Instansi Suket</label>
            <input type="text" class="form-control" id="model-instansi_suket" v-model="model.instansi_suket" name="instansi_suket" placeholder="Instansi Suket" required autofocus>
            <field-messages name="instansi_suket" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Instansi Suket is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="model-no_suket">Nomor Suket</label>
            <input type="text" class="form-control" id="model-no_suket" v-model="model.no_suket" name="no_suket" placeholder="Nomor Suket" required autofocus>
            <field-messages name="no_suket" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Nomor Suket is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="model-nilai_sktm">Nilai SKTM</label>
            <input type="text" class="form-control" id="model-nilai_sktm" v-model="model.nilai_sktm" name="nilai_sktm" placeholder="Nilai SKTM" required autofocus>
            <field-messages name="nilai_sktm" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Nilai SKTM is a required field</small>
            </field-messages>
          </div>
        </validate>

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
  mounted(){
    axios.get('api/sktm/create/')
    .then(response => {
        response.data.user.forEach(user_element => {
            this.user.push(user_element);
        });
    })
    .catch(function(response) {
      alert('Break');
    });
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
        axios.post('api/sktm/', {
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
      this.model = {
        nomor_un: "",
        kode_sktm: "",
        nama_suket: "",
        instansi_suket: "",
        no_suket: "",
        nilai_sktm: ""
      };
    },
    back() {
      window.location = '#/admin/sktm/';
    }
  }
}
</script>
