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
              <small class="form-text text-danger" slot="required">Username is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="master_sktm_id">Master SKTM</label>
            <v-select name="master_sktm_id" v-model="model.master_sktm" :options="master_sktm" class="mb-4"></v-select>

            <field-messages name="master_sktm_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Master SKTM is a required field</small>
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
            <label for="model-no_sktm">Nomor SKTM</label>
            <input type="text" class="form-control" id="model-no_sktm" v-model="model.no_sktm" name="no_sktm" placeholder="Nomor SKTM" required autofocus>
            <field-messages name="no_sktm" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Nomor SKTM is a required field</small>
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
        response.data.master_sktm.forEach(element => {
            this.master_sktm.push(element);
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
        master_sktm: "",
        no_sktm: "",
        nilai: ""
      },
      user: [],
      master_sktm: []
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
            master_sktm_id: this.model.master_sktm.id,
            no_sktm: this.model.no_sktm,
            nilai: this.model.nilai
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
        no_sktm: "",
        nilai: ""
      };
    },
    back() {
      window.location = '#/admin/sktm/';
    }
  }
}
</script>
