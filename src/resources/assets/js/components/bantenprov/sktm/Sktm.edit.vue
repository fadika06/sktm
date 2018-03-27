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
            <label for="master_sktm_id">Master SKTM</label>
            <v-select name="master_sktm_id" v-model="model.master_sktm" :options="master_sktm" class="mb-4"></v-select>

            <field-messages name="master_sktm_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Master SKTM is a required field</small>
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
              <label for="model-no_sktm">Nomor SKTM</label>
              <input class="form-control" v-model="model.no_sktm" required autofocus name="no_sktm" type="text" placeholder="Nomor SKTM">

              <field-messages name="no_sktm" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Nomor SKTM is a required field</small>
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
          this.model.user = response.data.user;
          this.model.master_sktm = response.data.master_sktm;
          this.model.nomor_un = response.data.sktm.nomor_un;
          this.model.no_sktm = response.data.sktm.no_sktm;
          this.model.nilai = response.data.sktm.nilai;
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
          response.data.master_sktm.forEach(element => {
            this.master_sktm.push(element);
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
        master_sktm: "",
        nomor_un: "",
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
        axios.put('api/sktm/' + this.$route.params.id, {
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
      axios.get('api/sktm/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.status == true) {
            this.model.nomor_un = response.data.sktm.nomor_un;
          this.model.no_sktm = response.data.sktm.no_sktm;
          this.model.nilai = response.data.sktm.nilai;
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
