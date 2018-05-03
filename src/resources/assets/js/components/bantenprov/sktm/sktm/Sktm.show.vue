<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> {{ title }}

      <div class="btn-group pull-right" role="group" style="display:flex;">
        <button class="btn btn-primary btn-sm" role="button" @click="createRow">
          <i class="fa fa-plus" aria-hidden="true"></i>
        </button>
        <button class="btn btn-warning btn-sm" role="button" @click="editRow">
          <i class="fa fa-pencil" aria-hidden="true"></i>
        </button>
        <button class="btn btn-danger btn-sm" role="button" @click="deleteRow">
          <i class="fa fa-trash" aria-hidden="true"></i>
        </button>
        <button class="btn btn-primary btn-sm" role="button" @click="back">
          <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </button>
      </div>
    </div>

    <div class="card-body">
      <dl class="row">
          <dt class="col-4">Nomor UN</dt>
          <dd class="col-8">{{ model.nomor_un }}</dd>

          <dt class="col-4">Nama Siswa</dt>
          <dd class="col-8">{{ model.siswa.nama_siswa }}</dd>

          <dt class="col-4">Kriteria SKTM</dt>
          <dd class="col-8">{{ model.master_sktm.nama }}</dd>

          <dt class="col-4">No SKTM</dt>
          <dd class="col-8">{{ model.no_sktm }}</dd>

          <dt class="col-4">Nilai</dt>
          <dd class="col-8">{{ model.nilai }}</dd>
      </dl>
    </div>

    <div class="card-footer text-muted">
      <div class="row">
        <div class="col-md">
          <b>Username :</b> {{ model.user.name }}
        </div>
        <div class="col-md">
          <div class="col-md text-right">Dibuat : {{ model.created_at }}</div>
          <div class="col-md text-right">Diperbarui : {{ model.updated_at }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import swal from 'sweetalert2';

export default {
  data() {
    return {
      state: {},
      title: 'View SKTM',
      model: {
        nomor_un        : '',
        master_sktm_id  : '',
        no_sktm         : '',
        nilai           : '',
        user_id         : '',
        created_at      : '',
        updated_at      : '',

        siswa           : [],
        master_sktm     : [],
        user            : [],
      },
    }
  },
  mounted() {
    let app = this;

    axios.get('api/sktm/'+this.$route.params.id)
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.model.nomor_un       = response.data.sktm.nomor_un;
          this.model.master_sktm_id = response.data.sktm.master_sktm_id;
          this.model.no_sktm        = response.data.sktm.no_sktm;
          this.model.nilai          = response.data.sktm.nilai;
          this.model.user_id        = response.data.sktm.user_id;
          this.model.created_at     = response.data.sktm.created_at;
          this.model.updated_at     = response.data.sktm.updated_at;

          this.model.siswa          = response.data.sktm.siswa;
          this.model.master_sktm    = response.data.sktm.master_sktm;
          this.model.user           = response.data.sktm.user;

          if (this.model.siswa === null) {
            this.model.siswa = {
              'id'         : this.model.nomor_un,
              'nama_siswa' : ''
            };
          }

          if (this.model.master_sktm === null) {
            this.model.master_sktm = {
              'id'    : this.model.master_sktm_id,
              'nama'  : ''
            };
          }

          if (this.model.user === null) {
            this.model.user = {
              'id'    : this.model.user_id,
              'name'  : ''
            };
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
  },
  methods: {
    createRow() {
      window.location = '#/admin/sktm/create';
    },
    editRow() {
      window.location = '#/admin/sktm/'+this.$route.params.id+'/edit';
    },
    deleteRow() {
      let app = this;

      swal({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
          axios.delete('/api/sktm/'+this.$route.params.id)
            .then(function(response) {
              if (response.data.status == true) {
                app.back();

                swal(
                  'Deleted',
                  'Yeah!!! Your data has been deleted.',
                  'success'
                );
              } else {
                swal(
                  'Failed',
                  'Oops... Failed to delete data.',
                  'error'
                );
              }
            })
            .catch(function(response) {
              swal(
                'Not Found',
                'Oops... Your page is not found.',
                'error'
              );
            });
        } else if (result.dismiss === swal.DismissReason.cancel) {
          swal(
            'Cancelled',
            'Your data is safe.',
            'error'
          );
        }
      });
    },
    back() {
      window.location = '#/admin/sktm';
    }
  }
}
</script>