<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Add Master SKTM

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

    <validate tag="div">
          <div class="form-group">
            <label for="model-nama">Nama</label>
            <input type="text" class="form-control" id="model-nama" v-model="model.nama" name="nama" placeholder="Nama" required autofocus>
            <field-messages name="nama" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Nama is a required field</small>
            </field-messages>
          </div>
        </validate>

         <validate tag="div">
          <div class="form-group">
            <label for="model-nilai">Nilai</label>
            <input type="text" class="form-control" id="model-nilai" v-model="model.nilai" name="nilai" placeholder="Nilai" required autofocus>
            <field-messages name="nilai" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Nilai is a required field</small>
            </field-messages>
          </div>
        </validate>

         <validate tag="div">
          <div class="form-group">
            <label for="model-instansi">Instansi</label>
            <input type="text" class="form-control" id="model-instansi" v-model="model.instansi" name="instansi" placeholder="Instansi" required autofocus>
            <field-messages name="instansi" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Instansi is a required field</small>
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
    axios.get('api/master-sktm/create')
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
        axios.post('api/master-sktm/', {
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
      this.model = {
          nama: "",
          nilai: "",
          instansi: ""
      };
    },
    back() {
      window.location = '#/admin/master-sktm/';
    }
  }
}
</script>
