<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> {{ title }}

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
              <label for="nomor_un">Siswa</label>
              <v-select name="nomor_un" v-model="model.siswa" :options="siswa" placeholder="Siswa" required autofocus></v-select>

              <field-messages name="nomor_un" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Siswa is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="master_sktm_id">Kriteria SKTM</label>
              <v-select name="master_sktm_id" v-model="model.master_sktm" :options="master_sktm" placeholder="Kriteria SKTM" required></v-select>

              <field-messages name="master_sktm_id" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Kriteria SKTM is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="no_sktm">No SKTM</label>
              <input type="text" class="form-control" name="no_sktm" v-model="model.no_sktm" placeholder="No SKTM" required autofocus>

              <field-messages name="no_sktm" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">No SKTM is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <!-- <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="nilai">Nilai</label>
              <input type="text" class="form-control" name="nilai" v-model="model.nilai" placeholder="Nilai" required autofocus>

              <field-messages name="nilai" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Nilai is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div> -->

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="user_id">Username</label>
              <v-select name="user_id" v-model="model.user" :options="user" placeholder="Username" required></v-select>

              <field-messages name="user_id" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">User is a required field</small>
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
import swal from 'sweetalert2';

export default {
  data() {
    return {
      state: {},
      title: 'Add SKTM',
      model: {
        nomor_un        : '',
        master_sktm_id  : '',
        no_sktm         : '',
        nilai           : '',
        user_id         : '',
        created_at      : '',
        updated_at      : '',

        siswa           : '',
        master_sktm     : '',
        user            : '',
      },
      siswa       : [],
      master_sktm : [],
      user        : [],
    }
  },
  mounted(){
    let app = this;

    axios.get('api/sktm/create')
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.model.user = response.data.current_user;

          if(response.data.user_special == true){
            this.user = response.data.users;
          }else{
            this.user.push(response.data.users);
          }
        } else {
          swal(
            'Failed',
            'Oops... '+response.data.message,
            'error'
          );

          app.back();
        }
      })
      .catch(function(response) {
        swal(
          'Not Found',
          'Oops... Your page is not found.',
          'error'
        );

        app.back();
      });

    axios.get('api/siswa/get')
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.siswa = response.data.siswas;
        } else {
          swal(
            'Failed',
            'Oops... '+response.data.message,
            'error'
          );

          app.back();
        }
      })
      .catch(function(response) {
        swal(
          'Not Found',
          'Oops... Your page is not found.',
          'error'
        );

        app.back();
      });

    axios.get('api/master-sktm/get')
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.master_sktm = response.data.master_sktms;
        } else {
          swal(
            'Failed',
            'Oops... '+response.data.message,
            'error'
          );

          app.back();
        }
      })
      .catch(function(response) {
        swal(
          'Not Found',
          'Oops... Your page is not found.',
          'error'
        );

        app.back();
      });
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.post('api/sktm', {
            nomor_un        : this.model.siswa.nomor_un,
            master_sktm_id  : this.model.master_sktm.id,
            no_sktm         : this.model.no_sktm,
            nilai           : this.model.nilai,
            user_id         : this.model.user.id,
          })
          .then(response => {
            if (response.data.status == true) {
              if(response.data.error == false){
                swal(
                  'Created',
                  'Yeah!!! Your data has been created.',
                  'success'
                );

                app.back();
              }else{
                swal(
                  'Failed',
                  'Oops... '+response.data.message,
                  'error'
                );
              }
            } else {
              swal(
                'Failed',
                'Oops... '+response.data.message,
                'error'
              );

              app.back();
            }
          })
          .catch(function(response) {
            swal(
              'Not Found',
              'Oops... Your page is not found.',
              'error'
            );

            app.back();
          });
      }
    },
    reset() {
      this.model = {
        nomor_un        : '',
        master_sktm_id  : '',
        no_sktm         : '',
        nilai           : '',
        user_id         : '',
        created_at      : '',
        updated_at      : '',

        siswa           : '',
        master_sktm     : '',
        user            : '',
      };
    },
    back() {
      window.location = '#/admin/sktm';
    }
  }
}
</script>
